<?php

namespace App\Models;

use App\Models\Unit;

class PurchaseOrderItem extends Model
{
    protected $fillable = [
        'purchase_order_id', 'product_id', 'unit', 'pcs_per_box', 'ordered_qty', 'received_qty', 'returned_qty', 'unit_cost', 'line_total',
    ];

    public function purchaseOrder()
    {
        return $this->belongsTo(PurchaseOrder::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function pendingQty(): int
    {
        return max(0, (int) $this->ordered_qty - (int) $this->received_qty);
    }

    public function unitLabel(): string
    {
        return Unit::label($this->unit);
    }

    public function toBaseQty(int $qty): int
    {
        return Product::convertToPcs($qty, $this->unit, (int) ($this->pcs_per_box ?: 1));
    }

    public function costPerPc(): float
    {
        return Product::costPerPc((float) $this->unit_cost, $this->unit, (int) ($this->pcs_per_box ?: 1));
    }
}
