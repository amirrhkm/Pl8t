<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Salary extends Model
{
    use HasFactory;

    protected $fillable = ['staff_id', 'month', 'year', 'total_reg_hours', 'total_reg_ot_hours', 'total_ph_hours', 'total_ph_ot_hours', 'total_salary'];

    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }
}
