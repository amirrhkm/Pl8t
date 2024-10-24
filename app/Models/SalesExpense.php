<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesExpense extends Model
{
    use HasFactory;

    protected $table = 'sales_expenses';
    protected $fillable = [
        'date',
        'description',
        'amount',
    ];

    public function salesCumulative()
    {
        return $this->hasOne(SalesCumulative::class);
    }
}
