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

    public function edit($id)
    {
        $shift = Shift::with('staff')->findOrFail($id);
        return view('shift.edit', compact('shift'));
    }

    public function update(Request $request, $id)
    {
        $shift = Shift::findOrFail($id);

        $start_time = Carbon::createFromFormat('H:i', $request->start_time);
        $end_time = Carbon::createFromFormat('H:i', $request->end_time);
        $break_duration = $request->break_duration;
        $total_hours = $start_time->diffInHours($end_time) - $break_duration;
        $overtime_hours = max(0, $total_hours - 8);

        $shift->update([
            'start_time' => $start_time,
            'end_time' => $end_time,
            'break_duration' => $break_duration,
            'total_hours' => $total_hours,
            'overtime_hours' => $overtime_hours,
        ]);

        return redirect()->route('shift.details', ['date' => $shift->date])
                        ->with('success', 'Shift updated successfully.');
    }

    public function destroy(Shift $shift)
    {
        $year = Carbon::parse($shift->date)->year;
        $month = Carbon::parse($shift->date)->month;

        $shift->delete();
        return redirect()->route('shift.month', ['year' => $year, 'month' => $month])
                        ->with('success', 'Shift deleted successfully.');
    }

    public function togglePublicHoliday(Request $request)
    {
        $date = $request->input('date');
        $isPublicHoliday = $request->has('is_public_holiday');

        Shift::where('date', $date)->update(['is_public_holiday' => $isPublicHoliday]);

        return back()->with('success', 'Public holiday status updated successfully.');
    }

    public function details($date)
    {
        $shifts = Shift::where('date', $date)->with('staff')->get();
        return view('shift.details', compact('shifts', 'date'));
    }
}
