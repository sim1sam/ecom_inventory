<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomePageOneVisibility extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'product_section_status',
        'product_qty',
        'category_section_status',
        'category_qty',
        'flash_sale_section_status',
        'service_section_status',
        'testimonial_section_status',
        'blog_section_status'
    ];
}
