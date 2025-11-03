<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Holiday;

class HolidayController extends Controller
{
    public function index()
    {
        // Get all holidays created by admin
        $holidays = Holiday::orderBy('date', 'asc')->get();

        return view('Employees.Holiday.index', compact('holidays'));
    }
}
