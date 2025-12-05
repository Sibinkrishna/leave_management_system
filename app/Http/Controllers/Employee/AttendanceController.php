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
    $user = Auth::user();
    $userId = $user->id;
    $joinDate = Carbon::parse($user->join_date)->startOfDay(); // User's join date

    $records = [];
    $today = now()->startOfDay();

    // ✅ If user selects a specific date
    if ($request->filled('date')) {
        $date = Carbon::parse($request->date)->startOfDay();

        // Skip if date is before joining
        if ($date->lessThan($joinDate)) {
            return view('Employees.Attendance.records', ['records' => []]);
        }

        $attendance = Attendance::where('user_id', $userId)
            ->whereDate('attendance_date', $date)
            ->first();

        $holiday = Holiday::whereDate('date', $date)->first();

        // Weekend
        if ($date->isSaturday() || $date->isSunday()) {
            $records[] = [
                'date' => $date->format('d M Y'),
                'check_in' => '--',
                'check_out' => '--',
                'duration' => '--',
                'status' => 'Weekend',
            ];
        }
        // Holiday
        elseif ($holiday) {
            $records[] = [
                'date' => $date->format('d M Y'),
                'check_in' => '--',
                'check_out' => '--',
                'duration' => '--',
                'status' => 'Holiday',
            ];
        }
        // Present
        elseif ($attendance) {
            $records[] = [
                'date' => $date->format('d M Y'),
                'check_in' => $attendance->check_in
                    ? Carbon::parse($attendance->check_in)->format('h:i A') : '--',
                'check_out' => $attendance->check_out
                    ? Carbon::parse($attendance->check_out)->format('h:i A') : '--',
                'duration' => $attendance->duration_minutes
                    ? abs(round($attendance->duration_minutes / 60, 2)) : '--',
                'status' => 'Present',
            ];
        }
        // Absent
        else {
            $records[] = [
                'date' => $date->format('d M Y'),
                'check_in' => '--',
                'check_out' => '--',
                'duration' => '--',
                'status' => 'Absent',
            ];
        }

        return view('Employees.Attendance.records', compact('records'));
    }

    // ✅ Month-Year Filter (type="month")
    $monthInput = $request->month; // format: YYYY-MM
    if ($monthInput) {
        $year = substr($monthInput, 0, 4);
        $month = substr($monthInput, 5, 2);
    } else {
        $year = date('Y');
        $month = date('m');
    }

    // Fetch Attendance for that month (after join date)
    $attendances = Attendance::whereYear('attendance_date', $year)
        ->whereMonth('attendance_date', $month)
        ->where('user_id', $userId)
        ->where('attendance_date', '>=', $joinDate)
        ->get()
        ->keyBy(function ($item) {
            return Carbon::parse($item->attendance_date)->toDateString();
        });

    // Fetch Holidays for that month
    $holidays = Holiday::whereYear('date', $year)
        ->whereMonth('date', $month)
        ->pluck('date')
        ->map(fn($d) => Carbon::parse($d)->toDateString())
        ->toArray();

    $daysInMonth = Carbon::create($year, $month)->daysInMonth;

    for ($day = 1; $day <= $daysInMonth; $day++) {
        $date = Carbon::create($year, $month, $day)->startOfDay();

        // Skip future dates
        if ($date->greaterThan($today)) continue;

        // Skip dates before joining
        if ($date->lessThan($joinDate)) continue;

        // Weekend
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

        // Holiday
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

        // Present
        if (isset($attendances[$date->toDateString()])) {
            $attendance = $attendances[$date->toDateString()];
            $records[] = [
                'date' => $date->format('d M Y'),
                'check_in' => $attendance->check_in
                    ? Carbon::parse($attendance->check_in)->format('h:i A') : '--',
                'check_out' => $attendance->check_out
                    ? Carbon::parse($attendance->check_out)->format('h:i A') : '--',
                'duration' => $attendance->duration_minutes
                    ? abs(round($attendance->duration_minutes / 60, 2)) : '--',
                'status' => 'Present',
            ];
        } else {
            // Absent
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
