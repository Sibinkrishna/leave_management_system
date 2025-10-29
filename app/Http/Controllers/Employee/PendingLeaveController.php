<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PendingLeave;
use Illuminate\Support\Facades\Auth;

class PendingLeaveController extends Controller
{
    public function index()
    {
        $employeeId = Auth::user()->id;
        $pendingLeaves = PendingLeave::with('leaveType')
            ->where('user_id', $employeeId)
            ->where('year', now()->year)
            ->get();
        $totalAll = [
        'total_leaves'     => $pendingLeaves->sum('total'),
        'used_leaves'      => $pendingLeaves->sum('used'),
        'remaining_leaves' => $pendingLeaves->sum('remaining'),
    ];
        return view('Employees.PendingLeave.index', compact('pendingLeaves', 'totalAll'));
    }
}
