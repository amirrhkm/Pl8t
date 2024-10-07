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

    public function create()
    {
        $staff = Staff::all();
        return view('shifts.create', compact('staff'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'staff_id' => 'required|exists:staff,id',
            'date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'is_public_holiday' => 'boolean',
        ]);

        $shift = Shift::create($validated);
        $shift->calculateHours();

        return redirect()->route('shifts.index')->with('success', 'Shift created successfully.');
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
