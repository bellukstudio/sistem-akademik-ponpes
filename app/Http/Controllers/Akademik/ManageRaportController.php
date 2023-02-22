<?php

namespace App\Http\Controllers\Akademik;

use App\Http\Controllers\Controller;
use App\Models\MasterAcademicProgram;
use Illuminate\Http\Request;

class ManageRaportController extends Controller
{
    public function index()
    {
        $program = MasterAcademicProgram::all();

        return view('dashboard.akademik.raport.index', compact('program'));
    }
}
