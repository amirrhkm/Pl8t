<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesEod extends Model
{
    use HasFactory;

    protected $table = 'sales_eods';

    protected $fillable = [
        'date',
        'debit',
        'visa',
        'master',
        'cash',
        'ewallet',
        'foodpanda',
        'grabfood',
        'shopeefood',
        'prepaid',
        'voucher',
        'total_sales',
        'amount_to_bank_in',
        'cash_difference',
    ];

    public function expenses()
    {
        return $this->hasOne(SalesEodExpense::class);
    }

    public function salesCumulative()
    {
        return $this->hasOne(SalesCumulative::class);
    }
}
