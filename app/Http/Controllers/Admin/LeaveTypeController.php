<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\LeaveType;
use App\Http\Controllers\Controller;

class LeaveTypeController extends Controller
{
    /**
     * Display a listing of leave types.
     */
    public function index()
    {
        $leaveTypes = LeaveType::orderBy('name')->get();
        return view('Admin.LeaveType.index', compact('leaveTypes'));
    }

    /**
     * Show the form for creating a new leave type.
     */
    public function create()
    {
        return view('Admin.LeaveType.create');
    }

    /**
     * Store a newly created leave type in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'total_days_per_year' => 'required|integer|min:0',
            'carry_forward' => 'required|in:0,1',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        LeaveType::create($data);

        return redirect()
            ->route('admin.leavetype.index')
            ->with('success', 'Leave type created successfully.');
    }

    /**
     * Show the form for editing the specified leave type.
     */
    public function edit($id)
    {
        $leavetype = LeaveType::findOrFail($id);
        return view('Admin.LeaveType.edit', compact('leavetype'));
    }

    /**
     * Update the specified leave type in storage.
     */
    public function update(Request $request, $id)
    {
        $leaveType = LeaveType::findOrFail($id);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'total_days_per_year' => 'required|integer|min:0',
            'carry_forward' => 'required|in:0,1',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        $leaveType->update($data);

        return redirect()
            ->route('admin.leavetype.index')
            ->with('success', 'Leave type updated successfully.');
    }

    /**
     * Remove the specified leave type from storage.
     * This version prevents foreign key constraint errors.
     */
    public function destroy($id)
    {
        $leaveType = LeaveType::findOrFail($id);

        // ✅ Check if this leave type is linked to any leave applications
        if ($leaveType->leaveApplications()->exists()) {
            return redirect()
                ->route('admin.leavetype.index')
                ->with('error', 'Cannot delete this leave type because it is assigned to one or more leave applications.');
        }

        // If not linked, delete safely
        $leaveType->delete();

        return redirect()
            ->route('admin.leavetype.index')
            ->with('success', 'Leave type deleted successfully.');
    }

    /**
     * Optional: Show details of a leave type.
     */
}