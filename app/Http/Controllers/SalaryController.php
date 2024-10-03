<?php

namespace App\Http\Controllers;

use App\Models\Salary;
use App\Models\Staff;
use Illuminate\Http\Request;

class SalaryController extends Controller
{
    public function index()
    {
        $salaries = Salary::with('staff')->get();
        return view('salaries.index', compact('salaries'));
    }

    public function generate(Request $request)
    {
        $validated = $request->validate([
            'month' => 'required|integer|between:1,12',
            'year' => 'required|integer|min:2000',
        ]);

        $staff = Staff::all();

        foreach ($staff as $employee) {
            $salary = $employee->calculateSalary($validated['month'], $validated['year']);
            Salary::updateOrCreate(
                ['staff_id' => $employee->id, 'month' => $validated['month'], 'year' => $validated['year']],
                $salary
            );
        }

        return redirect()->route('salaries.index')->with('success', 'Salaries generated successfully.');
    }
}
