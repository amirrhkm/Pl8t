<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SalesEod;
use App\Models\SalesEodExpense;
use App\Models\SalesCumulative;
use App\Models\SalesBankin;
use App\Models\SalesEarning;
use App\Models\SalesExpense;
use App\Models\SalesDaily;
use App\Models\SalesCashStream;
use Carbon\Carbon;

class SalesController extends Controller
{
    /* Sales Dashboard */
    public function index(Request $request)
    {
        $month = $request->get('month', date('n'));
        $year = date('Y');

        // Get the monthly stats
        $monthlyStats = [
            'total_sales' => SalesEod::whereMonth('date', $month)
                ->whereYear('date', $year)
                ->sum('total_sales'),
                
            'total_expenses' => SalesExpense::whereMonth('date', $month)
                ->whereYear('date', $year)
                ->sum('amount') +
                SalesEodExpense::whereMonth('date', $month)
                ->whereYear('date', $year)
                ->sum('amount_1') +
                SalesEodExpense::whereMonth('date', $month)
                ->whereYear('date', $year)
                ->sum('amount_2') +
                SalesEodExpense::whereMonth('date', $month)
                ->whereYear('date', $year)
                ->sum('amount_3') +
                SalesEodExpense::whereMonth('date', $month)
                ->whereYear('date', $year)
                ->sum('amount_4') +
                SalesEodExpense::whereMonth('date', $month)
                ->whereYear('date', $year)
                ->sum('amount_5') +
                SalesEodExpense::whereMonth('date', $month)
                ->whereYear('date', $year)
                ->sum('amount_6') +
                SalesEodExpense::whereMonth('date', $month)
                ->whereYear('date', $year)
                ->sum('amount_7') +
                SalesEodExpense::whereMonth('date', $month)
                ->whereYear('date', $year)
                ->sum('amount_8'),
                
            'credit_card_sales' => SalesEod::whereMonth('date', $month)
                ->whereYear('date', $year)
                ->selectRaw('SUM(visa + master + debit) as credit_card_total')
                ->value('credit_card_total'),
                
            'ewallet_sales' => SalesEod::whereMonth('date', $month)
                ->whereYear('date', $year)
                ->sum('ewallet'),
                
            'delivery_sales' => SalesEod::whereMonth('date', $month)
                ->whereYear('date', $year)
                ->selectRaw('SUM(foodpanda + grabfood + shopeefood) as delivery_total')
                ->value('delivery_total'),
                
            'total_bankin' => SalesBankin::whereMonth('date', $month)
                ->whereYear('date', $year)
                ->sum('amount'),
        ];

        $totalSales = SalesEod::sum('total_sales');
        $totalExpenses = SalesExpense::sum('amount') + 
            SalesEodExpense::sum('amount_1') +
            SalesEodExpense::sum('amount_2') +
            SalesEodExpense::sum('amount_3') +
            SalesEodExpense::sum('amount_4') +
            SalesEodExpense::sum('amount_5') +
            SalesEodExpense::sum('amount_6') +
            SalesEodExpense::sum('amount_7') +
            SalesEodExpense::sum('amount_8');
        $creditCardSales = SalesEod::sum('visa') + SalesEod::sum('debit') + SalesEod::sum('master');
        $eWalletSales = SalesEod::sum('ewallet');
        $deliverySales = SalesEod::sum('foodpanda') + SalesEod::sum('grabfood') + SalesEod::sum('shopeefood');
        $totalBankin = SalesBankin::sum('amount');
        
        $salesDaily = SalesDaily::orderBy('date', 'asc')->get();
        $dailyCashStreams = [];
        $cumulativeCashStream = 0;

        foreach ($salesDaily as $daily) {
            $dailyCashFlow = $daily->total_balance;
            $cumulativeCashStream += $dailyCashFlow;
            $dailyCashStreams[$daily->date] = $cumulativeCashStream;
        }

        $currentCashStream = end($dailyCashStreams) ?: 0;

        $query = SalesDaily::query();

        if (request('month')) {
            $query->whereMonth('date', request('month'))
                ->whereYear('date', now()->year);
        } else {
            $query->whereMonth('date', now()->month)
                ->whereYear('date', now()->year);
        }

        $salesDaily = $query->orderBy('date', 'asc')->get();

        return view('sales.index', compact(
            'totalSales',
            'totalExpenses',
            'creditCardSales',
            'eWalletSales',
            'deliverySales',
            'totalBankin',
            'currentCashStream',
            'salesDaily',
            'dailyCashStreams',
            'monthlyStats'
        ));
    }

    /* Sales EOD */
    public function createEod()
    {
        return view('sales.create_eod');
    }

