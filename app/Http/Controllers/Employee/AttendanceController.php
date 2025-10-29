<?php


namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;        
use App\Models\Attendance;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        $attendances = Attendance::where('user_id', $userId)->orderBy('attendance_date', 'desc')->get();
        return view('Employees.Attendance.index', compact('attendances'));
    }
    public function records()
{
    $userId = Auth::id();
    $attendances = Attendance::where('user_id', $userId)
        ->orderBy('attendance_date', 'desc')
        ->get();

    return view('Employees.Attendance.records', compact('attendances'));
}


    public function checkIn()
    {
        $userId = Auth::id();
        $today = Carbon::today();

        $attendance = Attendance::firstOrCreate(
            ['user_id' => $userId, 'attendance_date' => $today],
            ['check_in' => Carbon::now(), 'status' => 'present']
        );

        return back()->with('success', 'Check-in recorded successfully!');
    }

   public function checkOut()
    {
        $userId = Auth::id();
        $today = Carbon::today();

        $attendance = Attendance::where('user_id', $userId)
            ->where('attendance_date', $today)
            ->first();

        if ($attendance && !$attendance->check_out) {
            $attendance->check_out = now();

            // ✅ Convert both times to Carbon instances before diffInMinutes
            $checkIn = Carbon::parse($attendance->check_in);
            $checkOut = Carbon::parse($attendance->check_out);

            $attendance->duration_minutes = $checkOut->diffInMinutes($checkIn);
            $attendance->save();
        }

        return back()->with('success', 'Check-out recorded successfully!');
    }
}
