<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wastage extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'item',
        'quantity',
        'weight',
        'reason',
    ];

    protected $casts = [
        'date' => 'date',
        'quantity' => 'integer',
        'weight' => 'decimal:3',
    ];
}