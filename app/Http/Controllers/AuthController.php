<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function index ()
    {
        if (Auth::check()) {
            return redirect(route('dashboard'));
        } else {
            return view('Auth.Login');
        }
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->validate([
            'username' => ['required', 'min:4'],
            'password' => ['required', 'min:5'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect(route('dashboard'));
        }
        return back()->with('statusErr', 'Username atau password salah');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect(route('login'))->with('status', 'Berhasil Logout');
    }
}
