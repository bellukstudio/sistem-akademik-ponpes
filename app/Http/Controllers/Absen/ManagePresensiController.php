<?php

namespace App\Http\Controllers\Absen;

use App\Http\Controllers\Controller;
use App\Models\MasterAcademicProgram;
use App\Models\MasterAttendance;
use App\Models\MasterClass;
use App\Models\MasterStudent;
use App\Models\MasterTeacher;
use App\Models\TrxAttendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ManagePresensiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $type = MasterAttendance::all();
        // cek data presence
        $student = MasterStudent::join('trx_class_groups', 'trx_class_groups.student_id', '=', 'master_students.id')
            ->join('master_classes', 'master_classes.id', '=', 'trx_class_groups.class_id')
            ->join('master_academic_programs', 'master_academic_programs.id', '=', 'master_students.program_id');
        // jika siswa tidak ada pada jenis absen yang dipilih
        // maka statusnya null
        // jika ada maka status ditampilkan

        $tableHide = true;
        /**
         * filter student by category attendance
         *
         */
        if (request('type')) {
            $tableHide = false;
            $category = explode('+', request('type'));
            $dataCategory = '';
            $typeAttendance = MasterAttendance::where('id', $category[0])->firstOrFail();
            $nameAttendance = $typeAttendance->name;
            $day = $this->currentDay(strtotime(request('date_select')));

            if ($category[1] === 'Kelas') {
                $getClass = MasterClass::where('id', request('optionSelect'))->firstOrFail();
                $dataCategory = $getClass->class_name;
                if ($category[2] === 'TAKLIM') {
                    $student->join('trx_schedules', 'trx_schedules.class_id', '=', 'master_classes.id')
                        ->where('trx_class_groups.class_id', request('optionSelect'))
                        ->where('trx_schedules.time', request('otherSelect'))
                        ->where('trx_schedules.day', $day)->groupBy('master_students.id');
                } else {
                    $student->join('trx_schedules', 'trx_schedules.class_id', '=', 'master_classes.id')
                        ->where('trx_class_groups.class_id', request('optionSelect'))->groupBy('master_students.id');
                }
            } elseif ($category[1] === 'Program') {
                $getProgram = MasterAcademicProgram::where('id', request('optionSelect'))->firstOrFail();
                $dataCategory = $getProgram->program_name;
                $student->where('master_students.program_id', request('optionSelect'))->groupBy('master_students.id');
            } elseif ($category[1] === 'Pengajar') {
                $getTeacher = MasterTeacher::where('id', request('optionSelect'))->firstOrFail();
                $dataCategory = $getTeacher->name;
                if ($category[2] === 'SETORAN') {
                    $student->join('trx_schedules', 'trx_schedules.class_id', '=', 'master_classes.id')
                        ->join('master_teachers', 'master_teachers.id', '=', 'trx_schedules.teacher_id')
                        ->join('master_courses', 'master_courses.id', '=', 'trx_schedules.course_id')
                        ->join(
                            'master_categorie_schedules',
                            'master_categorie_schedules.id',
                            '=',
                            'master_courses.category_id'
                        )
                        ->where('master_teachers.id', request('optionSelect'))
                        ->where('trx_schedules.day', $day)
                        ->where('master_categorie_schedules.categorie_name', 'SETORAN')->groupBy('master_students.id');
                } else {
                    $student->join('trx_schedules', 'trx_schedules.class_id', '=', 'master_classes.id')
                        ->join('master_teachers', 'master_teachers.id', '=', 'trx_schedules.teacher_id')
                        ->join('master_courses', 'master_courses.id', '=', 'trx_schedules.course_id')
                        ->join(
                            'master_categorie_schedules',
                            'master_categorie_schedules.id',
                            '=',
                            'master_courses.category_id'
                        )
                        ->where('master_teachers.id', request('optionSelect'))
                        ->where('trx_schedules.day', $day)
                        ->groupBy('master_students.id');
                }
            }
            $dataType = $category[0];
            $otherCategory = request('otherSelect');
            $dateSelect = request('date_select');



            $data =
                $student->select(
                    'master_students.id as student_id',
                    'master_students.name as student_name',
                    'master_classes.class_name as class_name',
                    'master_academic_programs.program_name as program_name',
                    'master_academic_programs.id as id_program'
                )->get();


            $status = '';
            foreach ($data as $value) {
                // cek status apakah user sudah absen atau belum
                $attendance = TrxAttendance::where('student_id', $value->student_id)
                    ->where('category_attendance', $dataCategory)
                    ->where('presence_type', $dataType)
                    ->where('other_category', $otherCategory)
                    ->where('date_presence', request('date_select'))
                    ->first();
                $status = $attendance->status ?? 'Belum Absen';
            }
            return view(
                'dashboard.absensi.index',
                compact(
                    'type',
                    'tableHide',
                    'data',
                    'dataType',
                    'dataCategory',
                    'nameAttendance',
                    'otherCategory',
                    'day',
                    'dateSelect',
                    'status'
                )
            );
        }

        return view('dashboard.absensi.index', compact('type', 'tableHide'));
    }
    /**
     * save attendance
     */
    public function saveAttendance(Request $request)
    {
        try {
            // check student for attendances
            $student = TrxAttendance::where('student_id', $request->student)
                ->where('category_attendance', $request->category)
                ->where('presence_type', $request->type)
                ->where('other_category', $request->other_category)
                ->where('date_presence', $request->dateSelect)->get();
            if (count($student) == 0) {
                TrxAttendance::create([
                    'student_id' => $request->student,
                    'presence_type' => $request->type,
                    'category_attendance' => $request->category,
                    'program_id' => $request->program,
                    'status' => $request->status,
                    'date_presence' => $request->dateSelect,
                    'id_operator' => Auth::user()->id,
                    'other_category' => $request->other_category
                ]);
            } else {
                $studentA = TrxAttendance::where('student_id', $request->student)
                    ->where('category_attendance', $request->category)
                    ->where('presence_type', $request->type)
                    ->where('other_category', $request->other_category)
                    ->where('date_presence', $request->dateSelect)
                    ->firstOrFail();

                $data = TrxAttendance::findOrFail($studentA->id);
                $data->status = $request->status;
                $data->update();
            }


            return response()->json(['message' => 'Berhasil mengupdate status.']);
        } catch (\Throwable $e) {
            return response()->json(['message' => 'Error' . $e]);
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    /**
     * format day in indonesian
     */
    public function currentDay($data)
    {
        $hari = date("D", $data);

        switch ($hari) {
            case 'Sun':
                $currentDay = "Ahad";
                break;

            case 'Mon':
                $currentDay = "Senin";
                break;

            case 'Tue':
                $currentDay = "Selasa";
                break;

            case 'Wed':
                $currentDay = "Rabu";
                break;

            case 'Thu':
                $currentDay = "Kamis";
                break;

            case 'Fri':
                $currentDay = "Jumat";
                break;

            case 'Sat':
                $currentDay = "Sabtu";
                break;

            default:
                $currentDay = "Tidak di ketahui";
                break;
        }

        return $currentDay;
    }
}
