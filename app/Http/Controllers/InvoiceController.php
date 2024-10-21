<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function index()
    {
        $currentMonth = now()->startOfMonth();
        
        $invoices = Invoice::whereMonth('submit_date', $currentMonth->month)
            ->whereYear('submit_date', $currentMonth->year)
            ->get();

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
        $deliveryTypes = ['fuji_bun', 'fuji_loaf', 'vtc', 'daq', 'agl', 'soda_express'];
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
            'deliveryRates'
        ));
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
            'receive_date' => 'nullable|date',
            'total_amount' => 'required|numeric',
            'status' => 'required|string',
            'type' => 'required|string',
        ]);

        Invoice::create($validatedData);

        return redirect()->route('invoices.index')->with('success', 'Invoice created successfully.');
    }
}
