<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use App\Models\Shift;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Salary;
class CrewController extends Controller
{
    public function show($name)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('warning', 'You must be logged in to access this page.');
        }

        if (Auth::user()->staff->name !== $name) {
            Auth::logout();
            return redirect()->route('login')->with('warning', 'You are not authorized to access this page.');
        }
        
        $date = now()->format('Y-m-d');
        $startOfWeek = now()->startOfWeek();
        $endOfWeek = now()->endOfWeek();
        
        $staff = Staff::where('name', $name)->firstOrFail();
        
        $weeklyShifts = Shift::with('staff')
            ->whereBetween('date', [$startOfWeek, $endOfWeek])
            ->whereHas('staff', function($query) {
                $query->where('name', '!=', 'admin');
            })
            ->get()
            ->groupBy(function ($shift) {
                return $shift->date->format('Y-m-d');
            });

        $month_reg_hours = 0;
        $month_reg_ot_hours = 0;
        $month_ph_hours = 0;
        $month_ph_ot_hours = 0;

        $startOfMonth = now()->startOfMonth();
        $endOfMonth = now()->endOfMonth();
    
        $year = now()->year;
        $month = now()->month;

        $monthShifts = $staff->shifts()
            ->whereYear('date', $year)
            ->whereMonth('date', $month)
            ->orderBy('date')
            ->get();

        foreach ($monthShifts as $shift) {
            $hours = $shift->start_time->diffInHours($shift->end_time) - $shift->break_duration;
            $otHours = max(0, $hours - 8);

            if ($shift->is_public_holiday) {
                $month_ph_hours += $hours;
                $month_ph_ot_hours += $otHours;
            } else {
                $month_reg_hours += $hours;
                $month_reg_ot_hours += $otHours;
            }
        }

        $currentMonth = now();
        $lastMonth = $currentMonth->copy()->subMonth();
        $twoMonthsAgo = $currentMonth->copy()->subMonths(2);
        $threeMonthsAgo = $currentMonth->copy()->subMonths(3);

        $lastMonthName = $lastMonth->format('M');
        $twoMonthsAgoName = $twoMonthsAgo->format('M');
        $threeMonthsAgoName = $threeMonthsAgo->format('M');

        $this_month_salary = $this->getSalaryForMonth($staff, $currentMonth->year, $currentMonth->month, $month_reg_hours, $month_reg_ot_hours, $month_ph_hours, $month_ph_ot_hours);
        $last_month_salary = $this->getSalaryForMonth($staff, $lastMonth->year, $lastMonth->month);
        $two_months_ago_salary = $this->getSalaryForMonth($staff, $twoMonthsAgo->year, $twoMonthsAgo->month);
        $three_months_ago_salary = $this->getSalaryForMonth($staff, $threeMonthsAgo->year, $threeMonthsAgo->month);

        $percentage_diff_last_month = $this->getPercentageDiff($this_month_salary, $last_month_salary);
        $percentage_diff_two_months_ago = $this->getPercentageDiff($this_month_salary, $two_months_ago_salary);
        $percentage_diff_three_months_ago = $this->getPercentageDiff($this_month_salary, $three_months_ago_salary);

        return view('crew.dashboard', compact(
            'staff', 
            'weeklyShifts', 
            'month_reg_hours', 
            'month_reg_ot_hours', 
            'month_ph_hours', 
            'month_ph_ot_hours', 
            'this_month_salary', 
            'last_month_salary', 
            'two_months_ago_salary', 
            'three_months_ago_salary', 
            'date', 
            'percentage_diff_last_month', 
            'percentage_diff_two_months_ago', 
            'percentage_diff_three_months_ago',
            'lastMonthName',
            'twoMonthsAgoName',
            'threeMonthsAgoName'
        ));
    }

    private function getSalaryForMonth($staff, $year, $month, $reg_hours = 0, $reg_ot_hours = 0, $ph_hours = 0, $ph_ot_hours = 0)
    {
        $salary = Salary::where('staff_id', $staff->id)
            ->where('year', $year)
            ->where('month', $month)
            ->first();

        if ($salary) {
            return $salary->total_salary;
        }

        if ($year == now()->year && $month == now()->month) {
            $total_salary = $reg_hours * $staff->hourly_rate +
                $reg_ot_hours * 10 +
                $ph_hours * $staff->hourly_rate * 2 +
                $ph_ot_hours * 10 * 2;

            return round($total_salary, 2);
        }

        return 0;
    }

    private function getPercentageDiff($current, $previous)
    {
        if ($previous == 0) {
            return 0;
        }
        return (($current - $previous) / $previous) * 100;
    }
}
