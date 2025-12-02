<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\LeaveType;
use App\Models\Department;
use App\Models\PendingLeave;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
                 'password'       => [
            'required',
            'string',
            'min:8',
            'regex:/[a-z]/',      // at least one lowercase
            'regex:/[A-Z]/',      // at least one uppercase
            'regex:/[0-9]/',      // at least one number
            'confirmed'
        ],

        'password_confirmation' => 'required|string|min:8',
        'designation'    => 'required|string|max:255',
        'join_date'      => 'required|date',
        'status'         => 'required|string|max:50',
        'avatar'         => 'nullable|image|max:2048|mimes:png,jpg,jpeg,gif',
        'address'        => 'nullable|string|max:500',
        'department_id'  => 'nullable|exists:departments,id',
    ], [
        'phone.digits' => 'Phone number must be exactly 10 digits.',
        'password.regex' => 'Password must include at least one uppercase letter, one lowercase letter, one number, and be at least 8 characters.',
    ]);
        // Handle avatar upload
        $avatarPath = null;
        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
        }

        // Create the user
        $user = User::create([
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

        // Assign all leave types automatically
        $leaveTypes = LeaveType::all();
        foreach ($leaveTypes as $type) {
            PendingLeave::create([
                'user_id' => $user->id,
                'leave_type_id' => $type->id,
                'year' => now()->year,
                'total' => $type->total_days_per_year,
                'used' => 0,
                'remaining' => $type->total_days_per_year,
            ]);
        }

        // Redirect to documentation page after creation
        return redirect()
            ->route('admin.employee.documentation', $user->id)
            ->with('success', 'Employee created successfully! Upload documents now.');
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
        $employee->department_id = $validatedData['department_id'] ?? null;

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

    // Show Documentation Page
public function documentation($id)
{
    $employee = User::findOrFail($id);
    return view('Admin.Employee.documentation', compact('employee'));
}

// Upload Documents
public function uploadDocuments(Request $request, $id)
{
    $request->validate([
        'bank_name' => 'required|string|max:255',
        'account_number' => 'required|string|max:50',
        'ifsc_code' => 'required|string|max:20',
        'branch_name' => 'required|string|max:100',
        'adhar_no' => 'required|digits:12',
        'pan_no' => 'required|string|max:10',
        'adhar_card' => 'nullable|mimes:jpg,jpeg,png,pdf|max:2048',
        'pan_card' => 'nullable|mimes:jpg,jpeg,png,pdf|max:2048',
        'passport_photo' => 'nullable|mimes:jpg,jpeg,png|max:2048',
        'bank_doc' => 'nullable|mimes:jpg,jpeg,png,pdf|max:2048',
    ]);

    $employee = User::findOrFail($id);

     if($request->hasFile('adhar_card')) {
        $employee->adhar_card = $request->file('adhar_card')->store('employees/documents', 'public');
    }
    if($request->hasFile('pan_card')) {
        $employee->pan_card = $request->file('pan_card')->store('employees/documents', 'public');
    }
    if($request->hasFile('passport_photo')) {
        $employee->passport_photo = $request->file('passport_photo')->store('employees/photos', 'public');
    }
    if($request->hasFile('bank_doc')) {
        $employee->bank_doc = $request->file('bank_doc')->store('employees/documents', 'public');
    }

    $employee->bank_name = $request->bank_name;
    $employee->account_number = $request->account_number;
    $employee->ifsc_code = $request->ifsc_code;
    $employee->branch_name = $request->branch_name;
    $employee->adhar_no = $request->adhar_no;
    $employee->pan_no = $request->pan_no;

    $employee->save();

    // Redirect to index page
    return redirect()->route('admin.employee.index')
                     ->with('success', 'Employee and documents submitted successfully!');
}

// ✅ Documentation Details Page (must be outside of uploadDocuments)
public function documentationDetails($id)
{
    $employee = User::findOrFail($id);
    return view('Admin.Employee.documentation_details', compact('employee'));
}
 }