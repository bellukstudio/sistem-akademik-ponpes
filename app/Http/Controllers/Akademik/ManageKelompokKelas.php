<?php

namespace App\Http\Controllers\Akademik;

use App\Http\Controllers\Controller;
use App\Models\MasterAcademicProgram;
use App\Models\MasterClass;
use App\Models\MasterRoom;
use App\Models\MasterStudent;
use App\Models\TrxClassGroup;
use Illuminate\Http\Request;

class ManageKelompokKelas extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = TrxClassGroup::latest()->get();
        return view('dashboard.akademik.kelompok_kelas.index', [
            'class' => $data
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $program = MasterAcademicProgram::all();
        return view('dashboard.akademik.kelompok_kelas.create', compact('program'));
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
            'student_select' => 'required',
            'program_select' => 'required',
            'class_select' => 'required'
        ]);

        try {
            TrxClassGroup::create([
                'student_id' => $request->student_select,
                'class_id' => $request->class_select
            ]);
            return redirect()->route('kelompokKelas.index')->with('success', 'Data berhasil disimpan');
        } catch (\Exception $e) {
            return back()->withErrors($e);
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
        $program = MasterAcademicProgram::all();
        $data = TrxClassGroup::find($id);
        return view('dashboard.akademik.kelompok_kelas.edit', compact('data', 'program'));
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
            'student_select' => 'required',
            'class_select' => 'required'
        ]);

        try {
            $data = TrxClassGroup::find($id);
            $data->student_id = $request->student_select;
            $data->class_id = $request->class_select;
            $data->update();
            return redirect()->route('kelompokKelas.index')->with('success', 'Data berhasil diubah');
        } catch (\Exception $e) {
            return back()->withErrors($e);
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
            $data = TrxClassGroup::find($id);
            $data->delete();
            return redirect()->route('kelompokKelas.index')->with('success', 'Data berhasil dihapus');
        } catch (\Exception $e) {
            return back()->withErrors($e);
        }
    }
}
