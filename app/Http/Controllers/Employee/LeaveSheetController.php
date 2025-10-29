<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LeaveSheet;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class LeaveSheetController extends Controller
{
    public function index()
    {
        $employee = Auth::user();

    // Summary section
    $pendingLeaves = $employee->pendingLeaves()->with('leaveType')->where('year', now()->year)->get();
    // dd( $pendingLeaves);
    $totalAll = [
        'total_leaves'     => $pendingLeaves->sum('total_leaves'),
        'used_leaves'      => $pendingLeaves->sum('used_leaves'),
        'remaining_leaves' => $pendingLeaves->sum('remaining_leaves'),
    ];

    // Detailed leave sheet section
    $leaveApplications = $employee->leaveApplications()
        ->with('leaveType')
        ->orderByDesc('start_date')
        ->get();

    return view('Employees.LeaveSheet.index', compact('pendingLeaves', 'leaveApplications', 'totalAll'));
    }
}