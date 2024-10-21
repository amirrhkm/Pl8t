<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    const TYPE = [
        'fuji_bun' => 'Fuji Bun',
        'fuji_loaf' => 'Fuji Loaf',
        'vtc' => 'VTC',
        'daq' => 'DAQ',
        'agl' => 'AGL',
        'soda_express' => 'Soda Express',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'do_id',
        'submit_date',
        'receive_date',
        'total_amount',
        'status',
        'type',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'submit_date' => 'date',
        'receive_date' => 'date',
        'total_amount' => 'decimal:2',
    ];

    public function formattedType()
    {
        return self::TYPE[$this->type] ?? $this->type;
    }
}
