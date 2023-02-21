<?php

namespace App\Http\Controllers;

use App\Imports\ClassesImport;
use App\Imports\CourseImport;
use App\Imports\RoomImport;
use App\Imports\StudentsImport;
use App\Imports\TeachersImport;
use App\Models\MasterNews;
use App\Models\MasterStudent;
use App\Models\MasterTeacher;
use App\Models\MasterUsers;
use App\Models\SessionUser;
use App\Models\TrxCaretakers;
use App\Models\TrxStudentPermits;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;

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

    public function importFile(Request $request)
    {

        $validator =  Validator::make(
            $request->all(),
            [
                'tabel' => 'required',
                'excel_file' => 'required|mimes:xls,xlsx|max:2048'
            ],
            [
                'tabel.required' => 'Pilih tabel yang ingin di import',
                'excel_file.required' => 'Pilih file yang ingin di import'
            ]
        );
        try {
            if ($validator->fails()) {
                return back()->withErrors($validator);
            }

            $file = $request->file('excel_file');

            try {
                if ($request->tabel === 'santri') {
                    Excel::import(new StudentsImport, $file);
                } elseif ($request->tabel === 'pengajar') {
                    Excel::import(new TeachersImport, $file);
                } elseif ($request->tabel === 'kelas') {
                    Excel::import(new ClassesImport, $file);
                } elseif ($request->tabel === 'ruangan') {
                    Excel::import(new RoomImport, $file);
                } elseif ($request->tabel === 'mapel') {
                    Excel::import(new CourseImport, $file);
                }
                return redirect()->route('dashboard')->with('success', 'Berhasil import data ' . $request->tabel);
            } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
                $failures = $e->failures();

                foreach ($failures as $failure) {
                    $failure->row(); // row that went wrong
                    $failure->attribute(); // either heading key (if using heading row concern) or column index
                    $failure->errors(); // Actual error messages from Laravel validator
                    $failure->values(); // The values of the row that has failed.
                }
                return back()->withErrors($failures);
            }
        } catch (\Exception $e) {
            return back()->with('failed', 'Gagal import file');
        }
    }

    public function importRedirect()
    {
        return redirect()->route('dashboard');
    }
}
