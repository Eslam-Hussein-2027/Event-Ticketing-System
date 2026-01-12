<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    public function showLogin()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => ['required','email'],
            'password' => ['required','string'],
        ]);

        if (!Auth::attempt($data)) {
            return back()->withErrors(['email' => 'Wrong email or password'])->onlyInput('email');
        }

        if (!Auth::user()->is_admin) {
            Auth::logout();
            return back()->withErrors(['email' => 'You are not admin']);
        }

        $request->session()->regenerate();
        return redirect()->route('admin.trips.create');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login.form');
    }
}
