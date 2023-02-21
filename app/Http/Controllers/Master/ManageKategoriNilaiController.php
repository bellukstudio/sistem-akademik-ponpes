<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\MasterAcademicProgram;
use App\Models\MasterAssessment;
use Illuminate\Http\Request;

class ManageKategoriNilaiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = MasterAssessment::latest()->get();
        $program = MasterAcademicProgram::all();
        return view('dashboard.master_data.kategori_nilai.index', compact('data', 'program'));
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
        $request->validate([
            'category' => 'required|max:100|unique:master_assessments,name',
            'program' => 'required'
        ], [
            'category.required' => 'Kolom kategori harus diisi',
            'category.unique' => 'Kategori sudah pernah tersimpan di database',
            'category.max' => 'Kolom kategori maksimal 100 karakter',
            'program.required' => 'Kolom program harus diisi'
        ]);

        try {
            MasterAssessment::create(
                [
                    'name' => $request->category,
                    'program_id' => $request->program
                ]
            );

            return back()->with('success', 'Data ' . $request->category . ' berhasil disimpan');
        } catch (\Exception $e) {
            return back()->with('failed', 'Gagal menyimpan data');
        }
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
        $request->validate([
            'category' => 'required|max:100|unique:master_assessments,name,' . $id,
            'program' => 'required'
        ], [
            'category.required' => 'Kolom kategori harus diisi',
            'category.unique' => 'Kategori sudah pernah tersimpan di database',
            'category.max' => 'Kolom kategori maksimal 100 karakter',
            'program.required' => 'Kolom program harus diisi'
        ]);

        try {
            $data = MasterAssessment::find($id);
            $data->name = $request->category;
            $data->program_id = $request->program;
            $data->update();

            return back()->with('success', 'Data ' . $request->category . ' berhasil diubah');
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
            $data = MasterAssessment::find($id);
            $data->delete();
            return back()->with('success', 'Data ' . $data->name . ' berhasil dihapus');
        } catch (\Exception $e) {
            return back()->with('failed', 'Gagal menghapus data');
        }
    }

    /**
     * json response get category by program id
     */
    public function getCategoryAssessmentByProgramId(Request $request)
    {
        $empData['data'] = MasterAcademicProgram::where('id', $request->program)->get();

        return response()->json($empData);
    }
}