    public function storeEod(Request $request)
    {
        $expensesData = $request->only(['expenses_1', 'amount_1', 'expenses_2', 'amount_2', 'expenses_3', 'amount_3', 'expenses_4', 'amount_4', 'expenses_5', 'amount_5', 'expenses_6', 'amount_6', 'expenses_7', 'amount_7', 'expenses_8', 'amount_8']);
        $totalExpenses = array_sum(array_filter($expensesData, fn($key) => str_starts_with($key, 'amount_'), ARRAY_FILTER_USE_KEY));

        $totalBankinAmount = $request->cash - $request->ewallet - $totalExpenses + $request->cash_difference;
        $date = Carbon::parse($request->input('date'))->format('Y-m-d');
        
        $salesEod = SalesEod::create(array_merge(
            $request->only(['debit', 'visa', 'master', 'cash', 'ewallet', 'foodpanda', 'grabfood', 'shopeefood', 'prepaid', 'voucher', 'total_sales', 'cash_difference']),
            ['amount_to_bank_in' => $totalBankinAmount, 'date' => $date]
        ));

        $expensesData['sales_eod_id'] = $salesEod->id;
        $expensesData['date'] = $salesEod->date;
        SalesEodExpense::create($expensesData);

        $this->updateDailySales($salesEod->date, $totalBankinAmount, 'total_eod');
        return redirect()->route('sales.index')->with('success', 'Daily EOD Sales added successfully.');
    }

    public function editEod($id)
    {
        $salesEod = SalesEod::findOrFail($id);
        return view('sales.edit_eod', compact('salesEod'));
    }

    public function updateEod(Request $request, $id, $cumu_id)
    {
        $date = Carbon::parse($request->input('date'))->format('Y-m-d');
        $validatedData = $request->validate([
            'cash' => 'required|numeric',
            'ewallet' => 'required|numeric',
            'total_sales' => 'required|numeric',
            'cash_difference' => 'required|numeric',
            'date' => 'required|date',
        ]);
        
        $totalExpenses = 0;
        for ($i = 1; $i <= 8; $i++) {
            $totalExpenses += $request->input("amount_$i", 0);
        }

        $newAmountToBankIn = $validatedData['cash'] - $validatedData['ewallet'] - $totalExpenses + $validatedData['cash_difference'];

        $salesEod = SalesEod::findOrFail($id);
        $salesEod->update(array_merge(
            $validatedData,
            [
                'amount_to_bank_in' => $newAmountToBankIn,
                'date' => $date
            ]
        ));

        $salesEod->expenses()->update([
            'date' => $date,
            'expenses_1' => $request->input('expenses_1'),
            'amount_1' => $request->input('amount_1'),
            'expenses_2' => $request->input('expenses_2'),
            'amount_2' => $request->input('amount_2'),
            'expenses_3' => $request->input('expenses_3'),
            'amount_3' => $request->input('amount_3'),
            'expenses_4' => $request->input('expenses_4'),
            'amount_4' => $request->input('amount_4'),
            'expenses_5' => $request->input('expenses_5'),
            'amount_5' => $request->input('amount_5'),
            'expenses_6' => $request->input('expenses_6'),
            'amount_6' => $request->input('amount_6'),
            'expenses_7' => $request->input('expenses_7'),
            'amount_7' => $request->input('amount_7'),
            'expenses_8' => $request->input('expenses_8'),
            'amount_8' => $request->input('amount_8'),
        ]);

        $this->updateDailySales($salesEod->date, $newAmountToBankIn, 'total_eod');
        return redirect()->route('sales.index')->with('success', 'EOD updated successfully');
    }

    /* Sales Cash Bank-in */
    public function createBankin()
    {
        return view('sales.create_bankin');
    }

    public function storeBankin(Request $request)
    {
        $date = Carbon::parse($request->input('date'))->format('Y-m-d');
        $salesBankin = SalesBankin::create(array_merge($request->all(), ['date' => $date]));

        $this->updateDailySales($salesBankin->date, $salesBankin->amount, 'total_bankin');
        return redirect()->route('sales.index')->with('success', 'Bank-in added successfully.');
    }

    public function editBankin($id)
    {
        $salesBankin = SalesBankin::findOrFail($id);
        return view('sales.edit_bankin', compact('salesBankin'));
    }

    public function updateBankin(Request $request, $id, $cumu_id)
    {
        $date = Carbon::parse($request->input('date'))->format('Y-m-d');
        $validatedData = $request->validate([
            'amount' => 'required|numeric',
            'date' => 'required|date',
        ]);

        $salesBankin = SalesBankin::findOrFail($id);
        $salesBankin->update(array_merge($validatedData, ['date' => $date]));

        $this->updateDailySales($salesBankin->date, $salesBankin->amount, 'total_bankin');
        return redirect()->route('sales.index')->with('success', 'Bank-in updated successfully');
    }

    /* Sales Expense */
    public function createExpense()
    {
        return view('sales.create_expense');
    }

