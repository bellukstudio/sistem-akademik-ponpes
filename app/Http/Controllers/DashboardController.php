<?php

namespace App\Http\Controllers;

use App\Models\MasterNews;
use App\Models\MasterStudent;
use App\Models\MasterTeacher;
use App\Models\MasterUsers;
use App\Models\SessionUser;
use App\Models\TrxCaretakers;
use App\Models\TrxStudentPermits;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{

    public function index()
    {
        // count data
        $dataUser = MasterUsers::whereNotIn('roles_id', [1])->count();
        $dataSantri = MasterStudent::count();
        $dataPengajar = MasterTeacher::count();
        $dataPengurus = TrxCaretakers::count();
        $isAdmin = true;
        // get latest data
        $beritaAcara = MasterNews::latest()->paginate(5);
        $perizinan = TrxStudentPermits::with(['student'])->latest()->paginate(5);
        $user = '';
        if (Auth::user()->roles_id === 2) {
            $isAdmin = false;
            $user = MasterTeacher::where('email', Auth::user()->email)->firstOrFail();
        }
        if (Auth::user()->roles_id === 3) {
            $isAdmin = false;
            $caretakers = TrxCaretakers::where('user_id', Auth::user()->id)->firstOrFail();
            if ($caretakers->categories === 'teachers') {
                $user = MasterTeacher::where('email', $caretakers->email)->firstOrFail();
            } elseif ($caretakers->categories === 'students') {
                $user = MasterStudent::where('email', $caretakers->email)->firstOrFail();
            } else {
                abort(404);
            }
        }

        // session user
        $session = SessionUser::with(['user'])->latest()->paginate(10);
        return view('dashboard.index', compact(
            'dataUser',
            'dataSantri',
            'dataPengajar',
            'beritaAcara',
            'dataPengurus',
            'perizinan',
            'user',
            'isAdmin',
            'session'
        ));
    }
}
