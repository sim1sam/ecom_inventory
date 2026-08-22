<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderAddress extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'billing_name',
        'billing_email',
        'billing_phone',
        'billing_address',
        'billing_country',
        'billing_state',
        'billing_city',
        'billing_address_type',
        'shipping_name',
        'shipping_email',
        'shipping_phone',
        'shipping_address',
        'shipping_country',
        'shipping_state',
        'shipping_city',
        'shipping_address_type',
        'delivery_area',
    ];
}
