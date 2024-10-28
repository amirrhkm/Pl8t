<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Shift;
use App\Models\SalesExpense;
use App\Models\SalesEodExpense;
use App\Models\Invoice;
use App\Models\SalesBankin;
use App\Models\SalesEarning;
use App\Models\Salary;
use App\Models\Wastage;
use Carbon\Carbon;
use App\Models\Staff;

class ReportController extends Controller
{
    public function index()
    {
        $currentMonth = now()->month;
        $currentYear = now()->year;
        $lastMonth = now()->subMonth();
        $lastMonthMonth = $lastMonth->month;
        $lastMonthYear = $lastMonth->year;

        // Function to calculate monthly data
        $calculateMonthlyData = function ($month, $year) {
            return [
                'partTimeHours' =>
                    Shift::whereMonth('date', $month)->whereYear('date', $year)->whereHas('staff', function ($query) {$query->where('employment_type', 'part_time');})->sum(DB::raw('total_hours')) + 
                    Shift::whereMonth('date', $month)->whereYear('date', $year)->whereHas('staff', function ($query) {$query->where('employment_type', 'part_time');})->sum(DB::raw('overtime_hours')),
                'partTimeSalary' =>
                    Salary::where('month', $month)
                    ->where('year', $year)
                    ->whereHas('staff', function ($query) {
                        $query->where('employment_type', 'part_time')
                             ->where('id', '!=', 1);
                    })->sum('total_salary'),
                'salesExpenses' => SalesExpense::whereMonth('date', $month)
                    ->whereYear('date', $year)
                    ->sum('amount'),
                'eodExpenses' => (SalesEodExpense::whereMonth('date', $month)->whereYear('date', $year)->sum('amount_1') + 
                    SalesEodExpense::whereMonth('date', $month)->whereYear('date', $year)->sum('amount_2') + 
                    SalesEodExpense::whereMonth('date', $month)->whereYear('date', $year)->sum('amount_3') + 
                    SalesEodExpense::whereMonth('date', $month)->whereYear('date', $year)->sum('amount_4') + 
                    SalesEodExpense::whereMonth('date', $month)->whereYear('date', $year)->sum('amount_5') + 
                    SalesEodExpense::whereMonth('date', $month)->whereYear('date', $year)->sum('amount_6') + 
                    SalesEodExpense::whereMonth('date', $month)->whereYear('date', $year)->sum('amount_7') + 
                    SalesEodExpense::whereMonth('date', $month)->whereYear('date', $year)->sum('amount_8')),
                'invoicesTotal' => Invoice::whereMonth('submit_date', $month)
                    ->whereYear('submit_date', $year)
                    ->sum('total_amount'),
                'salesBankins' => SalesBankin::whereMonth('date', $month)
                    ->whereYear('date', $year)
                    ->sum('amount'),
                'otherEarnings' => SalesEarning::whereMonth('date', $month)
                    ->whereYear('date', $year)
                    ->sum('amount'),
            ];
        };

        $query = Salary::whereHas('staff', function ($query) {
            $query->where('employment_type', 'part_time');
        })
        ->where('month', $currentMonth - 1)
        ->where('year', $currentYear);

        $total = $query->sum('total_salary');

        $currentMonthData = $calculateMonthlyData($currentMonth, $currentYear);
        $lastMonthData = $calculateMonthlyData($lastMonthMonth, $lastMonthYear);

        // Calculate totals and percentage differences
        $data = [];
        foreach ($currentMonthData as $key => $currentValue) {
            $lastValue = $lastMonthData[$key];
            $data[$key] = [
                'current' => $currentValue,
                'last' => $lastValue,
                'percentageDiff' => $lastValue != 0 ? (($currentValue - $lastValue) / $lastValue) * 100 : null,
            ];
        }

        // Calculate total expenses and earnings
        $data['totalExpenses'] = [
            'current' => $data['salesExpenses']['current'] + $data['eodExpenses']['current'] + $data['invoicesTotal']['current'],
            'last' => $data['salesExpenses']['last'] + $data['eodExpenses']['last'] + $data['invoicesTotal']['last'],
        ];
        $data['totalEarnings'] = [
            'current' => $data['salesBankins']['current'] + $data['otherEarnings']['current'],
            'last' => $data['salesBankins']['last'] + $data['otherEarnings']['last'],
        ];

        // Calculate percentage distribution for expenses
        $data['expensesDistribution'] = [
            'salesExpenses' => $data['totalExpenses']['current'] > 0 ? ($data['salesExpenses']['current'] / $data['totalExpenses']['current']) * 100 : 0,
            'eodExpenses' => $data['totalExpenses']['current'] > 0 ? ($data['eodExpenses']['current'] / $data['totalExpenses']['current']) * 100 : 0,
            'invoicesTotal' => $data['totalExpenses']['current'] > 0 ? ($data['invoicesTotal']['current'] / $data['totalExpenses']['current']) * 100 : 0,
        ];

        // Calculate percentage distribution for earnings
        $data['earningsDistribution'] = [
            'salesBankins' => $data['totalEarnings']['current'] > 0 ? ($data['salesBankins']['current'] / $data['totalEarnings']['current']) * 100 : 0,
            'otherEarnings' => $data['totalEarnings']['current'] > 0 ? ($data['otherEarnings']['current'] / $data['totalEarnings']['current']) * 100 : 0,
        ];

        // Calculate percentage differences for totals
        $data['totalExpenses']['percentageDiff'] = $data['totalExpenses']['last'] != 0 ? 
            (($data['totalExpenses']['current'] - $data['totalExpenses']['last']) / $data['totalExpenses']['last']) * 100 : null;
        $data['totalEarnings']['percentageDiff'] = $data['totalEarnings']['last'] != 0 ? 
            (($data['totalEarnings']['current'] - $data['totalEarnings']['last']) / $data['totalEarnings']['last']) * 100 : null;

        $wastages = Wastage::whereMonth('date', now()->month)
            ->whereYear('date', now()->year)
            ->get()
            ->groupBy('item')
            ->map(function ($group) {
                return [
                    'item' => $group->first()->item,
                    'total_quantity' => $group->sum('quantity'),
                    'total_weight' => $group->sum('weight'),
                ];
            })
            ->sortByDesc(function ($item) {
                return $item['total_weight'] ?? $item['total_quantity'] ?? 0;
            })
            ->take(5);
        
        return view('reports.index', compact('data', 'wastages'));
    }

