<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    const TYPE = [
        'ambient' => 'Ambient',
        'fuji_loaf' => 'Fuji Loaf',
        'vtc' => 'VTC',
        'frozen' => 'Frozen',
        'mcqwin' => 'MCQWIN',
        'soda_express' => 'Soda Express',
        'small_utilities' => 'Small Utilities',
        'mc2_water_filter' => 'MC2 Water Filter',
        'other' => 'Other',
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
        'remarks',
        'estimation_days_to_receive',
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
