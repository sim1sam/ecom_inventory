<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Footer extends Model
{
    use HasFactory;

    protected $fillable = [
        'background_image',
        'card_image',
        'email',
        'phone',
        'address',
        'first_column',
        'second_column',
        'third_column',
        'copyright',
        'footer_color'
    ];
}
