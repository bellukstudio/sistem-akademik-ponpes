<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    public function index()
    {
        // check validasi halaman login
        if (Auth::user() == null) {
            return view('authentication.login');
        } elseif (Auth::user()->roles == 1) {
            return redirect()->route('dashboardAdmin');
        } elseif (Auth::user()->roles == 2) {
            return redirect()->route('dashboardPengajar');
        }
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email:dns'],
            'password' => ['required'],
        ]);
        // check credentials user
        if (Auth::attempt($credentials)) {
            // chceck role user
            if (Auth::user()->roles == 1) {
                $request->session()->regenerate();
                return redirect()->intended('dashboardAdmin');
            } elseif (Auth::user()->roles == 2) {
                $request->session()->regenerate();
                return redirect()->intended('dashboardPengajar');
            }
        }
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
