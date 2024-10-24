<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesEodExpense extends Model
{
    use HasFactory;

    protected $table = 'sales_eod_expenses';

    protected $fillable = [
        'sales_eod_id',
        'date',
        'expenses_1',
        'amount_1',
        'expenses_2',
        'amount_2',
        'expenses_3',
        'amount_3',
        'expenses_4',
        'amount_4',
        'expenses_5',
        'amount_5',
        'expenses_6',
        'amount_6',
        'expenses_7',
        'amount_7',
        'expenses_8',
        'amount_8',
    ];

    public function salesEod()
    {
        return $this->belongsTo(SalesEod::class);
    }
}
