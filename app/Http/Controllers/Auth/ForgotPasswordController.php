<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Mail;
use App\Mail\ForgotPasswordMail;
use App\Models\User;

class ForgotPasswordController extends Controller
{
    public function showForgotPassword()
    {
        return view('Admin.Auth.forgot-password');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->with('error', 'Email address not found.');
        }

        // Generate token
        $token = Password::broker()->createToken($user);

        // Generate reset URL
        $resetUrl = url('/reset-password?token=' . $token . '&email=' . urlencode($user->email));

        // Send email
        Mail::to($user->email)->send(new ForgotPasswordMail($resetUrl));

        return back()->with('success', 'Password reset link sent to your email.');
    }
}
