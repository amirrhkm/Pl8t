<?php

namespace App\Http\Controllers;

use App\Models\Shift;
use App\Models\Staff;
use Illuminate\Http\Request;
use Carbon\Carbon;

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

        $totalOvertimeHours = $this->calculateTotalOvertimeHours();

        $staffAvailability = $this->calculateStaffAvailability();

        return view('shift.index', compact(
            'totalShiftsThisMonth',
            'upcomingShifts',
            'staffOnDutyToday',
            'weeklyShifts',
            'totalOvertimeHours',
            'staffAvailability'
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

        $start_time = Carbon::createFromFormat('H:i', $request->start_time);
        $end_time = Carbon::createFromFormat('H:i', $request->end_time);
        $total_hours = ($start_time->diffInHours($end_time)) - $request->break_duration;
        $overtime_hours = max(0, $total_hours - 8);

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

        $start_time = Carbon::createFromFormat('H:i', $request->start_time);
        $end_time = Carbon::createFromFormat('H:i', $request->end_time);
        $break_duration = $request->break_duration;
        $total_hours = $start_time->diffInHours($end_time) - $break_duration;
        $overtime_hours = max(0, $total_hours - 8);

        $shift->update([
            'start_time' => $validatedData['start_time'],
            'end_time' => $validatedData['end_time'],
            'break_duration' => $break_duration,
            'total_hours' => $total_hours,
            'overtime_hours' => $overtime_hours,
        ]);

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
}
