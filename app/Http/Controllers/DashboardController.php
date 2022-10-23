<?php

namespace App\Http\Controllers;

use App\Models\MasterNews;
use App\Models\MasterStudent;
use App\Models\MasterTeacher;
use App\Models\MasterUsers;

class DashboardController extends Controller
{
    public function index()
    {
        // count data
        $dataUser = MasterUsers::whereNotIn('roles', [1])->count();
        $dataSantri = MasterStudent::count();
        $dataPengajar = MasterTeacher::count();

        // get latest data
        $beritaAcara = MasterNews::latest()->paginate(5);
        return view('dashboard.index', compact('dataUser', 'dataSantri', 'dataPengajar', 'beritaAcara'));
    }
}
