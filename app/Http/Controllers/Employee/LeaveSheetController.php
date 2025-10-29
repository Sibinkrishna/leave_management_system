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
        $employeeId = Auth::user()->id;

        // Fetch all leaves for logged-in employee
        $leavesheets = LeaveSheet::where('emp_id', $employeeId)->get();

        $leaveTypes = ['Casual', 'Medical', 'WFH', 'Half Day'];
        $leavesGrouped = [];

        foreach ($leaveTypes as $type) {
            $leavesGrouped[$type] = $leavesheets
                ->where('leave_type', $type)
                ->map(function ($leave) {
                    $from = Carbon::parse($leave->start_date)->format('d-m-Y');
                    $to = Carbon::parse($leave->end_date)->format('d-m-Y');
                    return "$from to $to";
                })
                ->values()
                ->toArray();
        }

        return view('Employees.LeaveSheet.index', compact('leavesGrouped'));
    }
}
