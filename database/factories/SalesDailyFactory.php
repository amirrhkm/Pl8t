<?php

namespace Database\Factories;

use App\Models\SalesDaily;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SalesDaily>
 */
class SalesDailyFactory extends Factory
{
    protected $model = SalesDaily::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        static $date = '2024-01-01';

        return [
            'date' => $date,
            'total_eod' => 0,
            'total_expenses' => 0,
            'total_bankin' => 0,
            'total_earning' => 0,
            'total_balance' => 0,
        ];
    }

    public function incrementDate()
    {
        return $this->state(function (array $attributes) {
            $currentDate = Carbon\Carbon::parse($attributes['date']);
            $nextDate = $currentDate->addDay()->format('Y-m-d');
            return ['date' => $nextDate];
        });
    }
}
