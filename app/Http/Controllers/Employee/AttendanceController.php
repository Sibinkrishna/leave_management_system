<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Holiday;
use App\Models\LeaveApplication; 
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    // ✅ Check-In Logic
    public function checkIn()
    {
        $userId = Auth::id();
        $today = Carbon::today();

         // ⛔ BLOCK CHECK-IN IF EMPLOYEE IS ON LEAVE
       $isOnLeaveToday = LeaveApplication::where('user_id', $userId)
    ->whereRaw('LOWER(status) = ?', ['approved'])
    ->whereDate('start_date', '<=', $today)
    ->whereDate('end_date', '>=', $today)
    ->exists();

        if ($isOnLeaveToday) {
            return back()->with('error', 'You are on leave today. You cannot check in.');
        }

        

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

            // ⛔ BLOCK CHECK-OUT IF EMPLOYEE IS ON LEAVE
     $isOnLeaveToday = LeaveApplication::where('user_id', $userId)
    ->whereRaw('LOWER(status) = ?', ['approved'])
    ->whereDate('start_date', '<=', $today)
    ->whereDate('end_date', '>=', $today)
    ->exists();


        if ($isOnLeaveToday) {
            return back()->with('error', 'You are on leave today. You cannot check out.');
        }


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

    public function records(Request $request)
{
    $userId = Auth::id();

    // If a specific date is selected → filter only that date
    if ($request->filled('date')) {
        $date = Carbon::parse($request->date)->toDateString();

        $attendance = Attendance::where('user_id', $userId)
            ->whereDate('attendance_date', $date)
            ->first();

        $holiday = Holiday::whereDate('date', $date)->first();
        $recordDate = Carbon::parse($date);

        // Weekend
        if ($recordDate->isSaturday() || $recordDate->isSunday()) {
            $records[] = [
                'date' => $recordDate->format('d M Y'),
                'check_in' => '--',
                'check_out' => '--',
                'duration' => '--',
                'status' => 'Weekend',
            ];
        }
        // Holiday
        elseif ($holiday) {
            $records[] = [
                'date' => $recordDate->format('d M Y'),
                'check_in' => '--',
                'check_out' => '--',
                'duration' => '--',
                'status' => 'Holiday',
            ];
        }
        // Attendance
        elseif ($attendance) {
            $records[] = [
                'date' => $recordDate->format('d M Y'),
                'check_in' => $attendance->check_in ? Carbon::parse($attendance->check_in)->format('h:i A') : '--',
                'check_out' => $attendance->check_out ? Carbon::parse($attendance->check_out)->format('h:i A') : '--',
                'duration' => $attendance->duration_minutes? abs(round($attendance->duration_minutes / 60, 2)) : '--',

                'status' => 'Present',
            ];
        } else {
            $records[] = [
                'date' => $recordDate->format('d M Y'),
                'check_in' => '--',
                'check_out' => '--',
                'duration' => '--',
                'status' => 'Absent',
            ];
        }

        return view('Employees.Attendance.records', compact('records'));
    }

    // ✅ Default view: full month if no specific date selected
    $month = $request->get('month', date('m'));
    $year = $request->get('year', date('Y'));

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

        if (isset($attendances[$date->toDateString()])) {
            $attendance = $attendances[$date->toDateString()];
            $records[] = [
                'date' => $date->format('d M Y'),
                'check_in' => $attendance->check_in ? Carbon::parse($attendance->check_in)->format('h:i A') : '--',
                'check_out' => $attendance->check_out ? Carbon::parse($attendance->check_out)->format('h:i A') : '--',
               'duration' => $attendance->duration_minutes? abs(round($attendance->duration_minutes / 60, 2)): '--',

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
