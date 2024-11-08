<?php

namespace App\Http\Controllers;

use App\Models\Shift;
use App\Models\Staff;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Salary;

class ShiftController extends Controller
{
    public function index()
    {
        $totalShiftsThisMonth = Shift::whereMonth('date', now()->month)
            ->whereHas('staff', function ($query) {
                $query->where('name', '!=', 'admin');
            })
            ->count();

        $upcomingShifts = Shift::where('date', '>=', now())
            ->whereHas('staff', function ($query) {
                $query->where('name', '!=', 'admin');
            })
            ->count();

        $staffOnDutyToday = Shift::whereDate('date', today())
            ->whereHas('staff', function ($query) {
                $query->where('name', '!=', 'admin');
            })
            ->count();

        $weekStart = now()->startOfWeek();
        $weekEnd = $weekStart->copy()->endOfWeek();

        $weeklyShifts = Shift::join('staff', 'shifts.staff_id', '=', 'staff.id')
            ->whereBetween('shifts.date', [$weekStart, $weekEnd])
            ->where('staff.name', '!=', 'admin')
            ->select('shifts.*')
            ->get()
            ->groupBy(function ($shift) {
                return $shift->date->format('Y-m-d');
            });

        // Get all staff excluding 'admin'
        $staff = Staff::where('name', '!=', 'admin')->get();

        $offDayRecords = [];
        foreach (range(0, 6) as $dayOffset) {
            $currentDay = $weekStart->copy()->addDays($dayOffset);
            $dateKey = $currentDay->format('Y-m-d');

            $offDayStaff = $staff->filter(function ($staffMember) use ($weeklyShifts, $dateKey) {
                return !isset($weeklyShifts[$dateKey]) || !$weeklyShifts[$dateKey]->contains('staff_id', $staffMember->id);
            });

            $offDayRecords[$dateKey] = $offDayStaff;
        }

        $totalOvertimeHours = $this->calculateTotalOvertimeHours();

        $staffAvailability = $this->calculateStaffAvailability();

        return view('shift.index', compact(
            'totalShiftsThisMonth',
            'upcomingShifts',
            'staffOnDutyToday',
            'weeklyShifts',
            'totalOvertimeHours',
            'staffAvailability',
            'offDayRecords'
        ));
    }

    private function calculateTotalOvertimeHours()
    {
        $startOfMonth = now()->startOfMonth();
        $endOfMonth = now()->endOfMonth();

        return Shift::whereBetween('date', [$startOfMonth, $endOfMonth])
            ->whereHas('staff', function ($query) {
                $query->where('name', '!=', 'admin');
            })
            ->sum('overtime_hours');
    }

    private function calculateStaffAvailability()
    {
        $startOfWeek = now()->startOfWeek();
        $endOfWeek = now()->endOfWeek();

        $totalStaff = Staff::where('name', '!=', 'admin')->count();

        $staffWithShifts = Shift::whereBetween('date', [$startOfWeek, $endOfWeek])
            ->whereHas('staff', function ($query) {
                $query->where('name', '!=', 'admin');
            })
            ->distinct('staff_id')
            ->count('staff_id');

        if ($totalStaff > 0) {
            $percentageWithShifts = ($staffWithShifts / $totalStaff) * 100;
        } else {
            $percentageWithShifts = 0;
        }

        if ($percentageWithShifts > 80) {
            return 1; 
        } elseif ($percentageWithShifts > 70) {
            return 2; 
        } else {
            return 3; 
        }
    }

    public function monthView($year, $month)
    {
        $startDate = Carbon::create($year, $month, 1);
        $endDate = $startDate->copy()->endOfMonth();

        $shifts = Shift::whereBetween('date', [$startDate, $endDate])
            ->with('staff')
            ->get()
            ->groupBy('date');

        return view('shift.month', compact('shifts', 'year', 'month'));
    }

    public function clearMonth()
    {
        $startDate = Carbon::create(now()->year, now()->month, 1);
        $endDate = $startDate->copy()->endOfMonth();

        Shift::whereBetween('start_time', [$startDate, $endDate])
            ->whereDoesntHave('staff', function ($query) {
                $query->where('name', 'admin');
            })
            ->delete();

        return redirect()->back()->with('success', 'Shifts cleared successfully.');
    }

    public function weekView(Request $request)
    {
        $date = $request->query('date');
        $startOfWeek = Carbon::parse($date)->startOfWeek();
        $endOfWeek = Carbon::parse($date)->endOfWeek();

        $weeklyShifts = Shift::join('staff', 'shifts.staff_id', '=', 'staff.id')
            ->whereBetween('shifts.date', [$startOfWeek, $endOfWeek])
            ->where('staff.name', '!=', 'admin')
            ->select('shifts.*')
            ->get()
            ->groupBy(function ($shift) {
                return $shift->date->format('Y-m-d');
            });

        return view('shift.week', compact('weeklyShifts', 'date'));
    }

