<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use App\Models\MasterUsers;
use App\Models\SessionUser;
use Carbon\Carbon;

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
            $user = MasterUsers::where('email', $request->email)->first();
            $checkSession = SessionUser::where('user_id', $user->id)->doesntExist();
            if ($checkSession) {
                //Save users session
                $session = [
                    'user_id' => $user->id,
                    'ip_address' => $request->ip(),
                    'user_agent' => $request->server('HTTP_USER_AGENT'),
                    'last_activity' => strtotime(Carbon::now()),
                    'status' => 'ON'
                ];
                SessionUser::create($session);
            } else {
                SessionUser::where('user_id', $user->id)
                    ->update([
                        'ip_address' => $request->ip(),
                        'user_agent' => $request->server('HTTP_USER_AGENT'),
                        'last_activity' => strtotime(Carbon::now()),
                        'status' => 'ON'
                    ]);
            }
            if (Auth::user()->roles_id === 1) {
                return redirect()->route('google.check');
            } else {
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
        $checkSession = SessionUser::where('user_id', $user->id)->doesntExist();
        if ($checkSession) {
            //Save users session
            $session = [
                'user_id' => $user->id,
                'ip_address' => $request->ip(),
                'user_agent' => $request->server('HTTP_USER_AGENT'),
                'last_activity' => strtotime(Carbon::now()),
                'status' => 'OFF'
            ];
            SessionUser::create($session);
        } else {
            SessionUser::where('user_id', $user->id)
                ->update([
                    'ip_address' => $request->ip(),
                    'user_agent' => $request->server('HTTP_USER_AGENT'),
                    'last_activity' => strtotime(Carbon::now()),
                    'status' => 'OFF'
                ]);
        }
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
