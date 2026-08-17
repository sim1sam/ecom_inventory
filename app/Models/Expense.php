<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $fillable = [
        'expense_number',
        'expense_category_id',
        'title',
        'amount',
        'expense_date',
        'payment_method',
        'reference',
        'notes',
        'created_by',
    ];

    protected $casts = [
        'expense_date' => 'date',
        'amount' => 'float',
    ];

    public const PAYMENT_METHODS = [
        'cash' => 'Cash',
        'bank' => 'Bank',
        'card' => 'Card',
        'mobile' => 'Mobile Banking',
        'cheque' => 'Cheque',
        'other' => 'Other',
    ];

    public function category()
    {
        return $this->belongsTo(ExpenseCategory::class, 'expense_category_id');
    }

    public function creator()
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }

    public function paymentMethodLabel(): string
    {
        return self::PAYMENT_METHODS[$this->payment_method] ?? ucfirst((string) $this->payment_method);
    }

    public static function generateNumber(): string
    {
        return 'EXP-'.date('Ymd').'-'.str_pad((string) random_int(1, 9999), 4, '0', STR_PAD_LEFT);
    }
}
