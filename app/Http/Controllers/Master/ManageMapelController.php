<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\MasterAcademicProgram;
use App\Models\MasterCategorieSchedule;
use App\Models\MasterCourse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ManageMapelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $data = MasterCourse::with(['program'])->latest()->get();
            $program = MasterAcademicProgram::all();
            $categoriSchedule = MasterCategorieSchedule::latest()->get();
            return view('dashboard.master_data.kelola_mapel.index', [
                'mapel' => $data,
                'program' => $program,
                'kategori' => $categoriSchedule
            ]);
        } catch (\Throwable $e) {
            abort(500);
        }
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
                'course_name' => 'required|max:100',
                'program' => 'required', 'category' => 'required'
            ],
            [
                'course_name.required' => 'Kolom Nama Mapel harus diisi.',
                'course_name.max' => 'Kolom Nama Mapel maksimal terdiri dari 100 karakter.',
                'program.required' => 'Kolom Program harus diisi.',
                'category.required' => 'Kolom Kategori harus diisi.'
            ]
        );


        try {
            MasterCourse::create([
                'course_name' => $request->course_name,
                'program_id' => $request->program,
                'category_id' => $request->category
            ]);
            return back()->with('success', 'Mata Pelajaran ' . $request->course_name . ' berhasil disimpan');
        } catch (\Exception $e) {

            return back()->with('failed', 'Gagal menyimpan data');
        }
    }
    /**
     * get all student with json
     */
    public function getAllCourse()
    {
        $empData['data'] = MasterCourse::all();

        return response()->json($empData);
    }
    public function getAllCourseByProgram(Request $request)
    {
        $this->authorize('adminpengajarpengurus');
        $empData['data'] = MasterCourse::with(['category'])->where('program_id', $request->program)->get();
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
                'course_name' => 'required|max:100',
                'program' => 'required', 'category' => 'required'
            ],
            [
                'course_name.required' => 'Kolom Nama Mapel harus diisi.',
                'course_name.max' => 'Kolom Nama Mapel maksimal terdiri dari 100 karakter.',
                'program.required' => 'Kolom Program harus diisi.',
                'category.required' => 'Kolom Kategori harus diisi.'
            ]
        );
        try {
            $data = MasterCourse::find($id);
            $data->course_name = $request->course_name;
            $data->program_id = $request->program;
            $data->category_id = $request->category;
            $data->update();
            return back()->with('success', 'Mata Pelajaran ' . $request->course_name . ' berhasil diubah');
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
            $data = MasterCourse::find($id);
            $data->delete();
            return back()->with('success', 'Mata Pelajaran ' . $data->course_name . ' berhasil dihapus');
        } catch (\Exception $e) {
            return back()->with('failed', 'Gagal menghapus data');
        }
    }

    public function trash()
    {
       

        $data = MasterCourse::with(['program'])->onlyTrashed()->get();
        return view('dashboard.master_data.kelola_mapel.trash', [
            'trash' => $data
        ]);
    }

    public function restore($id)
    {
       

        try {
            $data = MasterCourse::onlyTrashed()->where('id', $id)->firstOrFail();
            $data->restore();
            return redirect()->route('kelolaMapel.index')
                ->with('success', 'Mata Pelajaran ' . $data->course_name . ' berhasil dipulihkan ');
        } catch (\Exception $e) {
            return back()->with('failed', 'Gagal memulihkan data');
        }
    }
    public function restoreAll()
    {
       

        try {
            $data = MasterCourse::onlyTrashed();
            $data->restore();
            return redirect()->route('kelolaMapel.index')->with('success', 'Data berhasil dipulihkan');
        } catch (\Exception $e) {
            return back()->with('failed', 'Gagal memulihkan data');
        }
    }

    public function deletePermanent($id)
    {
       

        try {
            $data = MasterCourse::onlyTrashed()->where('id', $id)->firstOrFail();
            $data->forceDelete();
            return redirect()->route('trashCourse')
                ->with('success', 'Mata Pelajaran ' . $data->course_name . ' berhasil dihapus permanent');
        } catch (\Exception $e) {
            return back()->with('failed', 'Gagal menghapus data');
        }
    }
    public function deletePermanentAll()
    {
       

        try {
            $data = MasterCourse::onlyTrashed();
            $data->forceDelete();
            return redirect()->route('trashCourse')->with('success', 'Semua data berhasil dihapus permanent');
        } catch (\Exception $e) {
            return back()->with('failed', 'Gagal menghapus data');
        }
    }
}
