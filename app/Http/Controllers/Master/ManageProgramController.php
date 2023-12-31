<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\MasterAcademicProgram;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ManageProgramController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = MasterAcademicProgram::latest()->get();
        return view(
            'dashboard.master_data.kelola_program.index',
            [
                'program' => $data
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'kode' => 'required|max:50|unique:master_academic_programs,code',
                'nama_program' => 'required|max:100|unique:master_academic_programs,program_name'
            ],
            [
                'kode.required' => 'Kolom Kode Program harus diisi.',
                'kode.max' => 'Kolom Kode Program maksimal terdiri dari 50 karakter.',
                'kode.unique' => 'Kode Program sudah terdaftar dalam database',
                'nama_program.required' => 'Kolom Nama Program harus diisi.',
                'nama_program.max' => 'Kolom Nama Program maksimal terdiri dari 100 karakter.',
                'nama_program.unique' => 'Nama Program sudah terdaftar dalam database',
            ]
        );

        try {
            MasterAcademicProgram::create(
                [
                    'code' => $request->kode,
                    'program_name' => $request->nama_program
                ]
            );
            return redirect()->route('kelolaProgramAkademik.index')
                ->with('success', 'Program ' . $request->nama_program . ' berhasil di tambahkan');
        } catch (\Exception $e) {
            return back()->with('failed', 'Gagal menyimpan data');
        }
    }
    /**
     * get all student with json
     */
    public function getAllProgram()
    {
        $this->authorize('adminpengajarpengurus');

        $empData['data'] = MasterAcademicProgram::all();

        return response()->json($empData);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate(
            [
                'kode' => 'required|max:50|unique:master_academic_programs,code,' . $id,
                'nama_program' => 'required|max:100|unique:master_academic_programs,program_name,' . $id
            ],
            [
                'kode.required' => 'Kolom Kode Program harus diisi.',
                'kode.max' => 'Kolom Kode Program maksimal terdiri dari 50 karakter.',
                'kode.unique' => 'Kode Program sudah terdaftar dalam database',
                'nama_program.required' => 'Kolom Nama Program harus diisi.',
                'nama_program.max' => 'Kolom Nama Program maksimal terdiri dari 100 karakter.',
                'nama_program.unique' => 'Nama Program sudah terdaftar dalam database',
            ]
        );
        try {
            $data = MasterAcademicProgram::findOrfail($id);
            $data->code = $request->kode;
            $data->program_name = $request->nama_program;
            $data->update();
            return redirect()->route('kelolaProgramAkademik.index')
                ->with('success', 'Program ' . $request->nama_program . ' berhasil di update');
        } catch (\Exception $e) {
            return back()->with('failed', 'Gagal mengubah data');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $data = MasterAcademicProgram::find($id);
            $data->delete();
            return redirect()->route('kelolaProgramAkademik.index')
                ->with('success', 'Program ' . $data->program_name . 'berhasil dihapus');
        } catch (\Exception $e) {
            return back()->with('failed', 'Gagal menghapus data');
        }
    }

    public function trash()
    {
       
        $data = MasterAcademicProgram::onlyTrashed()->get();
        return view('dashboard.master_data.kelola_program.trash', [
            'trash' => $data
        ]);
    }

    public function restore($id)
    {
       

        try {
            $data = MasterAcademicProgram::onlyTrashed()->where('id', $id)->firstOrFail();
            $data->restore();
            return redirect()->route('kelolaProgramAkademik.index')
                ->with('success', 'Program ' . $data->program_name . ' berhasil dipulihkan ');
        } catch (\Exception $e) {
            return back()->with('failed', 'Gagal memulihkan data');
        }
    }
    public function restoreAll()
    {
       

        try {
            $data = MasterAcademicProgram::onlyTrashed();
            $data->restore();
            return redirect()->route('kelolaProgramAkademik.index')->with('success', 'Data berhasil dipulihkan');
        } catch (\Exception $e) {
            return back()->with('failed', 'Gagal memulihkan data');
        }
    }

    public function deletePermanent($id)
    {
       

        try {
            $data = MasterAcademicProgram::onlyTrashed()->where('id', $id)->firstOrFail();
            $data->forceDelete();
            return redirect()->route('trashProgram')
                ->with('success', 'Program ' . $data->program_name . ' berhasil dihapus permanent');
        } catch (\Exception $e) {
            return back()->with('failed', 'Gagal menghapus data');
        }
    }
    public function deletePermanentAll()
    {
       

        try {
            $data = MasterAcademicProgram::onlyTrashed();
            $data->forceDelete();
            return redirect()->route('trashProgram')->with('success', 'Semua data berhasil dihapus permanent');
        } catch (\Exception $e) {
            return back()->with('failed', 'Gagal menghapus data');
        }
    }
}
