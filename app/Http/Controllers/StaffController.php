<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use App\Models\Salary;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class StaffController extends Controller
{
    public function index()
    {
        $staff = Staff::all();
        return view('staff.index', ['staffs' => $staff]);
    }

    public function create()
    {
        return view('staff.create');
    }

    public function show(Staff $staff)
    {
        return view('staff.detail', ['staff' => $staff]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'nickname' => 'required|string|max:255',
            'employment_type' => 'required|in:part_time,full_time',
            'position' => 'required|in:bar,kitchen,flexible',
            'rate' => 'nullable|numeric|min:0',
        ]);

        Staff::create($validated);

        return redirect()->route('staff.index')->with('success', 'Staff created successfully.');
    }

    public function edit(Staff $staff)
    {
        return view('staff.edit', compact('staff'));
    }

    public function update(Request $request, Staff $staff)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'nickname' => 'required|string|max:255',
            'employment_type' => 'required|in:part_time,full_time',
            'position' => 'required|in:bar,kitchen,flexible',
            'rate' => 'nullable|numeric|min:0',
        ]);

        $staff->update($request->all());

        return redirect()->route('staff.index')->with('success', 'Staff updated successfully.');
    }


    public function destroy(Staff $staff)
    {
        $staff->delete();
        return redirect()->route('staff.index')->with('success', 'Staff deleted successfully.');
    }

    public function shift(Staff $staff, $year, $month)
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

        $ot_rate = $staff->employment_type === 'part_time' ? 10 : 11;
        $reg_pay = $month_reg_hours * $staff->rate;
        $reg_ot_pay = $month_reg_ot_hours * $ot_rate;
        $ph_pay = $month_ph_hours * $staff->rate * 2;
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

        return view('staff.shift', compact('staff', 'monthShifts', 'date', 'year', 'month', 'month_reg_hours', 'month_reg_ot_hours', 'month_ph_hours', 'month_ph_ot_hours', 'reg_pay', 'reg_ot_pay', 'ph_pay', 'ph_ot_pay', 'total_salary'));
    }

    public function wildcard(Staff $staff)
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

        return view('staff.wildcard', compact('staff', 'monthlyData'));
    }

    public function downloadPayslip(Staff $staff, $yearMonth)
    {
        [$year, $month] = explode('-', $yearMonth);
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

        $ot_rate = $staff->employment_type === 'part_time' ? 10 : 11;
        $reg_pay = $month_reg_hours * $staff->rate;
        $reg_ot_pay = $month_reg_ot_hours * $ot_rate;
        $ph_pay = $month_ph_hours * $staff->rate * 2;
        $ph_ot_pay = $month_ph_ot_hours * $ot_rate * 2;
        
        $total_salary = $reg_pay + $reg_ot_pay + $ph_pay + $ph_ot_pay;

        $pdf = PDF::loadView('staff.payslip-pdf', compact(
            'staff', 'monthShifts', 'date', 'year', 'month',
            'month_reg_hours', 'month_reg_ot_hours', 'month_ph_hours', 'month_ph_ot_hours',
            'reg_pay', 'reg_ot_pay', 'ph_pay', 'ph_ot_pay', 'total_salary'
        ));

        return $pdf->download("payslip-bbc078-p15-{$staff->nickname}-{$year}-{$month}.pdf");
    }
}
