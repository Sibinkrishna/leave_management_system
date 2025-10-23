<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Department;

class DepartmentController extends Controller
{
    // List all departments
    public function index()
    {
        $department = Department::orderBy('id', 'desc')->get();
        return view('Admin.Department.index', compact('department'));
    }

    // Show create form
    public function create()
    {
        return view('Admin.Department.create');
    }

    // Store new department
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|string|max:50',
        ]);

        Department::create($request->all());
        return redirect()->route('admin.department.index')->with('success', 'Department created successfully.');
    }

    // Show edit form
    public function edit($id)
    {
        $department = Department::findOrFail($id);
        return view('Admin.Department.edit', compact('department'));
    }
    

    // Update department
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|string|max:50',
        ]);

        $department = Department::findOrFail($id);
        $department->update($request->all());

        return redirect()->route('admin.department.index')->with('success', 'Department updated successfully.');
    }

    // Delete department
    public function destroy($id)
    {
        $department = Department::findOrFail($id);
        $department->delete();

        return redirect()->route('admin.department.index')->with('success', 'Department deleted successfully.');
    }
}
