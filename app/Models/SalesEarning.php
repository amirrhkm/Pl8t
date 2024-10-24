<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesEarning extends Model
{
    use HasFactory;

    protected $table = 'sales_earnings';

    protected $fillable = [
        'date',
        'description',
        'amount',
    ];
}