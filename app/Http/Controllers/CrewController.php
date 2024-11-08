<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use App\Models\Shift;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Salary;
use Carbon\Carbon;

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
            $total_hours = $shift->start_time->diffInHours($shift->end_time) - $shift->break_duration;
            
            // Manual Ingestion for Supervisor (Saturday)
            if((int)$shift->staff_id === 7 && $shift->date->isSaturday()){
                $otHours = max(0, $total_hours - 4);
                $hours = $total_hours - $otHours;
            }else{
                $otHours = max(0, $total_hours - 8);
                $hours = $total_hours - $otHours;
            }

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

    public function overview(Staff $staff)
    {
        $shifts = $staff->shifts()->orderBy('date')->get();
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

            $total_hours = $shift->start_time->diffInHours($shift->end_time) - $shift->break_duration;

            // Manual Ingestion for Supervisor (Saturday)
            if((int)$shift->staff_id === 7 && $shift->date->isSaturday()){
                $otHours = max(0, $total_hours - 4);
                $hours = $total_hours - $otHours;
            }else{
                $otHours = max(0, $total_hours - 8);
                $hours = $total_hours - $otHours;
            }

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
            if($staff->employment_type === 'part_time'){
                $data['reg_pay'] = $data['reg_hours'] * $staff->rate;
                $data['ph_pay'] = $data['ph_hours'] * $staff->rate * 2;
            }else{
                $data['reg_pay'] = 0;
                $data['ph_pay'] = 0;
            }
            $data['reg_ot_pay'] = $data['reg_ot_hours'] * $ot_rate;
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

        return view('crew.overview', compact('staff', 'monthlyData'));
    }

    public function details(Staff $staff, $year, $month)
    {
        $date = Carbon::createFromDate($year, $month, 1);
        $monthShifts = $staff->shifts()
            ->whereYear('date', $year)
            ->whereMonth('date', $month)
            ->orderBy('date')
            ->get();

        $month_reg_hours = 0;
        $month_reg_ot_hours = 0;
        $month_ph_hours = 0;
        $month_ph_ot_hours = 0;

        foreach ($monthShifts as $shift) {
            $total_hours = $shift->start_time->diffInHours($shift->end_time) - $shift->break_duration;

            // Manual Ingestion for Supervisor (Saturday)
            if((int)$shift->staff_id === 7 && $shift->date->isSaturday()){
                $otHours = max(0, $total_hours - 4);
                $hours = $total_hours - $otHours;
            }else{
                $otHours = max(0, $total_hours - 8);
                $hours = $total_hours - $otHours;
            }

            if ($shift->is_public_holiday) {
                $month_ph_hours += $hours;
                $month_ph_ot_hours += $otHours;
            } else {
                $month_reg_hours += $hours;
                $month_reg_ot_hours += $otHours;
            }
        }

        $ot_rate = $staff->employment_type === 'part_time' ? 10 : 11;

        if($staff->employment_type === 'part_time'){
            $reg_pay = $month_reg_hours * $staff->rate;
            $ph_pay = $month_ph_hours * $staff->rate * 2;
        }else{
            $reg_pay = 0;
            $ph_pay = 0;
        }

        $reg_ot_pay = $month_reg_ot_hours * $ot_rate;
        $ph_ot_pay = $month_ph_ot_hours * $ot_rate * 2;

        $total_salary = $reg_pay + $reg_ot_pay + $ph_pay + $ph_ot_pay;
        
        $salary = Salary::updateOrCreate(
            ['staff_id' => $staff->id, 'month' => $month, 'year' => $year],
            [
                'total_reg_hours' => $month_reg_hours,
                'total_reg_ot_hours' => $month_reg_ot_hours,
                'total_ph_hours' => $month_ph_hours,
                'total_ph_ot_hours' => $month_ph_ot_hours,
                'total_salary' => $total_salary,
                'reg_pay' => $reg_pay,
                'reg_ot_pay' => $reg_ot_pay,
                'ph_pay' => $ph_pay,
                'ph_ot_pay' => $ph_ot_pay,
            ]
        );

        return view('crew.details', compact(
            'staff', 
            'monthShifts', 
            'date', 
            'year', 
            'month', 
            'month_reg_hours', 
            'month_reg_ot_hours', 
            'month_ph_hours', 
            'month_ph_ot_hours', 
            'reg_pay', 
            'reg_ot_pay', 
            'ph_pay', 
            'ph_ot_pay', 
            'total_salary'
        ));
    }
}
