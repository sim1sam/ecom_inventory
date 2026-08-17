<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExpenseCategory extends Model
{
    protected $fillable = ['name', 'status'];

    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }

    public static function activeCategories()
    {
        return static::where('status', 1)->orderBy('name')->get();
    }
}
