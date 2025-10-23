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
        // Get logged-in employee ID
        $employeeId = Auth::user()->id;

        // Fetch only this employee’s pending leaves
        $pendingLeaves = PendingLeave::where('emp_id', $employeeId)
            ->where('status', 'Pending')
            ->orderBy('from_date', 'desc')
            ->get();

        return view('Employees.PendingLeave.index', compact('pendingLeaves'));
    }
}
