<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesBankin extends Model
{
    use HasFactory;

    protected $table = 'sales_bankins';
    
    protected $fillable = [
        'date',
        'bank_name',
        'time',
        'amount',
    ];

    public function salesCumulative()
    {
        return $this->hasOne(SalesCumulative::class);
    }
}