    public function partTimeDetails(Request $request)
    {
        $selectedMonth = $request->input('month') ? Carbon::createFromFormat('Y-m', $request->input('month')) : now();

        $partTimeStaff = Staff::where('employment_type', 'part_time')
            ->with(['shifts' => function ($query) use ($selectedMonth) {
                $query->whereYear('date', $selectedMonth->year)
                    ->whereMonth('date', $selectedMonth->month);
            }, 'salaries' => function ($query) use ($selectedMonth) {
                $query->where('month', $selectedMonth->month)
                    ->where('year', $selectedMonth->year);
            }])
            ->get()
            ->map(function ($staff) {
                $staff->total_reg_hours = $staff->shifts->sum('total_hours') - $staff->shifts->sum('overtime_hours');
                $staff->total_ot_hours = $staff->shifts->sum('overtime_hours');
                $staff->total_ph_reg_hours = $staff->shifts->where('is_public_holiday', true)->sum('total_hours') - $staff->shifts->where('is_public_holiday', true)->sum('overtime_hours');
                $staff->total_ph_ot_hours = $staff->shifts->where('is_public_holiday', true)->sum('overtime_hours');
                $staff->total_hours = $staff->shifts->sum('total_hours');
                $staff->total_salary = $staff->salaries->sum('total_salary');
                return $staff;
            });

        return view('reports.part-time-details', compact('partTimeStaff', 'selectedMonth'));
    }
}
