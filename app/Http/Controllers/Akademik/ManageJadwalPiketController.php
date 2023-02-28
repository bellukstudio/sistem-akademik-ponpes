<?php

namespace App\Http\Controllers\Akademik;

use App\Http\Controllers\Controller;
use App\Models\MasterAcademicProgram;
use App\Models\MasterClass;
use App\Models\MasterPicket;
use App\Models\MasterRoom;
use App\Models\MasterStudent;
use App\Models\TrxPicketSchedule;
use Illuminate\Http\Request;
use PDF;

class ManageJadwalPiketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $room = MasterRoom::all();
        $category = MasterPicket::all();
        $class = MasterClass::all();
        $data = TrxPicketSchedule::join('master_students', 'master_students.id', '=', 'trx_picket_schedules.student_id')
            ->join('trx_class_groups', 'trx_class_groups.student_id', '=', 'master_students.id')
            ->join('master_rooms', 'master_rooms.id', '=', 'trx_picket_schedules.room_id')
            ->join('master_pickets', 'master_pickets.id', '=', 'trx_picket_schedules.id_category')
            ->select(
                'master_students.name as student_name',
                'trx_picket_schedules.id as id',
                'master_pickets.name as category_name',
                'master_rooms.room_name as room',
                'trx_picket_schedules.time as time'
            );

        $schedule =
            $data->latest('trx_picket_schedules.created_at')->get();
        return view(
            'dashboard.akademik.jadwal_piket.index',
            [
                'piket' => $schedule,
                'category' => $category,
                'room' => $room,
                'class' => $class
            ]
        );
    }
    public function filterDataByCategory(Request $request)
    {
        $room = MasterRoom::all();
        $category = MasterPicket::all();
        $class = MasterClass::all();
        $data = TrxPicketSchedule::join('master_students', 'master_students.id', '=', 'trx_picket_schedules.student_id')
            ->join('trx_class_groups', 'trx_class_groups.student_id', '=', 'master_students.id')
            ->join('master_rooms', 'master_rooms.id', '=', 'trx_picket_schedules.room_id')
            ->join('master_pickets', 'master_pickets.id', '=', 'trx_picket_schedules.id_category');

        if ($request->isMethod('POST')) {
            $request->validate([
                'room_select' => 'sometimes',
                'category' => 'required',
                'class' => 'sometimes',
                'data_category' => 'required'
            ], [
                'category.required' => 'Kategori harus diisi',
                'data_category.required' => 'Kategori data harus diisi'
            ]);

            if ($request->has('showButton')) {
                if ($request->data_category === 'class') {

                    $data->where('trx_picket_schedules.id_category', '=', request('category'))
                        ->where('trx_class_groups.class_id', '=', request('class'))
                        ->latest('trx_picket_schedules.created_at');
                } elseif ($request->data_category === 'room') {
                    $data->where('trx_picket_schedules.id_category', '=', request('category'))
                        ->where('trx_picket_schedules.room_id', '=', request('room_select'))
                        ->latest('trx_picket_schedules.created_at');
                }
            }
            if ($request->has('exportPdf')) {
                if ($request->data_category === 'class') {
                    $class = MasterClass::where('id', $request->class)->firstOrFail();

                    $data->where('trx_picket_schedules.id_category', '=', request('category'))
                        ->where('trx_class_groups.class_id', '=', request('class'))
                        ->latest('trx_picket_schedules.created_at');
                    $schedule = $data->select(
                        'master_students.name as student_name',
                        'trx_picket_schedules.id as id',
                        'master_pickets.name as category_name',
                        'master_rooms.room_name as room',
                        'trx_picket_schedules.time as time'
                    )->get();
                    $pdf = PDF::loadview('dashboard.akademik.jadwal_piket.pdf.generate_jadwal_piket_by_category', [
                        'schedule' => $schedule,
                        'category' => $request->data_category,
                    ])->setPaper('a4', 'landscape');
                    return $pdf->download('JADWAL PIKET KELAS ' . $class->class_name . '.pdf');
                } elseif ($request->data_category === 'room') {
                    $room = MasterRoom::where('id', $request->room_select)->firstOrFail();
                    $data->where('trx_picket_schedules.id_category', '=', $request->category)
                        ->where('trx_picket_schedules.room_id', '=', $request->room_select)
                        ->latest('trx_picket_schedules.created_at');
                    $schedule = $data->select(
                        'master_students.name as student_name',
                        'trx_picket_schedules.id as id',
                        'master_pickets.name as category_name',
                        'master_rooms.room_name as room',
                        'trx_picket_schedules.time as time'
                    )->get();
                    $pdf = PDF::loadview('dashboard.akademik.jadwal_piket.pdf.generate_jadwal_piket_by_category', [
                        'schedule' => $schedule,
                        'category' => $request->data_category,
                    ])->setPaper('a4', 'landscape');
                    return $pdf->download('JADWAL PIKET RUANG ' . $room->room_name . '.pdf');
                }
            }
            $schedule =
                $data->select(
                    'master_students.name as student_name',
                    'trx_picket_schedules.id as id',
                    'master_pickets.name as category_name',
                    'master_rooms.room_name as room',
                    'trx_picket_schedules.time as time'
                )->get();
            return view(
                'dashboard.akademik.jadwal_piket.index',
                [
                    'piket' => $schedule,
                    'category' => $category,
                    'room' => $room,
                    'class' => $class
                ]
            );
        }
        $schedule =
            $data->select(
                'master_students.name as student_name',
                'trx_picket_schedules.id as id',
                'master_pickets.name as category_name',
                'master_rooms.room_name as room',
                'trx_picket_schedules.time as time'
            )->get();
        return view(
            'dashboard.akademik.jadwal_piket.index',
            [
                'piket' => $schedule,
                'category' => $category,
                'room' => $room,
                'class' => $class
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
        $room = MasterRoom::all();
        $category = MasterPicket::all();
        $program = MasterAcademicProgram::all();

        return view('dashboard.akademik.jadwal_piket.create', compact('room', 'category', 'program'));
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
            'time' => 'required|max:20',
            'category' => 'required'
        ], [
            'student_select.required' => 'Santri tidak boleh kosong',
            'room_select.required' => 'Ruang tidak boleh kosong',
            'time.required' => 'Waktu harus diisi',
            'category.required' => 'Kategori harus diisi'
        ]);

        try {
            $student = $request->student_select;
            foreach ($student as $data) {
                TrxPicketSchedule::create([
                    'student_id' => $data,
                    'room_id' => $request->room_select,
                    'time' => $request->time,
                    'id_category' => $request->category
                ]);
            }

            return redirect()->route('jadwalPiket.index')->with('success', 'Jadwal Piket berhasil dibuat');
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
        $student = MasterStudent::all();
        $room = MasterRoom::all();
        $picket = TrxPicketSchedule::with(['room', 'student', 'picket'])->find($id);
        $category = MasterPicket::all();
        return view('dashboard.akademik.jadwal_piket.edit', compact('student', 'room', 'picket', 'category'));
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
            'time' => 'required|max:20',
            'category' => 'required'
        ], [
            'student_select.required' => 'Santri tidak boleh kosong',
            'room_select.required' => 'Ruang tidak boleh kosong',
            'time.required' => 'Waktu harus diisi',
            'category.required' => 'Kategori harus diisi'
        ]);

        try {
            $data = TrxPicketSchedule::find($id);
            $data->student_id = $request->student_select;
            $data->room_id = $request->room_select;
            $data->time = $request->time;
            $data->id_category = $request->category;
            $data->update();
            return redirect()->route('jadwalPiket.index')->with('success', 'Jadwal Piket berhasil diubah');
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
            $data = TrxPicketSchedule::find($id);
            $data->delete();
            return redirect()->route('jadwalPiket.index')->with('success', 'Jadwal Piket berhasil dihapus');
        } catch (\Exception $e) {
            return back()->with('failed', 'Gagal menghapus data');
        }
    }
}
