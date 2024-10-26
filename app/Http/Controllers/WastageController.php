<?php

namespace App\Http\Controllers;

use App\Models\Wastage;
use Illuminate\Http\Request;
use Carbon\Carbon;

class WastageController extends Controller
{
    public function index()
    {
        $wastages = Wastage::latest()->paginate(10);
        return view('wastages.index', compact('wastages'));
    }

    public function create()
    {
        return view('wastages.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'item' => 'required|string|max:255',
            'quantity' => 'nullable|integer|min:1',
            'weight' => 'nullable|numeric|min:0.001',
            'reason' => 'nullable|string',
        ]);

        $date = Carbon::parse($request->input('date'))->format('Y-m-d H:i:s');
        
        // Ensure weight is stored with full precision
        if (isset($validated['weight'])) {
            $validated['weight'] = number_format((float)$validated['weight'], 6, '.', '');
        }

        Wastage::create(array_merge($validated, ['date' => $date]));

        return redirect()->route('invoices.index')->with('success', 'Wastage record created successfully.');
    }

    public function show(Wastage $wastage)
    {
        return view('wastages.show', compact('wastage'));
    }

    public function edit(Wastage $wastage)
    {
        return view('wastages.edit', compact('wastage'));
    }

    public function update(Request $request, Wastage $wastage)
    {
        $validated = $request->validate([
            'item' => 'required|string|max:255',
            'quantity' => 'nullable|integer|min:1',
            'weight' => 'nullable|numeric|min:0.001',
            'reason' => 'nullable|string',
        ]);

        $date = Carbon::parse($request->input('date'))->format('Y-m-d H:i:s');

        // Ensure weight is stored with full precision
        if (isset($validated['weight'])) {
            $validated['weight'] = number_format((float)$validated['weight'], 6, '.', '');
        }

        $wastage->update(array_merge($validated, ['date' => $date]));

        return redirect()->route('invoices.index')->with('success', 'Wastage record updated successfully.');
    }

    public function destroy(Wastage $wastage)
    {
        $wastage->delete();

        return redirect()->route('invoices.index')->with('success', 'Wastage record deleted successfully.');
    }
}
