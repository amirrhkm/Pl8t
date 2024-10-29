<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesDaily extends Model
{
    use HasFactory;

    protected $table = 'sales_daily';

    protected $fillable = [
        'date',
        'total_eod',
        'total_expenses',
        'total_bankin',
        'total_earning',
        'total_balance',
    ];
}
