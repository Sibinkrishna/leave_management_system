<?php

namespace App\Http\Controllers\Admin;

use App\Models\PendingLeave;
use Illuminate\Http\Request;
use App\Models\LeaveApplication;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LeaveApprovalController extends Controller
{
    public function index()
    {
        $leaveApplications = LeaveApplication::with(['user', 'leaveType'])
            // ->where('status', 'pending')
            ->orderByDesc('created_at')
            ->get();

        return view('Admin.Leave.index', compact('leaveApplications'));
    }

    public function approve($id)
{
    $application = LeaveApplication::findOrFail($id);

    // Use EXACT days stored in DB (0.5 OR 1 OR multi-day)
    $days = $application->days;  // ← THIS FIXES HALF DAY ISSUE
    
    // Update leave status
    $application->status = 'approved';
    $application->approval_date = now();
    $application->save();

    // Update pending leaves table
    $pending = PendingLeave::where('user_id', $application->user_id)
        ->where('leave_type_id', $application->leave_type_id)
        ->where('year', now()->year)
        ->first();

    if ($pending) {
        $pending->used += $days;
        $pending->remaining = max(0, $pending->total - $pending->used);
        $pending->save();
    }

    return back()->with('success', 'Leave approved and balance updated!');
}
public function reject($id)
{
    $application = LeaveApplication::findOrFail($id);

    $application->status = 'rejected';
    $application->approval_date = now();
    $application->save();

    return back()->with('success', 'Leave rejected successfully!');
}

}