<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use App\Models\Shift;
use App\Models\Salary;
use Illuminate\Http\Request;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function index()
    {
        try {
            $totalStaff = Staff::where('name', '!=', 'admin')->count();

            $partTimeStaff = Staff::where('employment_type', 'part_time')->count();

            $fullTimeStaff = Staff::where('employment_type', 'full_time')->where('name', '!=', 'admin')->count();
            
            $activeShiftsToday = Shift::whereDate('date', today())
                ->count()-1;
            
            $totalHoursThisMonth = Shift::whereMonth('date', now()->month)
                ->whereYear('date', now()->year)
                ->whereHas('staff', function ($query) {
                    $query->where('name', '!=', 'admin');
                })
                ->sum('total_hours');

            $hoursPercentageChange = $this->calculateHoursPercentageChange();

            $totalPartTimeStaffSalaryThisMonth = $this->calculateTotalPartTimeStaffSalaryThisMonth();

            $salaryPercentageChange = $this->calculateSalaryPercentageChange();

            $upcomingHolidays = Shift::where('date', '>', now())
                ->where('is_public_holiday', true)
                ->orderBy('date')
                ->take(3)
                ->get();
            
            $topStaffByHours = Staff::where('name', '!=', 'admin')
                ->withSum(['shifts' => function ($query) {
                    $query->whereMonth('date', now()->month)
                        ->whereYear('date', now()->year);
                }], 'total_hours')
                ->orderByDesc('shifts_sum_total_hours')
                ->take(5)
                ->get();

            return view('home', compact(
                'totalStaff',
                'activeShiftsToday',
                'totalHoursThisMonth',
                'upcomingHolidays',
                'topStaffByHours',
                'totalPartTimeStaffSalaryThisMonth',
                'salaryPercentageChange',
                'hoursPercentageChange',
                'partTimeStaff',
                'fullTimeStaff'
            ));
        } catch (\Exception $e) {
            \Log::error('Error in HomeController@index: ' . $e->getMessage());
            
            return view('home', ['error' => 'An error occurred while loading the dashboard.']);
        }
    }

    private function calculateTotalPartTimeStaffSalaryThisMonth()
    {
        $currentMonth = now()->month;
        $currentYear = now()->year;

        $query = Salary::whereHas('staff', function ($query) {
                $query->where('employment_type', 'part_time')
                      ->where('name', '!=', 'admin');
            })
            ->where('month', $currentMonth)
            ->where('year', $currentYear);

        $total = $query->sum('total_salary');
        
        return $total;
    }

    private function calculateTotalPartTimeStaffSalaryLastMonth()
    {
        $currentMonth = now()->month;
        $currentYear = now()->year;

        $query = Salary::whereHas('staff', function ($query) {
                $query->where('employment_type', 'part_time');
            })
            ->where('month', $currentMonth - 1)
            ->where('year', $currentYear);

        $total = $query->sum('total_salary');
        
        return $total;
    }

    private function calculateSalaryPercentageChange()
    {
        $totalSalaryThisMonth = $this->calculateTotalPartTimeStaffSalaryThisMonth();
        $totalSalaryLastMonth = $this->calculateTotalPartTimeStaffSalaryLastMonth();

        if ($totalSalaryLastMonth == 0) {
            return $totalSalaryThisMonth > 0 ? 100 : 0;
        }

        $percentageChange = (($totalSalaryThisMonth - $totalSalaryLastMonth) / $totalSalaryLastMonth) * 100;
        
        return round($percentageChange, 2);
    }

    private function calculateHoursPercentageChange()
    {
        $totalHoursThisMonth = Shift::whereMonth('date', now()->month)
            ->whereYear('date', now()->year)
            ->whereHas('staff', function ($query) {
                $query->where('name', '!=', 'admin');
            })
            ->sum('total_hours');

        $totalHoursLastMonth = Shift::whereMonth('date', now()->subMonth()->month)
            ->whereYear('date', now()->subMonth()->year)
            ->whereHas('staff', function ($query) {
                $query->where('name', '!=', 'admin');
            })
            ->sum('total_hours');

        if ($totalHoursLastMonth == 0) {
            return $totalHoursThisMonth > 0 ? 100 : 0;
        }

        $percentageChange = (($totalHoursThisMonth - $totalHoursLastMonth) / $totalHoursLastMonth) * 100;
        
        return round($percentageChange, 2);
    }
}
