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
       // ✅ Fetch pending leave applications for this user
        $pendingLeaves = LeaveApplication::with('leaveType')
            ->where('user_id', $employeeId)
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->get();

         // ✅ Summary counts
        $totalAll = [
            'total_leaves' => $pendingLeaves->count(),
            'used_leaves' => 0,
            'remaining_leaves' => 0,
    ];
        return view('Employees.PendingLeave.index', compact('pendingLeaves', 'totalAll'));
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