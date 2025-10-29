<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        $attendances = Attendance::where('user_id', $userId)->orderBy('attendance_date', 'desc')->get();
        return view('Admin.dashboard',compact('attendances'));
    }
}
