<?php

namespace App\Services;

use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use App\Models\PurchaseReceipt;
use App\Models\PurchaseReceiptItem;
use App\Models\PurchaseReturn;
use App\Models\PurchaseReturnItem;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

class PurchaseService
{
    public function __construct(protected StockService $stockService)
    {
    }

    public function generateNumber(string $prefix): string
    {
        return $prefix.'-'.date('Ymd').'-'.str_pad((string) random_int(1, 9999), 4, '0', STR_PAD_LEFT);
    }

    public function recalculateOrder(PurchaseOrder $order): void
    {
        $order->load('items');
        $subtotal = $order->items->sum('line_total');
        $order->update([
            'subtotal' => $subtotal,
            'total' => $subtotal + $order->tax - $order->discount,
        ]);
        $this->refreshOrderStatus($order);
    }

    public function refreshOrderStatus(PurchaseOrder $order): void
    {
        $order->load('items');
        $ordered = $order->items->sum('ordered_qty');
        $received = $order->items->sum('received_qty');

        if ($received <= 0) {
            $status = in_array($order->status, ['submitted', 'partial']) ? 'submitted' : $order->status;
        } elseif ($received >= $ordered) {
            $status = 'received';
        } else {
            $status = 'partial';
        }

        if ($order->status !== 'draft' && $order->status !== 'cancelled') {
            $order->update(['status' => $status]);
        }
    }

    public function receivePurchaseOrder(PurchaseOrder $order, array $lines, ?string $notes, int $adminId): PurchaseReceipt
    {
        if (!in_array($order->status, ['submitted', 'partial', 'received'])) {
            throw new InvalidArgumentException('Purchase order cannot be received in current status.');
        }

        return DB::transaction(function () use ($order, $lines, $notes, $adminId) {
            $receipt = PurchaseReceipt::create([
                'receipt_number' => $this->generateNumber('GRN'),
                'purchase_order_id' => $order->id,
                'warehouse_id' => $order->warehouse_id,
                'status' => 'posted',
                'receipt_date' => now()->toDateString(),
                'notes' => $notes,
                'received_by' => $adminId,
            ]);

            foreach ($lines as $line) {
                $item = PurchaseOrderItem::with('product')->where('purchase_order_id', $order->id)
                    ->where('id', $line['item_id'])
                    ->firstOrFail();
                $qty = (int) $line['qty'];

                if ($qty <= 0) {
                    continue;
                }

                if ($qty > $item->pendingQty()) {
                    throw new InvalidArgumentException('Receive quantity exceeds pending quantity.');
                }

                PurchaseReceiptItem::create([
                    'purchase_receipt_id' => $receipt->id,
                    'purchase_order_item_id' => $item->id,
                    'product_id' => $item->product_id,
                    'received_qty' => $qty,
                    'unit_cost' => $item->unit_cost,
                ]);

                $item->increment('received_qty', $qty);

                $pcCost = $item->costPerPc();

                $this->stockService->stockIn(
                    $item->product_id,
                    $order->warehouse_id,
                    $item->toBaseQty($qty),
                    'Purchase received',
                    $receipt->receipt_number,
                    $adminId,
                    'po_receive',
                    'purchase_receipt',
                    $receipt->id,
                    $order->supplier_id,
                    $pcCost > 0 ? $pcCost : null
                );

                if ($pcCost > 0) {
                    Product::where('id', $item->product_id)->update(['cost_price' => $pcCost]);
                }
            }

            $this->recalculateOrder($order->fresh());

            return $receipt;
        });
    }

    public function createRtv(array $data, array $lines, int $adminId): PurchaseReturn
    {
        return DB::transaction(function () use ($data, $lines, $adminId) {
            $return = PurchaseReturn::create([
                'return_number' => $this->generateNumber('RTV'),
                'supplier_id' => $data['supplier_id'],
                'warehouse_id' => $data['warehouse_id'],
                'purchase_order_id' => $data['purchase_order_id'] ?? null,
                'status' => 'posted',
                'return_date' => $data['return_date'] ?? now()->toDateString(),
                'reason' => $data['reason'] ?? null,
                'notes' => $data['notes'] ?? null,
                'created_by' => $adminId,
            ]);

            foreach ($lines as $line) {
                $qty = (int) $line['qty'];
                if ($qty <= 0) {
                    continue;
                }

                $unit = Product::normalizeUnit($line['unit'] ?? 'pc');
                $pcsPerBox = max(1, (int) ($line['pcs_per_box'] ?? 1));
                $stockQty = Product::convertToPcs($qty, $unit, $pcsPerBox);

                PurchaseReturnItem::create([
                    'purchase_return_id' => $return->id,
                    'product_id' => $line['product_id'],
                    'purchase_order_item_id' => $line['purchase_order_item_id'] ?? null,
                    'unit' => $unit,
                    'pcs_per_box' => $pcsPerBox,
                    'qty' => $qty,
                    'unit_cost' => (float) ($line['unit_cost'] ?? 0),
                ]);

                $this->stockService->stockOut(
                    (int) $line['product_id'],
                    (int) $data['warehouse_id'],
                    $stockQty,
                    'rtv',
                    $data['reason'] ?? 'Return to vendor',
                    $return->return_number,
                    $adminId,
                    'purchase_return',
                    $return->id,
                    (int) $data['supplier_id']
                );

                if (!empty($line['purchase_order_item_id'])) {
                    PurchaseOrderItem::where('id', $line['purchase_order_item_id'])->increment('returned_qty', $qty);
                }
            }

            return $return;
        });
    }
}
