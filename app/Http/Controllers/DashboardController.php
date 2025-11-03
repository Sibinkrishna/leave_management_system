<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
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

        // ✅ Calculate total worked hours dynamically
        $totalHoursWorked = 0;
        foreach ($attendances as $attendance) {
            if ($attendance->check_in && $attendance->check_out) {
                $checkIn = Carbon::parse($attendance->check_in);
                $checkOut = Carbon::parse($attendance->check_out);
                $hours = $checkOut->diffInMinutes($checkIn) / 60;
                $totalHoursWorked += $hours;
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
}
