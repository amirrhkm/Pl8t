<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Invoice;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function index(Request $request)
    {
        // Start building the query
        $query = Invoice::query();

        // Apply filters
        if ($request->filled('month')) {
            $selectedMonth = $request->month;
            $currentYear = now()->year;
            $query->whereMonth('submit_date', $selectedMonth)
                ->whereYear('submit_date', $currentYear);
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Always order by latest submit_date and limit to 20
        $query->latest('submit_date')->take(20);

        // Execute the query
        $invoices = $query->get();

        $totalInvoices = $invoices->count();
        $receivedInvoices = $invoices->where('status', 'received')->count();
        $pendingInvoices = $invoices->where('status', 'pending')->count();
        $overdueInvoices = $invoices->where('status', 'overdue')->count();
        $totalAmount = $invoices->sum('total_amount');

        // Update overdue status
        $invoices->each(function ($invoice) {
            if ($invoice->status === 'pending' && $invoice->submit_date->addDays(7)->isPast()) {
                $invoice->update(['status' => 'overdue']);
            }
        });

        // Calculate delivery on-time rates
        $deliveryTypes = ['ambient', 'fuji_loaf', 'vtc', 'frozen', 'mcqwin', 'soda_express', 'small_utilities', 'mc2_water_filter', 'other'];
        $deliveryRates = [];
        foreach ($deliveryTypes as $type) {
            $typeInvoices = $invoices->where('type', $type);
            $onTimeCount = $typeInvoices->where('status', 'received')->count();
            $totalCount = $typeInvoices->count();
            $rate = $totalCount > 0 ? round(($onTimeCount / $totalCount) * 100, 2) : 0;
            $deliveryRates[$type] = $rate;
        }

        return view('invoices.index', compact(
            'invoices',
            'totalInvoices',
            'receivedInvoices',
            'pendingInvoices',
            'overdueInvoices',
            'totalAmount',
            'deliveryRates',
            'typeInvoices',
        ));
    }

    public function formatType($type)
    {
        return Invoice::TYPE[$type];
    }

    public function create()
    {
        return view('invoices.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'do_id' => 'required|integer',
            'submit_date' => 'required|date',
            'receive_date' => [
                'nullable',
                'date',
                'after_or_equal:submit_date',
            ],
            'total_amount' => 'required|numeric',
            'status' => 'required|string',
            'type' => 'required|string',
            'remarks' => 'nullable|string',
        ]);

        Invoice::create($validatedData);

        return redirect()->route('invoices.index')->with('success', 'Invoice created successfully.');
    }

    public function edit(Invoice $invoice)
    {
        return view('invoices.edit', compact('invoice'));
    }

    public function update(Request $request, Invoice $invoice)
    {
        $validatedData = $request->validate([
            'do_id' => 'required|integer',
            'submit_date' => 'required|date',
            'receive_date' => [
                'nullable',
                'date',
                'after_or_equal:submit_date',
            ],
            'total_amount' => 'required|numeric',
            'status' => 'required|string',
            'type' => 'required|string',
            'remarks' => 'nullable|string',
        ]);

        $invoice->update($validatedData);

        return redirect()->route('invoices.index')->with('success', 'Invoice updated successfully.');
    }
}
