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
            // 'subject' => 'required|string|max:255',
            'reason' => 'required|string|max:500',
        ]);
        // Calculate number of days
        $start = Carbon::parse($request->start_date);
        $end = Carbon::parse($request->end_date);
        $days = $start->diffInDays($end) + 1; //+1 to include both start and end date

        // $days = (new \DateTime($request->start_date))->diff(new \DateTime($request->end_date))->days + 1;

        LeaveApplication::create([
            'user_id' => Auth::id(),
            'leave_type_id' => $request->leave_type_id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            // 'subject' => $request->subject,
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
