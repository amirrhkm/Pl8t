<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'employment_type', 'position', 'rate'];

    public function shifts()
    {
        return $this->hasMany(Shift::class);
    }

    public function salaries()
    {
        return $this->hasMany(Salary::class);
    }
}
