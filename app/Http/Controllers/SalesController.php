<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SalesEod;
use App\Models\SalesEodExpense;
use App\Models\SalesCumulative;
use App\Models\SalesBankin;
use App\Models\SalesEarning;
use App\Models\SalesExpense;
use Carbon\Carbon;

class SalesController extends Controller
{
    public function index()
    {
        // Calculate total sales for the month
        $totalSales = SalesEod::sum('total_sales');

        // Calculate total expenses for the month
        $totalExpenses = SalesExpense::sum('amount') + SalesEodExpense::sum('amount');

        // Calculate credit card sales for the month
        $creditCardSales = SalesEod::sum('visa') + SalesEod::sum('debit') + SalesEod::sum('master');

        // Calculate e-wallet sales for the month
        $eWalletSales = SalesEod::sum('ewallet');

        // Calculate delivery sales for the month
        $deliverySales = SalesEod::sum('foodpanda') + SalesEod::sum('grabfood') + SalesEod::sum('shopeefood');

        // Get cumulative bank-in cash sales
        $cumulativeBankInSales = SalesCumulative::orderBy('date')->get();

        // Calculate total bank-in
        $totalBankin = SalesBankin::sum('amount');
        
        return view('sales.index', compact('totalSales', 'totalExpenses', 'creditCardSales', 'eWalletSales', 'deliverySales', 'cumulativeBankInSales', 'totalBankin'));
    }

    // EOD Sales
    public function createEod()
    {
        return view('sales.create_eod');
    }

    public function storeEod(Request $request)
    {
        // Collect expense data first
        $expensesData = $request->only(['expenses_1', 'amount_1', 'expenses_2', 'amount_2', 'expenses_3', 'amount_3', 'expenses_4', 'amount_4', 'expenses_5', 'amount_5', 'expenses_6', 'amount_6', 'expenses_7', 'amount_7', 'expenses_8', 'amount_8']);
        
        // Calculate total expenses
        $totalExpenses = array_sum(array_filter($expensesData, fn($key) => str_starts_with($key, 'amount_'), ARRAY_FILTER_USE_KEY));

        // Calculate total cash bank-in amount (EOD entry -> Bank-in)
        $totalBankinAmount = $request->cash - $request->ewallet - $totalExpenses + $request->cash_difference;

        $date = Carbon::parse($request->input('date'))->format('Y-m-d H:i:s');

        $salesEod = SalesEod::create(array_merge(
            $request->only(['debit', 'visa', 'master', 'cash', 'ewallet', 'foodpanda', 'grabfood', 'shopeefood', 'prepaid', 'voucher', 'total_sales', 'cash_difference']),
            ['amount_to_bank_in' => $totalBankinAmount, 'date' => $date]
        ));

        // Daily EOD Expenses
        $expensesData['sales_eod_id'] = $salesEod->id;
        $expensesData['date'] = $salesEod->date;
        SalesEodExpense::create($expensesData);

        // Cash Bank-in Amount - Cumulative
        SalesCumulative::create([
            'date' => $salesEod->date,
            'total_bankin_amount' => $totalBankinAmount,
            'sales_eod_id' => $salesEod->id,
        ]);

        return redirect()->route('sales.index')->with('success', 'Daily EOD Sales added successfully.');
    }

    // Bank-in
    public function createBankin()
    {
        return view('sales.create_bankin');
    }

    public function storeBankin(Request $request)
    {
        $bankin = SalesBankin::create($request->all());
        $this->updateCumulativeSales($bankin->id, $bankin->amount, 'sales_bankin');
        return redirect()->route('sales.index')->with('success', 'Bank-in added successfully.');
    }

    // Expense
    public function createExpense()
    {
        return view('sales.create_expense');
    }

    public function storeExpense(Request $request)
    {
        $expense = SalesExpense::create($request->all());
        $this->updateCumulativeSales($expense->id, $expense->amount, 'sales_expense');
        return redirect()->route('sales.index')->with('success', 'Expense added successfully.');
    }

    // Earning
    public function createEarning()
    {
        return view('sales.create_earning');
    }

    public function storeEarning(Request $request)
    {
        $earning = SalesEarning::create($request->all());
        $this->updateCumulativeSales($earning->id, $earning->amount, 'sales_earning');
        return redirect()->route('sales.index')->with('success', 'Earning added successfully.');
    }

    public function updateCumulativeSales($id, $amount, $type)
    {
        $latestCumulative = SalesCumulative::latest('id')->first();
        
        $newAmount = $latestCumulative->total_bankin_amount;

        if ($type === 'sales_bankin' || $type === 'sales_expense') {
            $newAmount -= $amount;
        } elseif ($type === 'sales_earning') {
            $newAmount += $amount;
        }

        SalesCumulative::create([
            'date' => now(),
            'total_bankin_amount' => $newAmount,
            $type . '_id' => $id,
        ]);
    }

    public function showDetails($id)
    {
        // Fetch the sales record by ID
        $salesRecord = SalesCumulative::findOrFail($id);

        // Determine the type of record and fetch additional details if necessary
        $details = null;
        if ($salesRecord->sales_eod_id) {
            $details = SalesEod::find($salesRecord->sales_eod_id);
        } elseif ($salesRecord->sales_bankin_id) {
            $details = SalesBankin::find($salesRecord->sales_bankin_id);
        } elseif ($salesRecord->sales_expense_id) {
            $details = SalesExpense::find($salesRecord->sales_expense_id);
        } elseif ($salesRecord->sales_earning_id) {
            $details = SalesEarning::find($salesRecord->sales_earning_id);
        }

        return view('sales.details', compact('salesRecord', 'details'));
    }
}
