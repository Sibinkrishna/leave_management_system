<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WorkFromHomeEntry;
use Illuminate\Http\Request;

class WorkFromHomeController extends Controller
{
    // show list of entries with pagination and simple filters (date, user)
public function index(Request $request)
{
    $query = WorkFromHomeEntry::with('user');

    // ✅ If the user selected a specific date
    if ($request->filled('date')) {
        $selectedDate = $request->date;
        $query->whereDate('entry_date', $selectedDate);
    } 
    // ✅ If filtering by day, month, and year separately (fallback)
    elseif ($request->filled('day') || $request->filled('month') || $request->filled('year')) {
        $day = $request->day;
        $month = $request->month ?? now()->month;
        $year = $request->year ?? now()->year;

        if ($day) {
            $query->whereDay('entry_date', $day);
        }
        $query->whereMonth('entry_date', $month)
              ->whereYear('entry_date', $year);
    } 
    // ✅ Default to current month if nothing selected
    else {
        $month = now()->month;
        $year = now()->year;

        $query->whereMonth('entry_date', $month)
              ->whereYear('entry_date', $year);
    }

    $entries = $query->orderBy('entry_date', 'desc')->get();

    return view('Admin.workfromhome.index', compact('entries'));
}




}