    public function storeExpense(Request $request)
    {
        $date = Carbon::parse($request->input('date'))->format('Y-m-d');
        $salesExpense = SalesExpense::create(array_merge($request->all(), ['date' => $date]));

        $this->updateDailySales($salesExpense->date, $salesExpense->amount, 'total_expenses');
        return redirect()->route('sales.index')->with('success', 'Expense added successfully.');
    }

    public function editExpense($id)
    {
        $salesExpense = SalesExpense::findOrFail($id);
        return view('sales.edit_expense', compact('salesExpense'));
    }

    public function updateExpense(Request $request, $id, $cumu_id)
    {
        $date = Carbon::parse($request->input('date'))->format('Y-m-d');
        $validatedData = $request->validate([
            'amount' => 'required|numeric',
            'date' => 'required|date',
        ]);

        $salesExpense = SalesExpense::findOrFail($id);
        $salesExpense->update(array_merge($validatedData, ['date' => $date]));

        $this->updateDailySales($salesExpense->date, $salesExpense->amount, 'total_expenses');
        return redirect()->route('sales.index')->with('success', 'Expense updated successfully');
    }

    /* Sales Earning */
    public function createEarning()
    {
        return view('sales.create_earning');
    }

    public function storeEarning(Request $request)
    {
        $date = Carbon::parse($request->input('date'))->format('Y-m-d');
        $salesEarning = SalesEarning::create(array_merge($request->all(), ['date' => $date]));

        $this->updateDailySales($salesEarning->date, $salesEarning->amount, 'total_earning');
        return redirect()->route('sales.index')->with('success', 'Earning added successfully.');
    }

    public function editEarning($id)
    {
        $salesEarning = SalesEarning::findOrFail($id);
        return view('sales.edit_earning', compact('salesEarning'));
    }

    public function updateEarning(Request $request, $id, $cumu_id)
    {
        $date = Carbon::parse($request->input('date'))->format('Y-m-d');
        $validatedData = $request->validate([
            'amount' => 'required|numeric',
            'date' => 'required|date',
        ]);

        $salesEarning = SalesEarning::findOrFail($id);
        $salesEarning->update(array_merge($validatedData, ['date' => $date]));

        $this->updateDailySales($salesEarning->date, $salesEarning->amount, 'total_earning');
        return redirect()->route('sales.index')->with('success', 'Earning updated successfully');
    }

    public function updateDailySales($date, $amount, $type)
    {
        $salesDaily = SalesDaily::firstOrNew(['date' => $date]);
        if($type == "total_expenses") {
            $salesDaily->total_expenses = $salesDaily->total_expenses + $amount;
        } elseif($type == "total_earning") {
            $salesDaily->total_earning = $salesDaily->total_earning + $amount;
        } elseif($type == "total_bankin") {
            $salesDaily->total_bankin = $amount;
        } elseif($type == "total_eod") {
            $salesDaily->total_eod = $amount;
        }

        $salesDaily->total_balance = $salesDaily->total_eod - $salesDaily->total_bankin - $salesDaily->total_expenses + $salesDaily->total_earning;
        $salesDaily->save();
    }

    public function details($date)
    {
        $dailySummary = SalesDaily::where('date', $date)->first();

        $date = Carbon::parse($date)->format('Y-m-d');
        
        $eodRecords = SalesEod::whereDate('date', $date)->get();
        $bankinRecords = SalesBankin::whereDate('date', $date)->get();
        $expenseRecords = SalesExpense::whereDate('date', $date)->get();
        $earningRecords = SalesEarning::whereDate('date', $date)->get();

        return view('sales.details', compact(
            'date',
            'dailySummary',
            'eodRecords',
            'bankinRecords',
            'expenseRecords',
            'earningRecords'
        ));
    }

    public function destroyEod(SalesEod $eod)
    {
        $eod->expenses()->delete();
        $eod->delete();
        $this->updateDailySales($eod->date, 0, 'total_eod');
        return redirect()->back()->with('success', 'EOD record deleted successfully');
    }

    public function destroyBankin(SalesBankin $bankin)
    {
        $bankin->delete();
        $this->updateDailySales($bankin->date, 0, 'total_bankin');
        return redirect()->back()->with('success', 'Bank-in record deleted successfully');
    }

    public function destroyExpense(SalesExpense $expense)
    {
        $expense->delete();
        $this->updateDailySales($expense->date, -$expense->amount, 'total_expenses');
        return redirect()->back()->with('success', 'Expense record deleted successfully');
    }

    public function destroyEarning(SalesEarning $earning)
    {
        $earning->delete();
        $this->updateDailySales($earning->date, -$earning->amount, 'total_earning');
        return redirect()->back()->with('success', 'Earning record deleted successfully');
    }
}
