<?php

namespace App\Http\Controllers\Admin;

use App\Models\Holiday;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HolidayController extends Controller
{
    // List all holidays
    public function index()
    {
        $holidays = Holiday::orderBy('date', 'asc')->get();
        return view('Admin.Holiday.index', compact('holidays'));
    }

    // Show create form
    public function create()
    {
        return view('Admin.Holiday.create');
    }

    // Store new holiday
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'date' => 'required|date|unique:holidays,date',
        ]);

        $data['created_by'] = Auth::id();

        Holiday::create($data);

        return redirect()->route('admin.holiday.index')->with('success', 'Holiday created successfully.');
    }

    // Show edit form
    public function edit(Holiday $holiday)
    {
        return view('Admin.Holiday.edit', compact('holiday'));
    }

    // Update holiday
    public function update(Request $request, Holiday $holiday)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'date' => 'required|date|unique:holidays,date,' . $holiday->id,
        ]);

        $holiday->update($data);

        return redirect()->route('admin.holiday.index')->with('success', 'Holiday updated successfully.');
    }

    // Delete holiday
    public function destroy(Holiday $holiday)
    {
        $holiday->delete();
        return redirect()->route('admin.holiday.index')->with('success', 'Holiday deleted successfully.');
    }
}
