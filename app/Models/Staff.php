<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'nickname', 'employment_type', 'position', 'rate'];

    const EMPLOYMENT_TYPES = [
        'part_time' => 'Part-time',
        'full_time' => 'Full-time',
    ];

    const POSITIONS = [
        'bar' => 'Barista',
        'kitchen' => 'Kitchen Crew',
        'flexible' => 'Barista + Kitchen Crew',
    ];

    public function shifts()
    {
        return $this->hasMany(Shift::class);
    }

    public function salaries()
    {
        return $this->hasMany(Salary::class);
    }

    public function formattedEmploymentType()
    {
        return self::EMPLOYMENT_TYPES[$this->employment_type] ?? $this->employment_type;
    }

    public function formattedPosition()
    {
        return self::POSITIONS[$this->position] ?? $this->position;
    }
}
