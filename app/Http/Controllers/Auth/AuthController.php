<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use App\Models\MasterUsers;
use App\Models\SessionUser;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function index()
    {
        if (Auth::user() == null) {
            return view('authentication.login');
        } elseif (auth()->check()) {
            $this->authorize('adminpengajarpengurus');
            return redirect()->route('dashboard');
        }
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email:dns'],
            'password' => ['required'],
        ], [
            'email.required' => 'Email harus di isi',
            'email.email' => 'Email tidak valid',
            'password.required' => 'Password harus di isi'
        ]);

        if (Auth::attempt($credentials)) {
            $user = MasterUsers::where('email', $request->email)->first();

            // Cek apakah sudah ada session untuk user ini
            $existingSession = SessionUser::where('user_id', $user->id)->first();

            if (!$existingSession) {
                // Buat session baru
                SessionUser::create([
                    'user_id' => $user->id,
                    'ip_address' => $request->ip(),
                    'user_agent' => $request->server('HTTP_USER_AGENT'),
                    'last_activity' => strtotime(Carbon::now()),
                    'status' => 'ON'
                ]);
            } else {
                // Update session yang sudah ada dengan cara yang aman
                SessionUser::where('user_id', $user->id)
                    ->update([
                        'ip_address' => $request->ip(),
                        'user_agent' => $request->server('HTTP_USER_AGENT'),
                        'last_activity' => strtotime(Carbon::now()),
                        'status' => 'ON',
                        'updated_at' => now()
                    ]);
            }

            if (Auth::user()->roles_id === 1 || Auth::user()->roles_id === "1") {
                $request->session()->regenerate();
                return redirect()->route('google.check');
            } elseif (Auth::user()->roles_id === 4 || Auth::user()->roles_id === "4") {
                Auth::logout();
                return redirect()->route('login')->with('failed', 'You are not authorized to access the application.');
            } else {
                $request->session()->regenerate();
                return redirect()->intended('dashboard');
            }
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function logout(Request $request)
    {
        $user = MasterUsers::where('email', auth()->user()->email)->first();
        $existingSession = SessionUser::where('user_id', $user->id)->first();

        if (!$existingSession) {
            // Buat record logout baru
            SessionUser::create([
                'user_id' => $user->id,
                'ip_address' => $request->ip(),
                'user_agent' => $request->server('HTTP_USER_AGENT'),
                'last_activity' => strtotime(Carbon::now()),
                'status' => 'OFF'
            ]);
        } else {
            // Update status menjadi OFF
            SessionUser::where('user_id', $user->id)
                ->update([
                    'ip_address' => $request->ip(),
                    'user_agent' => $request->server('HTTP_USER_AGENT'),
                    'last_activity' => strtotime(Carbon::now()),
                    'status' => 'OFF',
                    'updated_at' => now()
                ]);
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
