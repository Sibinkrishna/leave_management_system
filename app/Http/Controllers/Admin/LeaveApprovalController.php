<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LeaveApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class LeaveApprovalController extends Controller
{
    // Show all leave applications for admin
    public function index()
    {
        //  $leaves = \App\Models\LeaveApplication::with('user', 'leaveType')
        // ->select('id', 'user_id', 'leave_type_id', 'start_date', 'end_date', 'days', 'status', 'subject', 'reason')
        // ->orderBy('id', 'desc')
        // ->get();
        $leaves = LeaveApplication::with('user', 'leaveType')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('Admin.Leave.index', compact('leaves'));
    }

    // Approve a leave
    public function approve($id)
    {
        $leave = LeaveApplication::findOrFail($id);
        $leave->status = 'approved';
        $leave->approved_by = Auth::id();
        $leave->approval_date = Carbon::now();
        $leave->save();

        return redirect()->back()->with('success', 'Leave approved successfully!');
    }

    // Reject a leave
    public function reject($id)
    {
        $leave = LeaveApplication::findOrFail($id);
        $leave->status = 'rejected';
        $leave->approved_by = Auth::id();
        $leave->approval_date = Carbon::now();
        $leave->save();

        return redirect()->back()->with('error', 'Leave rejected successfully!');
    }
    
}
