<?php

namespace App\Http\Controllers;

use App\Models\MasterBerita;
use App\Models\MasterPengajar;
use App\Models\MasterSantri;
use App\Models\MasterUsers;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // count data
        $dataUser = MasterUsers::whereNotIn('roles', [1])->count();
        $dataSantri = MasterSantri::count();
        $dataPengajar = MasterPengajar::count();

        // get latest data
        $beritaAcara = MasterBerita::latest()->paginate(5);
        return view('dashboard.index', compact('dataUser', 'dataSantri', 'dataPengajar', 'beritaAcara'));
    }
}
