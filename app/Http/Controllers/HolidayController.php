<?php

namespace App\Http\Controllers;

use App\Models\Shift;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HolidayController extends Controller
{
    public function index(Request $request)
    {
        $month = $request->get('month', now()->month);
        $year = $request->get('year', now()->year);
        
        $date = Carbon::createFromDate($year, $month, 1);
        $daysInMonth = $date->daysInMonth;
        
        // Create calendar grid with padding
        $calendar = collect();
        $firstDay = $date->copy()->firstOfMonth();
        
        // Add empty days for padding
        for ($i = 0; $i < $firstDay->dayOfWeek; $i++) {
            $calendar->push(null);
        }
        
        // Add all days of the month
        for ($day = 1; $day <= $daysInMonth; $day++) {
            $calendar->push(Carbon::createFromDate($year, $month, $day));
        }

        // Get all holidays for the month
        $holidays = Shift::where('is_public_holiday', true)
            ->whereYear('date', $year)
            ->whereMonth('date', $month)
            ->pluck('date')
            ->map(fn($date) => $date->format('Y-m-d'));

        return view('holidays.index', compact('calendar', 'holidays'));
    }

    public function toggle(Request $request)
    {
        $date = Carbon::parse($request->date);
        
        // Toggle the holiday status for all shifts on this date
        $existingShift = Shift::whereDate('date', $date)->first();
        
        if ($existingShift) {
            DB::table('shifts')
                ->whereDate('date', $date)
                ->update(['is_public_holiday' => !$existingShift->is_public_holiday]);
        } else {
            // Create a placeholder shift to mark the holiday
            Shift::create([
                'date' => $date,
                'is_public_holiday' => true,
                'start_time' => $date->copy()->setTime(9, 0),
                'end_time' => $date->copy()->setTime(18, 0),
                'total_hours' => 8,
                'break_duration' => 1,
                'overtime_hours' => 0,
            ]);
        }

        return response()->json(['success' => true]);
    }
} 