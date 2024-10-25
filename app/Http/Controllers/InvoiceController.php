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
        $totalAmount = Invoice::whereMonth('submit_date', now()->month)
            ->whereYear('submit_date', now()->year)
            ->sum('total_amount');

        // Update overdue status (defected)
        // $invoices->each(function ($invoice) {
        //     // Ambient DO estimated delivery date
        //     if ($invoice->type === 'ambient') {
        //         if ($invoice->submit_date->isTuesday()) {
        //             $ambientDaysTillOverdue = $invoice->submit_date->diffInDays($invoice->submit_date->next(Carbon::WEDNESDAY)->next(Carbon::WEDNESDAY));
        //         } else {
        //             $ambientDaysTillOverdue = $invoice->submit_date->diffInDays($invoice->submit_date->next(Carbon::WEDNESDAY));
        //         }

        //         if ($invoice->status === 'pending' && $invoice->submit_date->addDays($ambientDaysTillOverdue)->isPast()) {
        //             $invoice->update(['status' => 'overdue']);
        //         }
        //     }

        //     // Frozen DO estimated delivery date
        //     if ($invoice->type === 'frozen') {
        //         if ($invoice->submit_date->isFriday() || $invoice->submit_date->isSaturday() || $invoice->submit_date->isSunday()) {
        //             $frozenDaysTillOverdue = $invoice->submit_date->diffInDays($invoice->submit_date->next(Carbon::MONDAY)->next(Carbon::MONDAY));
        //         } else {
        //             $frozenDaysTillOverdue = $invoice->submit_date->diffInDays($invoice->submit_date->next(Carbon::MONDAY));
        //         }

        //         if ($invoice->status === 'pending' && $invoice->submit_date->addDays($frozenDaysTillOverdue)->isPast()) {
        //             $invoice->update(['status' => 'overdue']);
        //         }
        //     }

        //     // Fuji Loaf DO estimated delivery date
        //     if ($invoice->type === 'fuji_loaf') {
        //         if ($invoice->submit_date->isThursday()) {
        //             $fujiLoafDaysTillOverdue = $invoice->submit_date->diffInDays($invoice->submit_date->next(Carbon::WEDNESDAY));
        //         } elseif ($invoice->submit_date->isFriday()) {
        //             $fujiLoafDaysTillOverdue = $invoice->submit_date->diffInDays($invoice->submit_date->next(Carbon::FRIDAY));
        //         } else {
        //             $fujiLoafDaysTillOverdue = $invoice->submit_date->diffInDays($invoice->submit_date->next(Carbon::MONDAY));
        //         }

        //         if ($invoice->status === 'pending' && $invoice->submit_date->addDays($fujiLoafDaysTillOverdue)->isPast()) {
        //             $invoice->update(['status' => 'overdue']);
        //         }
        //     }

        //     // VTC DO estimated delivery date
        //     if ($invoice->type === 'vtc') {
        //         $nextDeliveryDate = $invoice->submit_date->copy();
        //         while (!$nextDeliveryDate->isMonday() && !$nextDeliveryDate->isWednesday() && !$nextDeliveryDate->isFriday()) {
        //             $nextDeliveryDate->addDay();
        //         }
        //         $vtcDaysTillOverdue = $invoice->submit_date->diffInDays($nextDeliveryDate);
            
        //         if ($invoice->status === 'pending' && $invoice->submit_date->addDays($vtcDaysTillOverdue)->isPast()) {
        //             $invoice->update(['status' => 'overdue']);
        //         }
        //     }

        //     // MCQWIN DO estimated delivery date
        //     if ($invoice->type === 'mcqwin') {
        //         $mcqwinDaysTillOverdue = 2;
        //         $deliveryDate = $invoice->submit_date->copy();
                
        //         for ($i = 0; $i < $mcqwinDaysTillOverdue; $i++) {
        //             $deliveryDate->addWeekday();
        //         }

        //         if ($invoice->status === 'pending' && $deliveryDate->isPast()) {
        //             $invoice->update(['status' => 'overdue']);
        //         }
        //     }

        //     // Soda Express, Small Utilities, MC2 Water Filter, Other DO estimated delivery date
        //     if ($invoice->type === 'soda_express' || $invoice->type === 'small_utilities' || $invoice->type === 'mc2_water_filter' || $invoice->type === 'other') {
        //         $otherDaysTillOverdue = 30;
                
        //         if ($invoice->status === 'pending' && $invoice->submit_date->addDays($otherDaysTillOverdue)->isPast()) {
        //             $invoice->update(['status' => 'overdue']);
        //         }
        //     }
        // });

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

    public function destroy(Invoice $invoice)
    {
        $invoice->delete();
        return redirect()->route('invoices.index')->with('success', 'Invoice deleted successfully.');
    }
}
