<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Leave;
use App\Models\Attendance;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // ✅ Employee Dashboard
        if ($user->role === 'employee') {
            $userId = $user->id;
            $currentMonth = Carbon::now()->month;
            $currentYear = Carbon::now()->year;
            $monthName = Carbon::now()->format('F');

            $attendances = Attendance::where('user_id', $userId)
                ->whereMonth('attendance_date', $currentMonth)
                ->whereYear('attendance_date', $currentYear)
                ->orderBy('attendance_date', 'desc')
                ->get();

            $totalDays = $attendances->count();
            $totalPresent = $attendances->where('status', 'present')->count();
            $totalAbsent = $attendances->where('status', 'absent')->count();

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

        // Admin Dashboard
else {
    $totalEmployees = User::where('role', 'employee')->count();

    $today = Carbon::today();

    // Employees on leave today
  $leavesToday = Leave::whereRaw('LOWER(status) = ?', ['approved'])
    ->whereDate('start_date', '<=', $today)
    ->whereDate('end_date', '>=', $today)
    ->with('employee')
    ->get();


    // Employees present today (names)
    $attendanceToday = Attendance::whereDate('attendance_date', $today)
        ->where('status', 'present')
        ->with('employee') // Eager load employee
        ->get();

    return view('Admin.dashboard', compact(
        'totalEmployees',
        'leavesToday',
        'attendanceToday'
    ));
}

    }
}
