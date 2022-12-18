<?php

namespace App\Http\Controllers\Akademik;

use App\Http\Controllers\Controller;
use App\Models\MasterAcademicProgram;
use App\Models\MasterClass;
use App\Models\MasterCourse;
use App\Models\MasterTeacher;
use App\Models\TrxSchedule;
use Illuminate\Http\Request;

class ManageJadwalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = TrxSchedule::with(['class', 'teacher', 'course'])->latest()->get();
        return view('dashboard.akademik.jadwal.index', [
            'jadwal' => $data
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $teacher = MasterTeacher::all();
        $course = MasterCourse::all();
        $class = MasterClass::all();
        return view('dashboard.akademik.jadwal.create', compact('teacher', 'course', 'class'));
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
            'teacher_select' => 'required',
            'class_select' => 'required',
            'course_select' => 'required',
            'day' => 'required|max:20',
            'time' => 'required|max:20'
        ]);

        try {
            TrxSchedule::create([
                'teacher_id' => $request->teacher_select,
                'class_id' => $request->class_select,
                'course_id' => $request->course_select,
                'day' => $request->day,
                'time' => $request->time
            ]);
            return redirect()->route('jadwalPelajaran.index')->with('success', 'Jadwal pelajaran baru berhasil dibuat');
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
        $teacher = MasterTeacher::all();
        $course = MasterCourse::all();
        $class = MasterClass::all();
        $data = TrxSchedule::find($id);
        return view('dashboard.akademik.jadwal.edit', compact('teacher', 'course', 'class', 'data'));
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
            'teacher_select' => 'required',
            'class_select' => 'required',
            'course_select' => 'required',
            'day' => 'required|max:20',
            'time' => 'required|max:20'
        ]);

        try {
            $data = TrxSchedule::find($id);
            $data->teacher_id = $request->teacher_select;
            $data->class_id = $request->class_select;
            $data->course_id = $request->course_select;
            $data->day = $request->day;
            $data->time = $request->time;
            $data->update();
            return redirect()->route('jadwalPelajaran.index')->with('success', 'Jadwal pelajaran berhasil diubah');
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
            $data = TrxSchedule::find($id);
            $data->delete();
            return redirect()->route('jadwalPelajaran.index')->with('success', 'Jadwal pelajaran berhasil dihapus');
        } catch (\Exception $e) {
            return back()->withErrors($e);
        }
    }
}
