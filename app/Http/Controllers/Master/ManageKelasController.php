<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\MasterAcademicProgram;
use App\Models\MasterClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ManageKelasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = MasterClass::with(['program'])->latest()->get();
        $program = MasterAcademicProgram::all();
        return view('dashboard.master_data.kelola_kelas.index', [
            'kelas' => $data,
            'program' => $program
        ]);
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
                'class_name' => 'required|unique:master_classes,class_name',
                'program' => 'required',
            ],
            [
                'class_name.required' => 'Kolom nama kelas wajib diisi.',
                'class_name.unique' => 'Nama kelas sudah terdaftar.',
                'program.required' => 'Kolom program wajib diisi.',
            ]
        );

        try {
            MasterClass::create([
                'class_name' => $request->class_name,
                'program_id' => $request->program
            ]);

            return redirect()->route('kelolaKelas.index')
                ->with('success', 'Kelas ' . $request->class_name . ' berhasil disimpan');
        } catch (\Exception $e) {
            return back()->with('failed', 'Gagal menyimpan data');
        }
    }
    public function getAllClassByProgram($programId)
    {
        $this->authorize('adminpengajarpengurus');
        $empData['data'] = MasterClass::where('program_id', $programId)->get();

        return response()->json($empData);
    }
    public function getAllClass()
    {
        $this->authorize('adminpengajarpengurus');

        $empData['data'] = MasterClass::all();

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
                'class_name' => 'required|unique:master_classes,class_name,' . $id,
                'program' => 'required',
            ],
            [
                'class_name.required' => 'Kolom nama kelas wajib diisi.',
                'class_name.unique' => 'Nama kelas sudah terdaftar.',
                'program.required' => 'Kolom program wajib diisi.',
            ]
        );

        try {
            $data = MasterClass::findOrFail($id);
            $data->class_name = $request->class_name;
            $data->program_id = $request->program;
            $data->update();
            return redirect()->route('kelolaKelas.index')
                ->with('success', 'Kelas ' . $request->class_name . ' berhasil diupdate');
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
            $data = MasterClass::find($id);
            $data->delete();
            return redirect()->route('kelolaKelas.index')
                ->with('success', 'Kelas ' . $data->class_name . ' berhasil dihapus');
        } catch (\Exception $e) {
            return back()->with('failed', 'Gagal menghapus data');
        }
    }

    //

    public function trash()
    {
       
        $data = MasterClass::onlyTrashed()->get();
        return view('dashboard.master_data.kelola_kelas.trash', [
            'trash' => $data
        ]);
    }

    public function restore($id)
    {
       

        try {
            $data = MasterClass::onlyTrashed()->where('id', $id)->firstOrFail();
            $data->restore();
            return redirect()->route('kelolaKelas.index')
                ->with('success', 'Kelas ' . $data->class_name . ' berhasil dipulihkan ');
        } catch (\Exception $e) {
            return back()->with('failed', 'Gagal memulihkan data');
        }
    }
    public function restoreAll()
    {
       

        try {
            $data = MasterClass::onlyTrashed();
            $data->restore();
            return redirect()->route('kelolaKelas.index')->with('success', 'Data berhasil dipulihkan');
        } catch (\Exception $e) {
            return back()->with('failed', 'Gagal memulihkan data');
        }
    }
    public function deletePermanent($id)
    {
       

        try {
            $data = MasterClass::onlyTrashed()->where('id', $id)->firstOrFail();
            $data->forceDelete();
            return redirect()->route('trashClass')
                ->with('success', 'Kelas ' . $data->class_name . ' berhasil dihapus permanent');
        } catch (\Exception $e) {

            return back()->with('failed', 'Gagal menghapus data');
        }
    }
    public function deletePermanentAll()
    {
       

        try {
            $data = MasterClass::onlyTrashed();
            $data->forceDelete();
            return redirect()->route('trashClass')->with('success', 'Semua data berhasil dihapus permanent');
        } catch (\Exception $e) {

            return back()->with('failed', 'Gagal menghapus data');
        }
    }
}
