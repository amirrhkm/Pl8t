<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    public function index()
    {
        $staff = Staff::all();
        return view('staff.index', ['staffs' => $staff]);
    }

    public function create()
    {
        return view('staff.create');
    }

    public function show(Staff $staff)
    {
        return view('staff.detail', ['staff' => $staff]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'nickname' => 'required|string|max:255',
            'employment_type' => 'required|in:part_time,full_time',
            'position' => 'required|in:bar,kitchen,flexible',
            'rate' => 'nullable|numeric|min:0',
        ]);

        Staff::create($validated);

        return redirect()->route('staff.index')->with('success', 'Staff created successfully.');
    }

    public function edit(Staff $staff)
    {
        return view('staff.edit', compact('staff'));
    }

    public function update(Request $request, Staff $staff)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'nickname' => 'required|string|max:255',
        'employment_type' => 'required|in:part_time,full_time',
        'position' => 'required|in:bar,kitchen,flexible',
        'rate' => 'nullable|numeric|min:0',
    ]);

    $staff->update($request->all());

    return redirect('/staff/'. $staff->id)->with('success', 'Staff updated successfully.');
}


    public function destroy(Staff $staff)
    {
        $staff->delete();
        return redirect()->route('staff.index')->with('success', 'Staff deleted successfully.');
    }
}
