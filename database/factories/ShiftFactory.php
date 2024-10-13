<?php

namespace Database\Factories;

use App\Models\Shift;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

class ShiftFactory extends Factory
{
    protected $model = Shift::class;

    public function definition()
    {
        static $date = '2024-01-01';

        return [
            'staff_id' => 1,
            'date' => $date,
            'start_time' => '07:30:00',
            'end_time' => '16:00:00',
            'break_duration' => 1,
            'total_hours' => 7.5,
            'overtime_hours' => 0,
            'is_public_holiday' => false,
        ];
    }

    public function incrementDate()
    {
        return $this->state(function (array $attributes) {
            $currentDate = Carbon::parse($attributes['date']);
            $nextDate = $currentDate->addDay()->format('Y-m-d');
            return ['date' => $nextDate];
        });
    }
}