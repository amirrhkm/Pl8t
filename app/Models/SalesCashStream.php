<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesCashStream extends Model
{
    use HasFactory;

    protected $table = 'sales_cash_stream';

    protected $fillable = [
        'date',
        'amount',
    ];
}
