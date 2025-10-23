<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Department;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class EmployeeController extends Controller
{
    // Display all employees
    public function index()
    {
        $employees = User::where('role', 'employee')->get();
        return view('Admin.Employee.index', compact('employees'));
    }

    // Show create form
    public function create()
    {
        $departments = Department::where('status', 'active')->get();
        return view('Admin.Employee.create', compact('departments'));
    }

    // Store new employee
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name'           => 'required|string|max:255',
            'phone'          => 'required|string|max:15',
            'email'          => 'required|string|email|max:255|unique:users,email',
            'password'       => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required|string|min:8',
            'designation'    => 'required|string|max:255',
            'join_date'      => 'required|date',
            'status'         => 'required|string|max:50',
            'avatar'         => 'nullable|image|max:2048|mimes:png,jpg,jpeg,gif',
            'address'        => 'nullable|string|max:500',
            'department_id'  => 'nullable|exists:departments,id',
        ]);

        // Handle avatar upload
        $avatarPath = null;
        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
        }

        // Create employee
        User::create([
            'name'          => $validatedData['name'],
            'phone'         => $validatedData['phone'],
            'email'         => $validatedData['email'],
            'password'      => Hash::make($validatedData['password']),
            'designation'   => $validatedData['designation'],
            'join_date'     => $validatedData['join_date'],
            'status'        => $validatedData['status'],
            'role'          => 'employee',
            'company_id'    => $request->company_id ?? 1,
            'avatar'        => $avatarPath,
            'address'       => $validatedData['address'] ?? null,
            'department_id' => $validatedData['department_id'] ?? null,
        ]);

        return redirect()->route('admin.employee.index')->with('success', 'Employee created successfully!');
    }

    // Show edit form
    public function edit($id)
    {
        $employee = User::findOrFail($id);
        $departments = Department::where('status', 'active')->get();
        return view('Admin.Employee.edit', compact('employee', 'departments'));
    }

    // Update employee
    public function update(Request $request, $id)
    {
        $employee = User::findOrFail($id);

        $validatedData = $request->validate([
            'name'           => 'required|string|max:255',
            'phone'          => 'required|string|max:15',
            'email'          => 'required|string|email|max:255|unique:users,email,' . $employee->id,
            'designation'    => 'required|string|max:255',
            'join_date'      => 'required|date',
            'status'         => 'required|string|max:50',
            'avatar'         => 'nullable|image|max:2048|mimes:png,jpg,jpeg,gif',
            'address'        => 'nullable|string|max:500',
            'department_id'  => 'nullable|exists:departments,id',
        ]);

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            if ($employee->avatar) {
                Storage::disk('public')->delete($employee->avatar);
            }
            $employee->avatar = $request->file('avatar')->store('avatars', 'public');
        }

        // Update employee details
        $employee->name          = $validatedData['name'];
        $employee->phone         = $validatedData['phone'];
        $employee->email         = $validatedData['email'];
        $employee->designation   = $validatedData['designation'];
        $employee->join_date     = $validatedData['join_date'];
        $employee->status        = $validatedData['status'];
        $employee->address       = $validatedData['address'] ?? null;
        $employee->department_id = $validatedData['department_id'] ?? null; // ✅ Save department_id

        $employee->save();

        return redirect()->route('admin.employee.index')->with('success', 'Employee updated successfully.');
    }

    // Show employee profile
    public function show($id)
    {
        $employee = User::findOrFail($id);
        return view('Admin.Employee.profile', compact('employee'));
    }

    // Delete employee
    public function destroy($id)
    {
        $employee = User::findOrFail($id);

        if ($employee->avatar) {
            Storage::disk('public')->delete($employee->avatar);
        }

        $employee->delete();

        return redirect()->route('admin.employee.index')->with('success', 'Employee deleted successfully.');
    }
}
