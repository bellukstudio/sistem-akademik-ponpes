<?php

namespace App\Http\Controllers\Akademik;

use App\Http\Controllers\Controller;
use App\Models\MasterRoom;
use App\Models\MasterStudent;
use App\Models\TrxPicketSchedule;
use Illuminate\Http\Request;

class ManageJadwalPiketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = TrxPicketSchedule::with(['room', 'student'])->latest()->get();
        return view(
            'dashboard.akademik.jadwal_piket.index',
            [
                'piket' => $data
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
        $student = MasterStudent::all();
        $room = MasterRoom::all();
        return view('dashboard.akademik.jadwal_piket.create', compact('student', 'room'));
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
            'room_select' => 'required',
            'time' => 'required'
        ]);

        try {
            TrxPicketSchedule::create([
                'student_id' => $request->student_select,
                'room_id' => $request->room_select,
                'time' => $request->time
            ]);
            return redirect()->route('jadwalPiket.index')->with('success', 'Jadwal Piket berhasil dibuat');
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
        $student = MasterStudent::all();
        $room = MasterRoom::all();
        $picket = TrxPicketSchedule::find($id);
        return view('dashboard.akademik.jadwal_piket.edit', compact('student', 'room', 'picket'));
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
            'room_select' => 'required',
            'time' => 'required'
        ]);

        try {
            $data = TrxPicketSchedule::find($id);
            $data->student_id = $request->student_select;
            $data->room_id = $request->room_select;
            $data->time = $request->time;
            $data->update();
            return redirect()->route('jadwalPiket.index')->with('success', 'Jadwal Piket berhasil diubah');
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
            $data = TrxPicketSchedule::find($id);
            $data->delete();
            return redirect()->route('jadwalPiket.index')->with('success', 'Jadwal Piket berhasil dihapus');
        } catch (\Exception $e) {
            return back()->withErrors($e);
        }
    }
}
