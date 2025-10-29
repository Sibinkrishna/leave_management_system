<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\LeaveApplication;
use App\Models\LeaveType;
use App\Models\PendingLeave;

class PendingLeaveController extends Controller
{
    public function index()
    {
        $employeeId = Auth::user()->id;
        $leave_types = LeaveType::all();
        $employeeLeaves = PendingLeave::with('leaveType')
                        ->where('emp_id', $employeeId)
                        ->get();



        return view('Employees.PendingLeave.index', compact('leave_types','employeeLeaves'));
    }
    public function assignEmployeeLeaves()
{
    $employeeId = Auth::user()->id;

    // Get all leave types
    $leaveTypes = LeaveType::where('status','active')->get();

    foreach ($leaveTypes as $type) {
        // Check if employee already has this leave type
        $existing = PendingLeave::where('emp_id', $employeeId)
                                 ->where('leave_type_id', $type->id)
                                 ->first();

        // If not, create it
        if (!$existing) {
            PendingLeave::create([
                'emp_id'    => $employeeId,
                'leave_type_id'  => $type->id,
                'total_days'     => $type->total_days_per_year,
                'used_days'      => 0,
                'remaining_days' => $type->max_days,
            ]);
        }
    }

    return redirect()->back()->with('success', 'Leave types assigned successfully.');
}

}
