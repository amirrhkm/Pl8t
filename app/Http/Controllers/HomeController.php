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
            
            $activeShiftsToday = Shift::whereDate('date', today())
                ->where('start_time', '<=', now())
                ->where('end_time', '>=', now())
                ->count();
            
            $totalHoursThisMonth = Shift::whereMonth('date', now()->month)
                ->whereYear('date', now()->year)
                ->sum('total_hours');
            
            $avgDailyAttendance = $this->calculateAvgDailyAttendance();
            
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
                'avgDailyAttendance',
                'upcomingHolidays',
                'topStaffByHours'
            ));
        } catch (\Exception $e) {
            // Log the error
            \Log::error('Error in HomeController@index: ' . $e->getMessage());
            
            // Return a view with an error message
            return view('home', ['error' => 'An error occurred while loading the dashboard.']);
        }
    }

    private function calculateAvgDailyAttendance()
    {
        $startOfMonth = now()->startOfMonth();
        $endOfMonth = now()->endOfMonth();
        $totalDays = now()->daysInMonth;

        $totalAttendance = Shift::whereBetween('date', [$startOfMonth, $endOfMonth])
            ->select('staff_id', 'date')
            ->groupBy('staff_id', 'date')
            ->get()
            ->count();

        $totalStaff = Staff::count();
        
        if ($totalStaff == 0) {
            return 0;
        }

        $avgAttendance = ($totalAttendance / ($totalDays * $totalStaff)) * 100;

        return round($avgAttendance, 2);
    }
}