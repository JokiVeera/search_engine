<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Http\Requests\StoreAdminRequest;
use App\Http\Requests\UpdateAdminRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        // Validate the incoming request data
        // $request->validate([
        //     'email' => 'required|email',
        //     'password' => 'required|string|min:6',
        // ]);

        // Extract the email and password from the request
        $credentials = $request->only('email', 'password');

        // Attempt to authenticate using the 'admin' guard
        if (Auth::guard('admin')->attempt($credentials)) {
            // Authentication successful, redirect to the intended page or admin dashboard
            return redirect()->intended('/');
        }

        // Authentication failed, return with an error message
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->withInput();
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect('/');
    }

}
