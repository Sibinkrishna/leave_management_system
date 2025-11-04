<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Holiday;

class HolidayController extends Controller
{
    /**
     * Display a listing of the holidays for employees.
     */
    public function index()
    {
        // Fetch all holidays sorted by date (ascending)
        $holidays = Holiday::orderBy('date', 'asc')->get();

        // Return to the employee holiday index view
        return view('Employees.Holiday.index', compact('holidays'));
    }
}
