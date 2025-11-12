<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Leave;
use App\Models\Attendance;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\LeaveApplication;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $today = Carbon::today();

        // =============================
        // Employee Dashboard
        // =============================
        if ($user->role === 'employee') {
            $userId = $user->id;
            $currentMonth = Carbon::now()->month;
            $currentYear = Carbon::now()->year;
            $monthName = Carbon::now()->format('F');

            // Attendance for this month
            $attendances = Attendance::where('user_id', $userId)
                ->whereMonth('attendance_date', $currentMonth)
                ->whereYear('attendance_date', $currentYear)
                ->orderBy('attendance_date', 'desc')
                ->get();

            // Total days recorded
            $totalDays = $attendances->count();

            // Total present
            $totalPresent = $attendances->where('status', 'present')->count();

            // Working days (Mon-Fri)
            $startOfMonth = Carbon::now()->startOfMonth();
            $workingDays = 0;
            for ($date = $startOfMonth->copy(); $date->lte($today); $date->addDay()) {
                if (!$date->isWeekend()) {
                    $workingDays++;
                }
            }

            // Approved leaves for this month
            $approvedLeaves = Leave::where('employee_id', $userId)
                ->whereRaw('LOWER(status) = ?', ['approved'])
                ->whereMonth('start_date', $currentMonth)
                ->count();

            // Total absent
            $totalAbsent = max($workingDays - ($totalPresent + $approvedLeaves), 0);

            // Total hours worked
            $totalHoursWorked = 0;
            foreach ($attendances as $attendance) {
                if ($attendance->check_in && $attendance->check_out) {
                    $checkIn = Carbon::parse($attendance->check_in);
                    $checkOut = Carbon::parse($attendance->check_out);
                    $totalHoursWorked += $checkOut->diffInMinutes($checkIn) / 60;
                }
            }

            return view('Admin.dashboard', compact(
                'attendances',
                'totalDays',
                'totalPresent',
                'totalAbsent',
                'totalHoursWorked',
                'monthName',
                'currentYear'
            ));
        }

        // =============================
        // Admin Dashboard
$totalEmployees = User::where('role', 'employee')->count();
$today = Carbon::today()->toDateString();

// Leaves today
$leavesToday = LeaveApplication::whereRaw('LOWER(status) = ?', ['approved'])
    ->whereDate('start_date', '<=', $today)
    ->whereDate('end_date', '>=', $today)
    ->with('employee') // Make sure LeaveApplication has employee() relationship
    ->get();

// Attendance today
$attendanceToday = Attendance::with('employee')
    ->whereDate('attendance_date', $today)
    ->get();

// Pass counts as separate variables
$totalLeavesToday = $leavesToday->count();
$totalAttendanceToday = $attendanceToday->count();

// ✅ Pass everything to the view
return view('Admin.dashboard', compact(
    'totalEmployees',
    'leavesToday',
    'attendanceToday',
    'totalLeavesToday',
    'totalAttendanceToday'
));

        }
    }

