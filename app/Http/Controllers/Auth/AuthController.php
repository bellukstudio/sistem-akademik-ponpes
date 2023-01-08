<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Mail\Activation;
use App\Models\MasterStudent;
use App\Models\MasterTeacher;
use Illuminate\Support\Facades\Mail;

use function PHPUnit\Framework\isEmpty;

class AuthController extends Controller
{
    public function index()
    {
        // check validasi halaman login
        if (Auth::user() == null) {
            return view('authentication.login');
        } elseif (auth()->check()) {
            return redirect()->route('dashboard');
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
            $request->session()->regenerate();
            return redirect()->route('google.check');
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
