<?php

namespace Database\Seeders;

use App\Models\Staff;
use App\Models\Shift;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Staff::factory()->count(1)->create();
        Shift::factory()
            ->count(365)
            ->sequence(fn ($sequence) => ['date' => Carbon::createFromFormat('Y-m-d', '2024-01-01')
            ->addDays($sequence->index)->format('Y-m-d')])
            ->create();
    }
}
