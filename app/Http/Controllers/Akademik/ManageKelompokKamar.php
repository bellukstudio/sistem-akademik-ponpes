<?php

namespace App\Http\Controllers\Akademik;

use App\Http\Controllers\Controller;
use App\Models\MasterAcademicProgram;
use App\Models\MasterRoom;
use App\Models\MasterStudent;
use App\Models\TrxRoomGroup;
use Illuminate\Http\Request;

class ManageKelompokKamar extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = TrxRoomGroup::latest()->get();
        return view('dashboard.akademik.kelompok_kamar.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $program = MasterAcademicProgram::all();
        $room = MasterRoom::where('type', 'KAMAR')->latest()->get();
        return view('dashboard.akademik.kelompok_kamar.create', compact('room', 'program'));
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
            'room_select' => 'required', 'program_select' => 'required',

        ], [
            'student_select.required' => 'Santri harus diisi',
            'room_select.required' => 'Kamar harus diisi',
            'program_select.required' => 'Program harus diisi',

        ]);


        try {
            TrxRoomGroup::create([
                'student_id' => $request->student_select,
                'room_id' => $request->room_select
            ]);
            return redirect()->route('kelompokKamar.index')->with('success', 'Data berhasil disimpan');
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
        $room = MasterRoom::where('type', 'KAMAR')->latest()->get();
        $data = TrxRoomGroup::find($id);
        return view('dashboard.akademik.kelompok_kamar.edit', compact('program', 'room', 'data'));
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
            'room_select' => 'required', 'program_select' => 'required',

        ], [
            'student_select.required' => 'Santri harus diisi',
            'room_select.required' => 'Kamar harus diisi',
            'program_select.required' => 'Program harus diisi',

        ]);

        try {
            $data = TrxRoomGroup::find($id);
            $data->student_id = $request->student_select;
            $data->room_id = $request->room_select;
            $data->update();

            return redirect()->route('kelompokKamar.index')->with('success', 'Data berhasil diubah');
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
            $data = TrxRoomGroup::find($id);
            $data->delete();
            return redirect()->route('kelompokKamar.index')->with('success', 'Data berhasil dihapus');
        } catch (\Exception $e) {
            return back()->with('failed', 'Gagal menghapus data');
        }
    }
}
