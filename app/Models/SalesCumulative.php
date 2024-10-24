<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesCumulative extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'total_bankin_amount',
        'sales_eod_id',
        'sales_bankin_id',
        'sales_expense_id',
        'sales_earning_id',
    ];

    public function salesEod()
    {
        return $this->belongsTo(SalesEod::class);
    }

    public function salesBankin()
    {
        return $this->belongsTo(SalesBankin::class);
    }

    public function salesExpense()
    {
        return $this->belongsTo(SalesExpense::class);
    }

    public function salesEarning()
    {
        return $this->belongsTo(SalesEarning::class);
    }
}
