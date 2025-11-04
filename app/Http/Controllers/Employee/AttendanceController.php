<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Holiday;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    // ✅ Check-In Logic
    public function checkIn()
    {
        $userId = Auth::id();
        $today = Carbon::today();

        $existing = Attendance::where('user_id', $userId)
            ->where('attendance_date', $today)
            ->first();

        if ($existing) {
            return back()->with('error', 'You have already checked in today.');
        }

        Attendance::create([
            'user_id' => $userId,
            'attendance_date' => $today,
            'check_in' => now(),
            'status' => 'present',
            'duration_minutes' => 0,
        ]);

        return back()->with('success', 'Check-in recorded successfully!');
    }

    // ✅ Check-Out Logic
    public function checkOut()
    {
        $userId = Auth::id();
        $today = Carbon::today();

        $attendance = Attendance::where('user_id', $userId)
            ->where('attendance_date', $today)
            ->first();

        if (!$attendance) {
            return back()->with('error', 'Please check in first!');
        }

        if ($attendance->check_out) {
            return back()->with('error', 'You have already checked out today.');
        }

        $attendance->check_out = now();

        $checkIn = Carbon::parse($attendance->check_in);
        $checkOut = Carbon::parse($attendance->check_out);

        $durationMinutes = $checkOut->diffInMinutes($checkIn);
        $attendance->duration_minutes = $durationMinutes;
        $attendance->save();

        return back()->with('success', 'Check-out recorded successfully!');
    }

    // ✅ Records Page
    public function records(Request $request)
    {
        $month = $request->get('month', date('m'));
        $year = $request->get('year', date('Y'));
        $userId = Auth::id();

        $attendances = Attendance::whereYear('attendance_date', $year)
            ->whereMonth('attendance_date', $month)
            ->where('user_id', $userId)
            ->get()
            ->keyBy('attendance_date');

        $holidays = Holiday::whereYear('date', $year)
            ->whereMonth('date', $month)
            ->pluck('date')
            ->map(fn($d) => Carbon::parse($d)->toDateString())
            ->toArray();

        $records = [];
        $today = now()->startOfDay();
        $daysInMonth = Carbon::create($year, $month)->daysInMonth;

        for ($day = 1; $day <= $daysInMonth; $day++) {
            $date = Carbon::create($year, $month, $day)->startOfDay();

            if ($date->greaterThan($today)) continue;

            // ✅ Weekend
            if ($date->isSaturday() || $date->isSunday()) {
                $records[] = [
                    'date' => $date->format('d M Y'),
                    'check_in' => '--',
                    'check_out' => '--',
                    'duration' => '--',
                    'status' => 'Weekend',
                ];
                continue;
            }

            // ✅ Holiday
            if (in_array($date->toDateString(), $holidays)) {
                $records[] = [
                    'date' => $date->format('d M Y'),
                    'check_in' => '--',
                    'check_out' => '--',
                    'duration' => '--',
                    'status' => 'Holiday',
                ];
                continue;
            }

            // ✅ Attendance Record
            if (isset($attendances[$date->toDateString()])) {
                $attendance = $attendances[$date->toDateString()];
                $records[] = [
                    'date' => $date->format('d M Y'),
                    'check_in' => $attendance->check_in ? Carbon::parse($attendance->check_in)->format('h:i A') : '--',
                    'check_out' => $attendance->check_out ? Carbon::parse($attendance->check_out)->format('h:i A') : '--',
                    'duration' => $attendance->duration_minutes ? round($attendance->duration_minutes / 60, 2) : '--',
                    'status' => 'Present',
                ];
            } else {
                $records[] = [
                    'date' => $date->format('d M Y'),
                    'check_in' => '--',
                    'check_out' => '--',
                    'duration' => '--',
                    'status' => 'Absent',
                ];
            }
        }

        return view('Employees.Attendance.records', compact('records', 'month', 'year'));
    }

    // ✅ Dashboard Summary
    public function dashboard()
    {
        $userId = Auth::id();
        $currentMonth = now()->month;
        $currentYear  = now()->year;
        $monthName    = now()->format('F');

        $attendances = Attendance::where('user_id', $userId)
            ->whereMonth('attendance_date', $currentMonth)
            ->whereYear('attendance_date', $currentYear)
            ->get();

        $presentDays = $attendances->where('status', 'present')->count();
        $absentDays = now()->daysInMonth - $presentDays;
        $totalHoursWorked = round($attendances->sum('duration_minutes') / 60, 2);

        return view('Admin.dashboard', compact(
            'attendances',
            'presentDays',
            'absentDays',
            'totalHoursWorked',
            'monthName',
            'currentYear'
        ));
    }
}
