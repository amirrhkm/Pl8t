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
        return view('shift.index');
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

    public function create(Request $request)
    {
        $date = $request->query('date');
        $staff = Staff::all();

        return view('shift.create', compact('date', 'staff'));
    }

    public function store(Request $request)
    {
        $start_time = Carbon::createFromFormat('H:i', $request->start_time);
        $end_time = Carbon::createFromFormat('H:i', $request->end_time);
        $total_hours = ($start_time->diffInHours($end_time)) - $request->break_duration;
        $overtime_hours = max(0, $total_hours - 8);

        Shift::create([
            'staff_id' => $request->staff_id,
            'date' => $request->date,
            'start_time' => $start_time,
            'end_time' => $end_time,
            'break_duration' => $request->break_duration,
            'total_hours' => $total_hours,
            'overtime_hours' => $overtime_hours,
            'is_public_holiday' => false,
        ]);

        $year = Carbon::parse($request->date)->year;
        $month = Carbon::parse($request->date)->month;

        return redirect()->route('shift.month', ['year' => $year, 'month' => $month])
                        ->with('success', 'Shift added successfully.');
    }

    public function edit(Shift $shift)
    {
        $staff = Staff::all();
        return view('shifts.edit', compact('shift', 'staff'));
    }

    public function update(Request $request, Shift $shift)
    {
        $validated = $request->validate([
            'staff_id' => 'required|exists:staff,id',
            'date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'is_public_holiday' => 'boolean',
        ]);

        $shift->update($validated);
        $shift->calculateHours();

        return redirect()->route('shifts.index')->with('success', 'Shift updated successfully.');
    }

    public function destroy(Shift $shift)
    {
        $shift->delete();
        return redirect()->route('shifts.index')->with('success', 'Shift deleted successfully.');
    }
}
