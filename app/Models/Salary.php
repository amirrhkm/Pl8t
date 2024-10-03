<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Salary extends Model
{
    use HasFactory;

    protected $fillable = ['staff_id', 'month', 'year', 'total_hours', 'total_overtime_hours', 'total_public_holiday_hours', 'total_salary'];

    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }
}
