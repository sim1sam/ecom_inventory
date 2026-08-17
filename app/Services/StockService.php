<?php

namespace App\Services;

use App\Models\Product;
use App\Models\StockMovement;
use App\Models\Warehouse;
use App\Models\WarehouseStock;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

class StockService
{
    public function getDefaultWarehouse(): Warehouse
    {
        $warehouse = Warehouse::where('is_default', 1)->where('status', 1)->first();

        if (!$warehouse) {
            $warehouse = Warehouse::where('status', 1)->first();
        }

        if (!$warehouse) {
            $warehouse = Warehouse::create([
                'name' => 'Default Warehouse',
                'code' => 'WH-001',
                'is_default' => 1,
                'status' => 1,
            ]);
        }

        return $warehouse;
    }

    public function ensureWarehouseStock(int $productId, ?int $warehouseId = null): WarehouseStock
    {
        $warehouseId = $warehouseId ?: $this->getDefaultWarehouse()->id;

        return WarehouseStock::firstOrCreate(
            ['warehouse_id' => $warehouseId, 'product_id' => $productId],
            ['qty' => 0]
        );
    }

    public function syncProductQty(int $productId): void
    {
        $total = WarehouseStock::where('product_id', $productId)->sum('qty');
        Product::where('id', $productId)->update(['qty' => (int) $total]);
    }

    public function generateBarcode(Product $product): string
    {
        $barcode = 'P'.str_pad((string) $product->id, 10, '0', STR_PAD_LEFT);
        $product->barcode = $barcode;
        $product->save();

        return $barcode;
    }

    public function stockIn(
        int $productId,
        int $warehouseId,
        int $qty,
        ?string $note = null,
        ?string $referenceNo = null,
        ?int $adminId = null,
        string $reason = 'stock_in',
        ?string $referenceType = null,
        ?int $referenceId = null,
        ?int $supplierId = null,
        ?float $unitCost = null
    ): StockMovement {
        if ($qty <= 0) {
            throw new InvalidArgumentException('Quantity must be greater than zero.');
        }

        return DB::transaction(function () use (
            $productId, $warehouseId, $qty, $note, $referenceNo, $adminId,
            $reason, $referenceType, $referenceId, $supplierId, $unitCost
        ) {
            $stock = $this->ensureWarehouseStock($productId, $warehouseId);
            $before = (int) $stock->qty;
            $after = $before + $qty;

            $stock->qty = $after;
            $stock->save();

            $this->syncProductQty($productId);

            if ($unitCost !== null && $unitCost > 0) {
                Product::where('id', $productId)->update(['cost_price' => $unitCost]);
            }

            return StockMovement::create([
                'product_id' => $productId,
                'warehouse_id' => $warehouseId,
                'type' => 'in',
                'reason' => $reason,
                'qty' => $qty,
                'qty_before' => $before,
                'qty_after' => $after,
                'reference_no' => $referenceNo,
                'reference_type' => $referenceType,
                'reference_id' => $referenceId,
                'supplier_id' => $supplierId,
                'unit_cost' => $unitCost,
                'note' => $note,
                'admin_id' => $adminId,
            ]);
        });
    }

    public function stockOut(
        int $productId,
        int $warehouseId,
        int $qty,
        string $reason = 'stock_out',
        ?string $note = null,
        ?string $referenceNo = null,
        ?int $adminId = null,
        ?string $referenceType = null,
        ?int $referenceId = null,
        ?int $supplierId = null
    ): StockMovement {
        if ($qty <= 0) {
            throw new InvalidArgumentException('Quantity must be greater than zero.');
        }

        return DB::transaction(function () use (
            $productId, $warehouseId, $qty, $reason, $note, $referenceNo, $adminId,
            $referenceType, $referenceId, $supplierId
        ) {
            $stock = $this->ensureWarehouseStock($productId, $warehouseId);
            $before = (int) $stock->qty;

            if ($before < $qty) {
                throw new InvalidArgumentException('Insufficient stock in warehouse.');
            }

            $after = $before - $qty;
            $stock->qty = $after;
            $stock->save();

            $this->syncProductQty($productId);

            return StockMovement::create([
                'product_id' => $productId,
                'warehouse_id' => $warehouseId,
                'type' => 'out',
                'reason' => $reason,
                'qty' => $qty,
                'qty_before' => $before,
                'qty_after' => $after,
                'reference_no' => $referenceNo,
                'reference_type' => $referenceType,
                'reference_id' => $referenceId,
                'supplier_id' => $supplierId,
                'note' => $note,
                'admin_id' => $adminId,
            ]);
        });
    }

    public function adjust(int $productId, int $warehouseId, int $newQty, ?string $note = null, ?int $adminId = null): StockMovement
    {
        if ($newQty < 0) {
            throw new InvalidArgumentException('Quantity cannot be negative.');
        }

        return DB::transaction(function () use ($productId, $warehouseId, $newQty, $note, $adminId) {
            $stock = $this->ensureWarehouseStock($productId, $warehouseId);
            $before = (int) $stock->qty;
            $diff = $newQty - $before;

            $stock->qty = $newQty;
            $stock->save();

            $this->syncProductQty($productId);

            return StockMovement::create([
                'product_id' => $productId,
                'warehouse_id' => $warehouseId,
                'type' => 'adjustment',
                'reason' => 'adjustment',
                'qty' => abs($diff),
                'qty_before' => $before,
                'qty_after' => $newQty,
                'note' => $note,
                'admin_id' => $adminId,
            ]);
        });
    }

    public function transfer(int $productId, int $fromWarehouseId, int $toWarehouseId, int $qty, ?string $note = null, ?int $adminId = null): array
    {
        if ($fromWarehouseId === $toWarehouseId) {
            throw new InvalidArgumentException('Source and destination warehouses must be different.');
        }

        if ($qty <= 0) {
            throw new InvalidArgumentException('Quantity must be greater than zero.');
        }

        return DB::transaction(function () use ($productId, $fromWarehouseId, $toWarehouseId, $qty, $note, $adminId) {
            $out = $this->stockOut($productId, $fromWarehouseId, $qty, 'transfer_out', $note, null, $adminId);
            $in = $this->stockIn($productId, $toWarehouseId, $qty, $note, null, $adminId, 'transfer_in');

            $out->update(['related_id' => $in->id]);
            $in->update(['related_id' => $out->id]);

            return ['out' => $out, 'in' => $in];
        });
    }

    public function openingStock(int $productId, int $warehouseId, int $qty, ?float $unitCost = null, ?int $adminId = null): StockMovement
    {
        return $this->stockIn(
            $productId,
            $warehouseId,
            $qty,
            'Opening stock',
            'OPEN-'.$productId,
            $adminId,
            'opening_stock',
            'product',
            $productId,
            null,
            $unitCost
        );
    }
}
