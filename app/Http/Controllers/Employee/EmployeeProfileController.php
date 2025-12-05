<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class EmployeeProfileController extends Controller
{
    /**
     * Show the profile edit form
     */
    public function edit()
    {
        $user = Auth::user();
        return view('Employees.Profile.edit', compact('user'));
    }

    /**
     * Update the profile
     */
    public function update(Request $request)
{
    $user = Auth::user();

    // Validate input
    $request->validate([
        'name'  => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'phone' => 'nullable|string|max:20',
        'designation' => 'nullable|string|max:255',
        'avatar'=> 'nullable|image|max:2048|mimes:png,jpg,jpeg,gif',
    ]);

    // Update user info
    $user->name  = $request->name;
    $user->email = $request->email;
    $user->phone = $request->phone;
     $user->designation = $request->designation;

    // Handle avatar upload
    if ($request->hasFile('avatar')) {
        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
        }
        $user->avatar = $request->file('avatar')->store('avatars', 'public');
    }
    $user->save();
    return redirect()->back()->with('success', 'Profile updated successfully');
}

}
