<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\WorkFromHomeEntry;

class WorkFromHomeController extends Controller
{
    public function create()
    {
        return view('Employees.workfromhome.create');
    }

 public function store(Request $request)
{
    $data = $request->validate([
        'entry_date' => 'required|date',
        'work_time' => 'required|string',
        'task_summary' => 'required|string|max:1000',
        'notes' => 'required|string|max:255',
    ]);

    $data['user_id'] = Auth::id(); // or Auth::guard('employee')->id();

    WorkFromHomeEntry::create($data);

    return redirect()->route('employee.wfh.create')
                     ->with('success', 'Work entry submitted successfully!');
}
}
