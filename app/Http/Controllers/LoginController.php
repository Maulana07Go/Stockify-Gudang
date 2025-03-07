<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Redirect berdasarkan role user
            $user = Auth::user();
            switch ($user->role) {
                case 'Admin':
                    return redirect()->intended('/admin/dashboard');
                case 'Staff Gudang':
                    return redirect()->intended('/staff/dashboard');
                case 'Manajer Gudang':
                    return redirect()->intended('/manager/dashboard');
                default:
                    return redirect()->intended('/home');
            }
        };

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }
}
