<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LeaveSheet;
use Illuminate\Support\Facades\Auth;

class LeaveSheetController extends Controller
{
    public function index()
    {
        $employeeId = Auth::user()->id;

        $leavesheets = LeaveSheet::where('emp_id', $employeeId)->get();

        $leaveTypes = ['Casual', 'Medical', 'WFH', 'Half Day'];
        $leavesGrouped = [];

        foreach ($leaveTypes as $type) {
            $leavesGrouped[$type] = $leavesheets->where('leave_type', $type)
                ->pluck('start_date')
                ->map(fn($date) => \Carbon\Carbon::parse($date)->format('d-m-Y'))
                ->toArray();
        }

        return view('Employees.LeaveSheet.index', compact('leavesGrouped'));
    }
}
