<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('Admin.Auth.login');
    }

   public function login(Request $request)
{
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ],[
        'email.required' => 'Please enter email',
        'password.required'=>'Please enter password'
    ]);
    $user =User::where('email', $request->email)->first();
    if(!$user){
        return response()->json([
            'success' => false,
            'errors' => ['email' => ['Email not found.']],
        ], 422);
    }
    if(!Hash::check($request->password, $user->password)){
        return response()->json([
            'success' => false,
            'errors' => ['password' => ['Incorrect password.']],
        ], 422);
    }
    if (Auth::attempt($credentials, $request->boolean('remember'))) {
        $request->session()->regenerate();

        // ✅ If AJAX, return JSON (your JS expects this!)
        if ($request->ajax()) {
            return response()->json([
                'redirect' => route('dashboard')
            ]);
        }

        // ✅ Normal login (non-AJAX form)
        return redirect()->intended(route('dashboard'));
    }

    // ✅ Validation failed or credentials invalid
    if ($request->ajax()) {
        return response()->json([
            'errors' => [
                'email' => ['Invalid credentials'],
            ]
        ], 422);
    }

    // ✅ Normal form fallback
    return back()
        ->withErrors(['email' => 'Invalid credentials'])
        ->onlyInput('email');
}


    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }

    public function showChangePassword()
    {
        return view('auth.change-password');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required'],
            'password' => ['required','confirmed','min:8'],
        ]);

        $user = $request->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect']);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return back()->with('success','Password updated.');
    }
    public function showRegister()
    {
        return view('Admin.Auth.register');
    } 
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'employee', // Default role
        ]);

        Auth::login($user);

        return redirect()->route('dashboard');
    }
}
