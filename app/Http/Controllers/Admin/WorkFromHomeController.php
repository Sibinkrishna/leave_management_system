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

    // Filter by day, month, and year
    if ($request->day) {
        $day = $request->day;
        $month = $request->month ?? now()->month;
        $year = $request->year ?? now()->year;

        $query->whereDay('entry_date', $day)
              ->whereMonth('entry_date', $month)
              ->whereYear('entry_date', $year);
    } else {
        // Only month/year filter if day not selected
        $month = $request->month ?? now()->month;
        $year = $request->year ?? now()->year;

        $query->whereMonth('entry_date', $month)
              ->whereYear('entry_date', $year);
    }

    $entries = $query->orderBy('entry_date', 'desc')->get();

    return view('Admin.workfromhome.index', compact('entries'));
}




}
