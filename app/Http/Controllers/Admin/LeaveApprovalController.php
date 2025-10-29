<?php

namespace App\Http\Controllers\Admin;

use App\Models\PendingLeave;
use Illuminate\Http\Request;
use App\Models\LeaveApplication;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LeaveApprovalController extends Controller
{
    public function approve($id)
{
    $application = LeaveApplication::findOrFail($id);

    // Calculate number of days
    $days = $application->from_date->diffInDays($application->to_date) + 1;

    // Update leave status
    $application->status = 'approved';
    $application->approved_at = now();
    $application->save();

    // Update pending leaves table
    $pending = PendingLeave::where('user_id', $application->user_id)
        ->where('leave_type_id', $application->leave_type_id)
        ->where('year', now()->year)
        ->first();

    if ($pending) {
        $pending->used_leaves += $days;
        $pending->remaining_leaves = max(0, $pending->total_leaves - $pending->used_leaves);
        $pending->save();
    }

    return back()->with('success', 'Leave approved and balance updated!');
}
}
