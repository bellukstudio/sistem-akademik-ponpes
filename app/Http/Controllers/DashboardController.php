<?php

namespace App\Http\Controllers;

use App\Models\MasterNews;
use App\Models\MasterStudent;
use App\Models\MasterTeacher;
use App\Models\MasterUsers;
use App\Models\TrxCaretakers;
use App\Models\TrxStudentPermits;

class DashboardController extends Controller
{

    public function index()
    {
        // count data
        $dataUser = MasterUsers::whereNotIn('roles_id', [1])->count();
        $dataSantri = MasterStudent::count();
        $dataPengajar = MasterTeacher::count();
        $dataPengurus = TrxCaretakers::count();

        // get latest data
        $beritaAcara = MasterNews::latest()->paginate(5);
        $perizinan = TrxStudentPermits::with(['user'])->latest()->paginate(5);
        return view('dashboard.index', compact(
            'dataUser',
            'dataSantri',
            'dataPengajar',
            'beritaAcara',
            'dataPengurus',
            'perizinan'
        ));
    }
}
