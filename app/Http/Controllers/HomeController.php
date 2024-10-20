<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use App\Models\Shift;
use App\Models\Salary;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('warning', 'You must be logged in to access this page.');
        }
        
        if (Auth::user()->name !== 'admin') {
            Auth::logout();
            return redirect()->route('login')->with('warning', 'Your role does not have permission to access this page.');
        }
        
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

            $allStaff = Staff::where('name', '!=', 'admin')->get();
            foreach ($allStaff as $staff) {
                $this->updateSalary($staff);
            }

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

    public function updateSalary(Staff $staff): void
    {
        $shifts = $staff->shifts()->orderBy('date')->get();

        if ($shifts->isEmpty()) {
            Salary::where('staff_id', $staff->id)->delete();
            return;
        }

        $monthlyData = [];

        foreach ($shifts as $shift) {
            $yearMonth = $shift->date->format('Y-m');
            if (!isset($monthlyData[$yearMonth])) {
                $monthlyData[$yearMonth] = [
                    'reg_hours' => 0, 'reg_ot_hours' => 0,
                    'ph_hours' => 0, 'ph_ot_hours' => 0,
                    'reg_pay' => 0, 'reg_ot_pay' => 0,
                    'ph_pay' => 0, 'ph_ot_pay' => 0
                ];
            }

            $hours = $shift->start_time->diffInHours($shift->end_time) - $shift->break_duration;
            $otHours = max(0, $hours - 8);

            if ($shift->is_public_holiday) {
                $monthlyData[$yearMonth]['ph_hours'] += $hours;
                $monthlyData[$yearMonth]['ph_ot_hours'] += $otHours;
            } else {
                $monthlyData[$yearMonth]['reg_hours'] += $hours;
                $monthlyData[$yearMonth]['reg_ot_hours'] += $otHours;
            }
        }

        foreach ($monthlyData as $yearMonth => &$data) {
            [$year, $month] = explode('-', $yearMonth);
            
            $ot_rate = $staff->employment_type === 'part_time' ? 10 : 11;
            $data['reg_pay'] = $data['reg_hours'] * $staff->rate;
            $data['reg_ot_pay'] = $data['reg_ot_hours'] * $ot_rate;
            $data['ph_pay'] = $data['ph_hours'] * $staff->rate * 2;
            $data['ph_ot_pay'] = $data['ph_ot_hours'] * $ot_rate * 2;
            
            $total_salary = $data['reg_pay'] + $data['reg_ot_pay'] + $data['ph_pay'] + $data['ph_ot_pay'];

            Salary::updateOrCreate(
                ['staff_id' => $staff->id, 'month' => $month, 'year' => $year],
                [
                    'total_reg_hours' => $data['reg_hours'],
                    'total_reg_ot_hours' => $data['reg_ot_hours'],
                    'total_ph_hours' => $data['ph_hours'],
                    'total_ph_ot_hours' => $data['ph_ot_hours'],
                    'total_salary' => $total_salary,
                    'reg_pay' => $data['reg_pay'],
                    'reg_ot_pay' => $data['reg_ot_pay'],
                    'ph_pay' => $data['ph_pay'],
                    'ph_ot_pay' => $data['ph_ot_pay'],
                ]
            );
        }
    }
}
