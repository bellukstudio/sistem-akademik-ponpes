<?php

namespace App\Http\Controllers\Akademik;

use App\Http\Controllers\Controller;
use App\Models\MasterAcademicProgram;
use App\Models\MasterAssessment;
use App\Models\MasterClass;
use App\Models\MasterCourse;
use App\Models\MasterStudent;
use App\Models\TrxScore;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ManagePenilaianController extends Controller
{
    /**
     * index controller
     */

    public function index()
    {
        if (Auth::user()->roles_id === 3 || Auth::user()->roles_id === 4) {
            abort(403);
        }
        $categoryAssessment = MasterAssessment::all();
        $program = MasterAcademicProgram::all();
        return view(
            'dashboard.akademik.kelola_nilai.input_nilai_akhir.index',
            compact('categoryAssessment', 'program')
        );
    }

    /**
     * create controller
     */
    public function create(Request $request)
    {
        if (Auth::user()->roles_id === 3 || Auth::user()->roles_id === 4) {
            abort(403);
        }
        $request->validate(
            [
                'program' => 'required',
                'category' => 'required',
                'class' => 'required',
                'course' => 'required'
            ],
            [
                'program.required' => 'Kolom Program wajib diisi',
                'category.required' => 'Kolom Kategori wajib diisi',
                'class.required' => 'Kolom Kelas wajib diisi',
                'course.required' => 'Kolom Mapel wajib diisi'
            ]
        );


        try {
            $student = MasterStudent::join(
                'trx_class_groups',
                'trx_class_groups.student_id',
                '=',
                'master_students.id'
            )->join('master_classes', 'master_classes.id', '=', 'trx_class_groups.class_id')
                ->join('trx_schedules', 'trx_schedules.class_id', '=', 'master_classes.id')
                ->leftJoin(
                    'master_courses',
                    'master_courses.id',
                    '=',
                    'trx_schedules.course_id'
                )->leftJoin(
                    'trx_scores',
                    function ($join) {
                        $join->on(
                            'trx_scores.student_id',
                            '=',
                            'master_students.id'
                        )->where('trx_scores.assessment_id', '=', request('category'))
                            ->where('trx_scores.course_id', '=', request('course'));
                    }
                )
                ->where('trx_schedules.class_id', '=', $request->class)
                ->where('master_courses.id', '=', $request->course)
                ->select(
                    'master_students.name as student_name',
                    'master_students.id as student_id',
                    'master_classes.class_name as class_name',
                    'master_classes.id as class_id',
                    'master_courses.course_name as course_name',
                    'master_courses.id as course_id',
                    'trx_scores.score as score'
                )->groupBy('master_students.id')->get();
            /** */
            $program  = MasterAcademicProgram::where('id', $request->program)->firstOrFail();
            $class = MasterClass::where('id', $request->class)->firstOrFail();
            $categoryAssessment = MasterAssessment::where('id', $request->category)->firstOrFail();
            $course = MasterCourse::where('id', $request->course)->firstOrFail();
            return view(
                'dashboard.akademik.kelola_nilai.input_nilai_akhir.create',
                [
                    'student' => $student,
                    'program' => $program->program_name,
                    'class' => $class->class_name,
                    'category' => $categoryAssessment->name,
                    'course' => $course->course_name,
                    'idCategory' => $categoryAssessment->id
                ]
            );
        } catch (\Exception $e) {
            return back()->with('failed', 'Gagal menyimpan data');
        }
    }

    public function store(Request $request, $id)
    {
        if (Auth::user()->roles_id === 3 || Auth::user()->roles_id === 4) {
            abort(403);
        }
        $request->validate([
            'score' => 'required',
            'category' => 'required',
            'class' => 'required',
            'course' => 'required'
        ], [
            'score.required' => 'Nilai harus diisi',
            'category.required' => 'Kategori Kosong',
            'class.required' => 'Kelas Kosong',
            'course.required' => 'Mapel kosong'
        ]);
        try {
            TrxScore::create(
                [
                    'student_id' => $id,
                    'class_id' => $request->class,
                    'course_id' => $request->course,
                    'assessment_id' => $request->category,
                    'score' => $request->score,
                    'date_assessment' => date('Y-m-d'),
                    'user_id' => Auth::user()->id
                ]
            );
            return back()->with('success', 'Nilai Berhasil Di Input');
        } catch (\Exception $e) {
            return back()->with('failed', 'Gagal menyimpan data');
        }
    }
}
