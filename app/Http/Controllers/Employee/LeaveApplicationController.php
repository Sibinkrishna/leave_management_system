<?php

namespace App\Http\Controllers\Employee;
use App\Http\Controllers\Controller;
use App\Models\LeaveApplication;
use App\Models\LeaveType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class LeaveApplicationController extends Controller
{
    // Show form to apply leave
    public function create()
    {
        $leaveTypes = LeaveType::all();
        return view('Employees.LeaveApplication.create', compact('leaveTypes'));
    }

    // Store leave application
   public function store(Request $request)
{
    $request->validate([
        'leave_type_id' => 'required|exists:leave_types,id',
        'start_date' => 'required|date',
        'end_date' => 'required|date|after_or_equal:start_date',
        'subject' => 'required|string|max:255',
        'reason' => 'required|string|max:500',
        'day_type' => 'required',
    ]);

    // DAY TYPE
    $dayType = $request->day_type;

    // CALCULATE DAYS PROPERLY
    if ($dayType == 'half_fn' || $dayType == 'half_an') {

        // HALF DAY
        $days = 0.5;

    } else {

        // FULL DAY (Calculate including date range)
        $days = Carbon::parse($request->start_date)
                    ->diffInDays($request->end_date) + 1;
    }

    LeaveApplication::create([
        'user_id' => Auth::id(),
        'leave_type_id' => $request->leave_type_id,
        'start_date' => $request->start_date,
        'end_date' => $request->end_date,
        'day_type' => $dayType,
        'subject' => $request->subject,
        'reason' => $request->reason,
        'days' => $days,
        'status' => 'pending',
    ]);

       return redirect()->route('employee.leaveapplication.index')->with('success', 'Leave applied successfully!');

    }

    // Show list of my leaves
   public function index()
    {
        $employeeId = Auth::id();
        $leaves = LeaveApplication::where('user_id', $employeeId)->orderBy('created_at', 'desc')->get();
        return view('Employees.LeaveApplication.index', compact('leaves'));
    }   
            
}