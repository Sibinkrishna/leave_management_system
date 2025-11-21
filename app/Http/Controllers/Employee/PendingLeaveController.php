<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\LeaveType;
use App\Models\PendingLeave;

class PendingLeaveController extends Controller
{
    /**
     * Show pending leaves page
     */
    public function index()
    {
        $employeeId = Auth::id();

        // Fetch employee pending leaves for current year
        $pendingLeaves = PendingLeave::with('leaveType')
            ->where('user_id', $employeeId)
            ->where('year', now()->year)
            ->get();

                // Format numbers correctly (remove .0 keep .5)
        $format = function ($value) {
            return ($value == intval($value)) ? intval($value) : rtrim(rtrim($value, '0'), '.');
        };

        // Total footer calculations
        $totalAll = [
            'total_leaves'     => $pendingLeaves->sum('total'),
            'used_leaves'      => $pendingLeaves->sum('used'),
            'remaining_leaves' => $pendingLeaves->sum('remaining'),
        ];

        return view('Employees.PendingLeave.index', compact('pendingLeaves', 'totalAll'));
    }

    /**
     * Assign yearly leave types to employee
     */
    public function assignEmployeeLeaves()
    {
        $employeeId = Auth::id();

        // Fetch all active leave types
        $leaveTypes = LeaveType::where('status', 'active')->get();

        foreach ($leaveTypes as $type) {

            // Check if record already exists
            $existing = PendingLeave::where('user_id', $employeeId)
                ->where('leave_type_id', $type->id)
                ->where('year', now()->year)
                ->first();

            if (!$existing) {
                PendingLeave::create([
                    'user_id'       => $employeeId,
                    'leave_type_id' => $type->id,
                    'year'          => now()->year,
                    'total'         => $type->total_days_per_year, // yearly total
                    'used'          => 0.0,
                    'remaining'     => $type->total_days_per_year,
                ]);
            }
        }

        return redirect()->back()->with('success', 'Leave types assigned successfully.');
    }
}