    public function clearWeek()
    {
        $startOfWeek = now()->startOfWeek();
        $endOfWeek = now()->endOfWeek();

        Shift::whereBetween('start_time', [$startOfWeek, $endOfWeek])
            ->whereDoesntHave('staff', function ($query) {
                $query->where('name', 'admin');
            })
            ->delete();

        return redirect()->back()->with('success', 'Shifts cleared successfully.');
    }

    public function create(Request $request)
    {
        $date = $request->query('date');
        $isPublicHoliday = $request->query('is_public_holiday');
        $staff = Staff::all();

        return view('shift.create', compact('date', 'staff', 'isPublicHoliday'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ]);

        $public_holiday = $request->is_public_holiday;

        $date = Carbon::parse($request->date);
        $start_time = Carbon::createFromFormat('H:i', $request->start_time);
        $end_time = Carbon::createFromFormat('H:i', $request->end_time);
        $total_hours = ($start_time->diffInHours($end_time)) - $request->break_duration;

        // Manual Ingestion for Supervisor (Saturday)
        if ((int)$request->staff_id === 7 && $date->isSaturday()) {
            $overtime_hours = max(0, $total_hours - 4);
        } else {
            $overtime_hours = max(0, $total_hours - 8);
        }

        Shift::create([
            'staff_id' => $request->staff_id,
            'date' => $request->date,
            'start_time' => $validatedData['start_time'],
            'end_time' => $validatedData['end_time'],
            'break_duration' => $request->break_duration,
            'total_hours' => $total_hours,
            'overtime_hours' => $overtime_hours,
            'is_public_holiday' => $public_holiday,
        ]);

        $staff = Staff::findOrFail($request->staff_id);
        $this->updateSalary($staff);

        return redirect()->route('shift.details', ['date' => $request->date])
                        ->with('success', 'Shift added successfully.');
    }

    public function edit($id)
    {
        $shift = Shift::with('staff')->findOrFail($id);
        return view('shift.edit', compact('shift'));
    }

    public function update(Request $request, $id)
    {
        $shift = Shift::findOrFail($id);

        $validatedData = $request->validate([
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ]);

        $date = Carbon::parse($request->date);
        $start_time = Carbon::createFromFormat('H:i', $request->start_time);
        $end_time = Carbon::createFromFormat('H:i', $request->end_time);
        $break_duration = $request->break_duration;
        $total_hours = $start_time->diffInHours($end_time) - $break_duration;

        // Manual Ingestion for Supervisor (Saturday)
        if ((int)$request->staff_id === 7 && $date->isSaturday()) {
            $overtime_hours = max(0, $total_hours - 4);
        } else {
            $overtime_hours = max(0, $total_hours - 8);
        }

        $shift->update([
            'start_time' => $validatedData['start_time'],
            'end_time' => $validatedData['end_time'],
            'break_duration' => $break_duration,
            'total_hours' => $total_hours,
            'overtime_hours' => $overtime_hours,
        ]);

        $staff = Staff::findOrFail($request->staff_id);
        $this->updateSalary($staff);
        
        return redirect()->route('shift.details', ['date' => $shift->date])
                        ->with('success', 'Shift updated successfully.');
    }

    public function destroy(Shift $shift)
    {
        $date = $shift->date;
        $shift->delete();
        return redirect()->route('shift.details', ['date' => $date])
                        ->with('success', 'Shift deleted successfully.');
    }

    public function togglePublicHoliday(Request $request)
    {
        $date = $request->input('date');
        $isPublicHoliday = $request->has('is_public_holiday');

        $carbonDate = Carbon::parse($date)->startOfDay();

        Shift::whereDate('date', $carbonDate)->update(['is_public_holiday' => $isPublicHoliday]);

        return back()->with('success', 'Public holiday status updated successfully.');
    }

    public function details($date)
    {
        $carbonDate = Carbon::parse($date)->startOfDay();
        $shifts = Shift::whereDate('date', $carbonDate)->with('staff')->get();
        $isPublicHoliday = $shifts->first()->is_public_holiday;

        return view('shift.details', compact('shifts', 'date', 'isPublicHoliday'));
    }

    public function today()
    {
        $date = now()->toDateString();
        $shifts = Shift::whereDate('date', $date)->with('staff')->get();
        $isPublicHoliday = $shifts->isNotEmpty() ? $shifts->first()->is_public_holiday : false;
        return view('shift.details', compact('shifts', 'date', 'isPublicHoliday'));
    }

    public function updateSalary(Staff $staff): void
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
    }
}
