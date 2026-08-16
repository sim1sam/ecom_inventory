<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FlashSale extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'title',
        'description',
        'homepage_image',
        'flashsale_page_image',
        'end_time',
        'offer',
        'status',
        'background_color'
    ];
}
