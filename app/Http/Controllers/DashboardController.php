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

            // Employee join date
            $joinDate = Carbon::parse($user->joining_date);

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

            // Working days (Mon–Fri), but starting from join date
            // Working days (Mon–Fri), but starting from join date
            $startOfMonth = Carbon::now()->startOfMonth();
            if ($joinDate->greaterThan($startOfMonth)) {
                $startOfMonth = $joinDate->copy(); // start counting from join date
            }

            $workingDays = 0;
            $currentDate = $startOfMonth->copy();
            while ($currentDate->lte($today)) {
                if (!$currentDate->isWeekend()) {
                    $workingDays++;
                }
                $currentDate->addDay();
            }

            // Total present in current month (only on/after join date)
            $totalPresent = $attendances
                ->filter(function ($attendance) use ($joinDate) {
                    return Carbon::parse($attendance->attendance_date)->gte($joinDate)
                        && strtolower($attendance->status) === 'present';
                })
                ->count();

            // Total absent = workingDays – totalPresent
            $totalAbsent = max($workingDays - $totalPresent, 0);


            // Total hours worked
            $totalHoursWorked = 0;
            foreach ($attendances as $attendance) {
                if ($attendance->check_in && $attendance->check_out) {
                    $checkIn = Carbon::parse($attendance->check_in);
                    $checkOut = Carbon::parse($attendance->check_out);
                    $hours = abs($checkOut->diffInMinutes($checkIn)) / 60;
                    $totalHoursWorked += $hours;
                }
            }

            // To check if today employee is on approved leave
            $isOnLeaveToday = LeaveApplication::where('user_id', $userId)
                ->whereRaw('LOWER(status) = ?', ['approved'])
                ->whereDate('start_date', '<=', $today)
                ->whereDate('end_date', '>=', $today)
                ->exists();

            return view('Admin.dashboard', compact(
                'attendances',
                'totalDays',
                'totalPresent',
                'totalAbsent',
                'totalHoursWorked',
                'monthName',
                'currentYear',
                'isOnLeaveToday'
            ));
        }

        // =============================
        // Admin Dashboard
        // =============================
        $totalEmployees = User::where('role', 'employee')->count();
        $today = Carbon::today()->toDateString();

        // Leaves today
        $leavesToday = LeaveApplication::whereRaw('LOWER(status) = ?', ['approved'])
            ->whereDate('start_date', '<=', $today)
            ->whereDate('end_date', '>=', $today)
            ->with('user')
            ->get();

        // Attendance today
        $attendanceToday = Attendance::with('employee')
            ->whereDate('attendance_date', $today)
            ->get();

        $totalLeavesToday = $leavesToday->count();
        $totalAttendanceToday = $attendanceToday->count();

        return view('Admin.dashboard', compact(
            'totalEmployees',
            'leavesToday',
            'attendanceToday',
            'totalLeavesToday',
            'totalAttendanceToday'
        ));
    }
}
