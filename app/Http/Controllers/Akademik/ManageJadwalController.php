<?php

namespace App\Http\Controllers\Akademik;

use App\Http\Controllers\Controller;
use App\Models\MasterAcademicProgram;
use App\Models\MasterCategorieSchedule;
use App\Models\MasterClass;
use App\Models\MasterCourse;
use App\Models\MasterTeacher;
use App\Models\TrxSchedule;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\PDF;

class ManageJadwalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data =
            TrxSchedule::join('master_classes', 'master_classes.id', '=', 'trx_schedules.class_id')
            ->join('master_teachers', 'master_teachers.id', '=', 'trx_schedules.teacher_id')
            ->join('master_courses', 'master_courses.id', '=', 'trx_schedules.course_id')
            ->join('master_categorie_schedules', 'master_categorie_schedules.id', '=', 'master_courses.category_id');
        $filter = false;
        $schedule =
            $data
            ->select(
                'master_teachers.name as teacher_name',
                'master_courses.course_name as course_name',
                'master_classes.class_name as class_name',
                'master_classes.id as class_id',
                'trx_schedules.day as day',
                'trx_schedules.time as times',
                'trx_schedules.id as id_schedules',
                'master_categorie_schedules.categorie_name as categorie_name'
            )->latest('trx_schedules.created_at')->get();


        return view('dashboard.akademik.jadwal.index', [
            'jadwal' => $schedule,
            'filter' => $filter
        ]);
    }
    public function filterScheduleByCategories(Request $request)
    {
        $filter = true;
        $data =
            TrxSchedule::join('master_classes', 'trx_schedules.class_id', '=', 'master_classes.id')
            ->join('master_teachers', 'trx_schedules.teacher_id', '=', 'master_teachers.id')
            ->join('master_courses', 'trx_schedules.course_id', '=', 'master_courses.id')
            ->join('master_categorie_schedules', 'master_courses.category_id', '=', 'master_categorie_schedules.id')
            ->orderBy('trx_schedules.class_id')
            ->select(
                'master_teachers.name as teacher_name',
                'master_courses.course_name as course_name',
                'master_classes.class_name as class_name',
                'master_classes.id as class_id',
                'trx_schedules.day as day',
                'trx_schedules.time as times',
                'trx_schedules.id as id_schedules',
                'master_categorie_schedules.categorie_name as categorie_name'
            );

        /**
         *  get schedule in sunday alltime
         * */
        $sundayMorning = TrxSchedule::join('master_courses', 'trx_schedules.course_id', '=', 'master_courses.id')
            ->join('master_categorie_schedules', 'master_courses.category_id', '=', 'master_categorie_schedules.id')
            ->where('trx_schedules.day', 'Ahad')
            ->where('trx_schedules.time', 'Pagi')
            ->where('master_courses.category_id', request('courseCategory'))
            ->select(
                'master_courses.course_name as course_name',
                'trx_schedules.class_id as class_id'

            )->get();
        $sundayAfternoon =
            TrxSchedule::join('master_courses', 'trx_schedules.course_id', '=', 'master_courses.id')
            ->join('master_categorie_schedules', 'master_courses.category_id', '=', 'master_categorie_schedules.id')
            ->where('trx_schedules.day', 'Ahad')->where('master_courses.category_id', request('courseCategory'))
            ->where('trx_schedules.time', 'Siang')->select(
                'master_courses.course_name as course_name',
                'trx_schedules.class_id as class_id'
            )->get();
        $sundayEvening =
            TrxSchedule::join('master_courses', 'trx_schedules.course_id', '=', 'master_courses.id')
            ->join('master_categorie_schedules', 'master_courses.category_id', '=', 'master_categorie_schedules.id')
            ->where('trx_schedules.day', 'Ahad')->where('master_courses.category_id', request('courseCategory'))
            ->where('trx_schedules.time', 'Sore')->select(
                'master_courses.course_name as course_name',
                'trx_schedules.class_id as class_id'
            )->get();
        $sundayNight =
            TrxSchedule::join('master_courses', 'trx_schedules.course_id', '=', 'master_courses.id')
            ->join('master_categorie_schedules', 'master_courses.category_id', '=', 'master_categorie_schedules.id')
            ->where('trx_schedules.day', 'Ahad')->where('master_courses.category_id', request('courseCategory'))
            ->where('trx_schedules.time', 'Malam')->select(
                'master_courses.course_name as course_name',
                'trx_schedules.class_id as class_id'
            )->get();
        /**
         * end
         */
        /**
         * get schedule in monday alltime
         */
        $mondayMorning = TrxSchedule::join('master_courses', 'trx_schedules.course_id', '=', 'master_courses.id')
            ->join('master_categorie_schedules', 'master_courses.category_id', '=', 'master_categorie_schedules.id')
            ->where('trx_schedules.day', 'Senin')->where('master_courses.category_id', request('courseCategory'))
            ->where('trx_schedules.time', 'Pagi')->select(
                'master_courses.course_name as course_name',
                'trx_schedules.class_id as class_id'
            )->get();
        $mondayAfternoon =
            TrxSchedule::join('master_courses', 'trx_schedules.course_id', '=', 'master_courses.id')
            ->join('master_categorie_schedules', 'master_courses.category_id', '=', 'master_categorie_schedules.id')
            ->where('trx_schedules.day', 'Senin')->where('master_courses.category_id', request('courseCategory'))
            ->where('trx_schedules.time', 'Siang')->select(
                'master_courses.course_name as course_name',
                'trx_schedules.class_id as class_id'
            )->get();
        $mondayEvening =
            TrxSchedule::join('master_courses', 'trx_schedules.course_id', '=', 'master_courses.id')
            ->join('master_categorie_schedules', 'master_courses.category_id', '=', 'master_categorie_schedules.id')
            ->where('trx_schedules.day', 'Senin')->where('master_courses.category_id', request('courseCategory'))
            ->where('trx_schedules.time', 'Sore')->select(
                'master_courses.course_name as course_name',
                'trx_schedules.class_id as class_id'
            )->get();
        $mondayNight =
            TrxSchedule::join('master_courses', 'trx_schedules.course_id', '=', 'master_courses.id')
            ->join('master_categorie_schedules', 'master_courses.category_id', '=', 'master_categorie_schedules.id')
            ->where('trx_schedules.day', 'Senin')->where('master_courses.category_id', request('courseCategory'))
            ->where('trx_schedules.time', 'Malam')->select(
                'master_courses.course_name as course_name',
                'trx_schedules.class_id as class_id'
            )->get();
        /**
         * end
         */
        /**
         * get schedule in tuesday alltime
         */
        $tuesdayMorning = TrxSchedule::join('master_courses', 'trx_schedules.course_id', '=', 'master_courses.id')
            ->join('master_categorie_schedules', 'master_courses.category_id', '=', 'master_categorie_schedules.id')
            ->where('trx_schedules.day', 'Selasa')->where('master_courses.category_id', request('courseCategory'))
            ->where('trx_schedules.time', 'Pagi')->select(
                'master_courses.course_name as course_name',
                'trx_schedules.class_id as class_id'
            )->get();
        $tuesdayAfternoon =
            TrxSchedule::join('master_courses', 'trx_schedules.course_id', '=', 'master_courses.id')
            ->join('master_categorie_schedules', 'master_courses.category_id', '=', 'master_categorie_schedules.id')
            ->where('trx_schedules.day', 'Selasa')->where('master_courses.category_id', request('courseCategory'))
            ->where('trx_schedules.time', 'Siang')->select(
                'master_courses.course_name as course_name',
                'trx_schedules.class_id as class_id'
            )->get();
        $tuesdayEvening =
            TrxSchedule::join('master_courses', 'trx_schedules.course_id', '=', 'master_courses.id')
            ->join('master_categorie_schedules', 'master_courses.category_id', '=', 'master_categorie_schedules.id')
            ->where('trx_schedules.day', 'Selasa')->where('master_courses.category_id', request('courseCategory'))
            ->where('trx_schedules.time', 'Sore')->select(
                'master_courses.course_name as course_name',
                'trx_schedules.class_id as class_id'
            )->get();
        $tuesdayNight =
            TrxSchedule::join('master_courses', 'trx_schedules.course_id', '=', 'master_courses.id')
            ->join('master_categorie_schedules', 'master_courses.category_id', '=', 'master_categorie_schedules.id')
            ->where('trx_schedules.day', 'Selasa')->where('master_courses.category_id', request('courseCategory'))
            ->where('trx_schedules.time', 'Malam')->select(
                'master_courses.course_name as course_name',
                'trx_schedules.class_id as class_id'
            )->get();
        /**
         * end
         */
        /**
         * get schedule in wednesday alltime
         */
        $wednesdayMorning = TrxSchedule::join('master_courses', 'trx_schedules.course_id', '=', 'master_courses.id')
            ->join('master_categorie_schedules', 'master_courses.category_id', '=', 'master_categorie_schedules.id')
            ->where('trx_schedules.day', 'Rabu')->where('master_courses.category_id', request('courseCategory'))
            ->where('trx_schedules.time', 'Pagi')->select(
                'master_courses.course_name as course_name',
                'trx_schedules.class_id as class_id'
            )->get();
        $wednesdayAfternoon =
            TrxSchedule::join('master_courses', 'trx_schedules.course_id', '=', 'master_courses.id')
            ->join('master_categorie_schedules', 'master_courses.category_id', '=', 'master_categorie_schedules.id')
            ->where('trx_schedules.day', 'Rabu')->where('master_courses.category_id', request('courseCategory'))
            ->where('trx_schedules.time', 'Siang')->select(
                'master_courses.course_name as course_name',
                'trx_schedules.class_id as class_id'
            )->get();
        $wednesdayEvening =
            TrxSchedule::join('master_courses', 'trx_schedules.course_id', '=', 'master_courses.id')
            ->join('master_categorie_schedules', 'master_courses.category_id', '=', 'master_categorie_schedules.id')
            ->where('trx_schedules.day', 'Rabu')->where('master_courses.category_id', request('courseCategory'))
            ->where('trx_schedules.time', 'Sore')->select(
                'master_courses.course_name as course_name',
                'trx_schedules.class_id as class_id'
            )->get();
        $wednesdayNight =
            TrxSchedule::join('master_courses', 'trx_schedules.course_id', '=', 'master_courses.id')
            ->join('master_categorie_schedules', 'master_courses.category_id', '=', 'master_categorie_schedules.id')
            ->where('trx_schedules.day', 'Rabu')->where('master_courses.category_id', request('courseCategory'))
            ->where('trx_schedules.time', 'Malam')->select(
                'master_courses.course_name as course_name',
                'trx_schedules.class_id as class_id'
            )->get();
        /**
         * end
         */
        /**
         * get schedule in thursday alltime
         */
        $thursdayMorning = TrxSchedule::join('master_courses', 'trx_schedules.course_id', '=', 'master_courses.id')
            ->join('master_categorie_schedules', 'master_courses.category_id', '=', 'master_categorie_schedules.id')
            ->where('trx_schedules.day', 'Kamis')->where('master_courses.category_id', request('courseCategory'))
            ->where('trx_schedules.time', 'Pagi')->select(
                'master_courses.course_name as course_name',
                'trx_schedules.class_id as class_id'
            )->get();
        $thursdayAfternoon =
            TrxSchedule::join('master_courses', 'trx_schedules.course_id', '=', 'master_courses.id')
            ->join('master_categorie_schedules', 'master_courses.category_id', '=', 'master_categorie_schedules.id')
            ->where('trx_schedules.day', 'Kamis')->where('master_courses.category_id', request('courseCategory'))
            ->where('trx_schedules.time', 'Siang')->select(
                'master_courses.course_name as course_name',
                'trx_schedules.class_id as class_id'
            )->get();
        $thursdayEvening =
            TrxSchedule::join('master_courses', 'trx_schedules.course_id', '=', 'master_courses.id')
            ->join('master_categorie_schedules', 'master_courses.category_id', '=', 'master_categorie_schedules.id')
            ->where('trx_schedules.day', 'Kamis')->where('master_courses.category_id', request('courseCategory'))
            ->where('trx_schedules.time', 'Sore')->select(
                'master_courses.course_name as course_name',
                'trx_schedules.class_id as class_id'
            )->get();
        $thursdayNight =
            TrxSchedule::join('master_courses', 'trx_schedules.course_id', '=', 'master_courses.id')
            ->join('master_categorie_schedules', 'master_courses.category_id', '=', 'master_categorie_schedules.id')
            ->where('trx_schedules.day', 'Kamis')->where('master_courses.category_id', request('courseCategory'))
            ->where('trx_schedules.time', 'Malam')->select(
                'master_courses.course_name as course_name',
                'trx_schedules.class_id as class_id'
            )->get();
        /**
         * end
         */
        /**
         * get schedule in friday alltime
         */
        $fridayMorning = TrxSchedule::join('master_courses', 'trx_schedules.course_id', '=', 'master_courses.id')
            ->join('master_categorie_schedules', 'master_courses.category_id', '=', 'master_categorie_schedules.id')
            ->where('trx_schedules.day', 'Jumat')->where('master_courses.category_id', request('courseCategory'))
            ->where('trx_schedules.time', 'Pagi')->select(
                'master_courses.course_name as course_name',
                'trx_schedules.class_id as class_id'
            )->get();
        $fridayAfternoon =
            TrxSchedule::join('master_courses', 'trx_schedules.course_id', '=', 'master_courses.id')
            ->join('master_categorie_schedules', 'master_courses.category_id', '=', 'master_categorie_schedules.id')
            ->where('trx_schedules.day', 'Jumat')->where('master_courses.category_id', request('courseCategory'))
            ->where('trx_schedules.time', 'Siang')->select(
                'master_courses.course_name as course_name',
                'trx_schedules.class_id as class_id'
            )->get();
        $fridayEvening =
            TrxSchedule::join('master_courses', 'trx_schedules.course_id', '=', 'master_courses.id')
            ->join('master_categorie_schedules', 'master_courses.category_id', '=', 'master_categorie_schedules.id')
            ->where('trx_schedules.day', 'Jumat')->where('master_courses.category_id', request('courseCategory'))
            ->where('trx_schedules.time', 'Sore')->select(
                'master_courses.course_name as course_name',
                'trx_schedules.class_id as class_id'
            )->get();
        $fridayNight = TrxSchedule::join('master_courses', 'trx_schedules.course_id', '=', 'master_courses.id')
            ->join('master_categorie_schedules', 'master_courses.category_id', '=', 'master_categorie_schedules.id')
            ->where('trx_schedules.day', 'Jumat')->where('master_courses.category_id', request('courseCategory'))
            ->where('trx_schedules.time', 'Malam')->select(
                'master_courses.course_name as course_name',
                'trx_schedules.class_id as class_id'
            )->get();
        /**
         * end
         */
        /**
         * get schedule in saturday alltime
         */
        $saturdayMorning = TrxSchedule::join('master_courses', 'trx_schedules.course_id', '=', 'master_courses.id')
            ->join('master_categorie_schedules', 'master_courses.category_id', '=', 'master_categorie_schedules.id')
            ->where('trx_schedules.day', 'Sabtu')->where('master_courses.category_id', request('courseCategory'))
            ->where('trx_schedules.time', 'Pagi')->select(
                'master_courses.course_name as course_name',
                'trx_schedules.class_id as class_id'
            )->get();
        $saturdayAfternoon =
            TrxSchedule::join('master_courses', 'trx_schedules.course_id', '=', 'master_courses.id')
            ->join('master_categorie_schedules', 'master_courses.category_id', '=', 'master_categorie_schedules.id')
            ->where('trx_schedules.day', 'Sabtu')->where('master_courses.category_id', request('courseCategory'))
            ->where('trx_schedules.time', 'Siang')->select(
                'master_courses.course_name as course_name',
                'trx_schedules.class_id as class_id'
            )->get();
        $saturdayEvening =
            TrxSchedule::join('master_courses', 'trx_schedules.course_id', '=', 'master_courses.id')
            ->join('master_categorie_schedules', 'master_courses.category_id', '=', 'master_categorie_schedules.id')
            ->where('trx_schedules.day', 'Sabtu')->where('master_courses.category_id', request('courseCategory'))
            ->where('trx_schedules.time', 'Sore')->select(
                'master_courses.course_name as course_name',
                'trx_schedules.class_id as class_id'
            )->get();
        $saturdayNight =
            TrxSchedule::join('master_courses', 'trx_schedules.course_id', '=', 'master_courses.id')
            ->join('master_categorie_schedules', 'master_courses.category_id', '=', 'master_categorie_schedules.id')
            ->where('trx_schedules.day', 'Sabtu')->where('master_courses.category_id', request('courseCategory'))
            ->where('trx_schedules.time', 'Malam')->select(
                'master_courses.course_name as course_name',
                'trx_schedules.class_id as class_id'
            )->get();
        /**
         * end
         */


        if ($request->isMethod('POST')) {
            $request->validate([
                'category' => 'required',
                'data' => 'required',
                'courseCategory' => 'required'
            ]);
            if ($request->has('showButton')) {
                if (request('category') === 'mapel') {
                    $data->where('trx_schedules.course_id', request('data'))
                        ->where('master_courses.category_id', request('courseCategory'))
                        ->latest('trx_schedules.created_at');
                } elseif (request('category') === 'waktu') {
                    $data->where('trx_schedules.time', request('data'))
                        ->where('master_courses.category_id', request('courseCategory'))
                        ->latest('trx_schedules.created_at');
                } elseif (request('category') === 'kelas') {
                    $data->where('trx_schedules.class_id', request('data'))
                        ->where('master_courses.category_id', request('courseCategory'));
                } elseif (request('category') === 'hari') {
                    $data->where('trx_schedules.day', request('data'))
                        ->where('master_courses.category_id', request('courseCategory'))
                        ->latest('trx_schedules.created_at');
                } elseif (request('category') === 'program') {
                    $data->where('master_courses.program_id', request('data'))
                        ->where('master_courses.category_id', request('courseCategory'))
                        ->latest('trx_schedules.created_at');
                }
            }
            if ($request->has('exportPdf')) {
                if (request('category') === 'mapel') {
                    $course = MasterCourse::where('id', request('data'))->firstOrFail();
                    $data->where('trx_schedules.course_id', request('data'))
                        ->where('master_courses.category_id', request('courseCategory'));
                    $bycourse
                        = $data->orderByRaw("field(trx_schedules.day,'Ahad','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu')")->get();
                    // export to pdf
                    $pdf = PDF::loadview('dashboard.akademik.jadwal.pdf.generate_jadwal_by_category', [
                        'schedule' => $bycourse,
                        'category' => request('category'),
                        'course' => $course->course_name
                    ])->setPaper('a4', 'landscape');
                    return $pdf->download('JADWAL MATA PELAJARAN ' . $course->course_name . '.pdf');
                } elseif (request('category') === 'waktu') {
                    $data->where('trx_schedules.time', request('data'))
                        ->where('master_courses.category_id', request('courseCategory'));
                    $byTime =
                        $data->orderByRaw("field(trx_schedules.day,'Ahad','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu')")->get();
                    // export to pdf
                    $pdf = PDF::loadview('dashboard.akademik.jadwal.pdf.generate_jadwal_by_category', [
                        'schedule' => $byTime,
                        'category' => request('category'),
                        'time' => request('data')
                    ])->setPaper('a4', 'landscape');
                    return $pdf->download('Jadwal Waktu' . request('data') . '.pdf');
                } elseif (request('category') === 'kelas') {
                    $class = MasterClass::where('id', request('data'))->firstOrFail();
                    $data->where('trx_schedules.class_id', request('data'))
                        ->where('master_courses.category_id', request('courseCategory'));
                    $byClass
                        = $data->orderByRaw("field(trx_schedules.day,'Ahad','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu')")->get();
                    // export to pdf
                    $pdf = PDF::loadview('dashboard.akademik.jadwal.pdf.generate_jadwal_by_category', [
                        'schedule' => $byClass,
                        'category' => request('category'),
                        'class' => $class->class_name
                    ])->setPaper('a4', 'landscape');
                    return $pdf->download('JADWAL KELAS ' . $class->class_name . '.pdf');
                } elseif (request('category') === 'hari') {
                    $data->where('trx_schedules.day', request('data'))
                        ->where('master_courses.category_id', request('courseCategory'));
                    $byDay =
                        $data->orderByRaw("field(trx_schedules.day,'Ahad','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu')")->get();
                    // export to pdf
                    $pdf = PDF::loadview('dashboard.akademik.jadwal.pdf.generate_jadwal_by_category', [
                        'schedule' => $byDay,
                        'category' => request('category'),
                        'day' => request('data')
                    ])->setPaper('a4', 'landscape');
                    return $pdf->download('Jadwal Hari' . request('data') . '.pdf');
                } elseif (request('category') === 'program') {
                    $program = MasterAcademicProgram::where('id', request('data'))->firstOrFail();
                    $courseCategory = MasterCategorieSchedule::where('id', request('courseCategory'))->firstOrFail();
                    $byProgram = $data->where('master_courses.program_id', request('data'))
                        ->where('master_courses.category_id', request('courseCategory'))
                        ->orderByRaw("field(trx_schedules.day,'Ahad',
                        'Senin','Selasa','Rabu','Kamis','Jumat','Sabtu')")
                        ->groupBy('master_classes.id')->get();

                    $class = $data->orderBy('trx_schedules.class_id')->orderBy('master_classes.id', 'ASC')->get();
                    $times = $data->groupBy('trx_schedules.time')->orderBy('trx_schedules.time', 'ASC')->get();
                    // export to pdf
                    $pdf = PDF::loadview('dashboard.akademik.jadwal.pdf.generate_jadwal_by_category', [
                        'class' => $class,
                        'schedule' => $byProgram,
                        'category' => request('category'),
                        'program' => $program->program_name,
                        'courseCategory' => $courseCategory->categorie_name,
                        'time' => $times,
                        'sundayMorning' => $sundayMorning,
                        'sundayAfternoon' => $sundayAfternoon,
                        'sundayEvening' => $sundayEvening,
                        'sundayNight' => $sundayNight,
                        'mondayMorning' => $mondayMorning,
                        'mondayAfternoon' => $mondayAfternoon,
                        'mondayEvening' => $mondayEvening,
                        'mondayNight' => $mondayNight,
                        'tuesdayMorning' => $tuesdayMorning,
                        'tuesdayAfternoon' => $tuesdayAfternoon,
                        'tuesdayEvening' => $tuesdayEvening,
                        'tuesdayNight' => $tuesdayNight,
                        'wednesdayMorning' => $wednesdayMorning,
                        'wednesdayAfternoon' => $wednesdayAfternoon,
                        'wednesdayEvening' => $wednesdayEvening,
                        'wednesdayNight' => $wednesdayNight,
                        'thursdayMorning' => $thursdayMorning,
                        'thursdayAfternoon' => $thursdayAfternoon,
                        'thursdayEvening' => $thursdayEvening,
                        'thursdayNight' => $thursdayNight,
                        'fridayMorning' => $fridayMorning,
                        'fridayAfternoon' => $fridayAfternoon,
                        'fridayEvening' => $fridayEvening,
                        'fridayNight' => $fridayNight,
                        'saturdayMorning' => $saturdayMorning,
                        'saturdayAfternoon' => $saturdayAfternoon,
                        'saturdayEvening' => $saturdayEvening,
                        'saturdayNight' => $saturdayNight,
                    ])->setPaper('a4', 'landscape');
                    return $pdf
                        ->download('JADWAL ' . $courseCategory->categorie_name . ' ' . $program->program_name . '.pdf');
                }
            }

            if (request('category') === 'program') {
                $schedule = $data->orderByRaw("field(trx_schedules.day,'Ahad',
                'Senin','Selasa','Rabu','Kamis','Jumat','Sabtu')")
                    ->get();
                $preview = $data->orderByRaw("field(trx_schedules.day,'Ahad',
                'Senin','Selasa','Rabu','Kamis','Jumat','Sabtu')")
                    ->groupBy('master_classes.id')->get();

                return view('dashboard.akademik.jadwal.index', [
                    'jadwal' => $schedule,
                    'filter' => $filter,
                    'category' => request('category'),
                    'preview' => $preview,
                    'sundayMorning' => $sundayMorning,
                    'sundayAfternoon' => $sundayAfternoon,
                    'sundayEvening' => $sundayEvening,
                    'sundayNight' => $sundayNight,
                    'mondayMorning' => $mondayMorning,
                    'mondayAfternoon' => $mondayAfternoon,
                    'mondayEvening' => $mondayEvening,
                    'mondayNight' => $mondayNight,
                    'tuesdayMorning' => $tuesdayMorning,
                    'tuesdayAfternoon' => $tuesdayAfternoon,
                    'tuesdayEvening' => $tuesdayEvening,
                    'tuesdayNight' => $tuesdayNight,
                    'wednesdayMorning' => $wednesdayMorning,
                    'wednesdayAfternoon' => $wednesdayAfternoon,
                    'wednesdayEvening' => $wednesdayEvening,
                    'wednesdayNight' => $wednesdayNight,
                    'thursdayMorning' => $thursdayMorning,
                    'thursdayAfternoon' => $thursdayAfternoon,
                    'thursdayEvening' => $thursdayEvening,
                    'thursdayNight' => $thursdayNight,
                    'fridayMorning' => $fridayMorning,
                    'fridayAfternoon' => $fridayAfternoon,
                    'fridayEvening' => $fridayEvening,
                    'fridayNight' => $fridayNight,
                    'saturdayMorning' => $saturdayMorning,
                    'saturdayAfternoon' => $saturdayAfternoon,
                    'saturdayEvening' => $saturdayEvening,
                    'saturdayNight' => $saturdayNight,

                ]);
            }

            $schedule = $data->orderByRaw("field(trx_schedules.day,
                'Ahad','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu')")
                ->get();
            return view('dashboard.akademik.jadwal.index', [
                'jadwal' => $schedule,
                'filter' => $filter,
                'category' => request('category'),
            ]);
        }
        $schedule = $data->get();
        return view('dashboard.akademik.jadwal.index', [
            'jadwal' => $schedule,
            'filter' => $filter,
            'category' => request('category')
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
            $class = $request->class_select;
            foreach ($class as $data) {
                TrxSchedule::create([
                    'teacher_id' => $request->teacher_select,
                    'class_id' => $data,
                    'course_id' => $request->course_select,
                    'day' => $request->day,
                    'time' => $request->time
                ]);
            }
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
