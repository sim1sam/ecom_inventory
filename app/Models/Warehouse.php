<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'phone',
        'address',
        'is_default',
        'status',
    ];

    public function stocks()
    {
        return $this->hasMany(WarehouseStock::class);
    }

    public function movements()
    {
        return $this->hasMany(StockMovement::class);
    }
}
