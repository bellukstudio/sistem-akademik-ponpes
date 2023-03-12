<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Models\MasterAcademicProgram;
use App\Models\MasterAssessment;
use App\Models\MasterClass;
use App\Models\MasterCourse;
use App\Models\MasterPeriod;
use App\Models\MasterStudent;
use App\Models\TrxScore;
use Illuminate\Http\Request;

class LaporanNilaiAkhirController extends Controller
{
    public function index()
    {
        $class = MasterClass::latest()->get();
        $period = MasterPeriod::latest()->get();
        $program = MasterAcademicProgram::all();

        return view('dashboard.report.nilaiAkhir.index', compact('class', 'period', 'program'));
    }

    public function filter(Request $request)
    {

        $period = MasterPeriod::find($request->periode_academic);

        $student = MasterStudent::join(
            'master_academic_programs',
            'master_academic_programs.id',
            '=',
            'master_students.program_id'
        )->join('trx_class_groups', 'trx_class_groups.student_id', '=', 'master_students.id')
            ->join('master_classes', 'master_classes.id', '=', 'trx_class_groups.class_id')
            ->select(
                'master_students.noId as noId',
                'master_students.name as name',
                'master_academic_programs.id as id_program',
                'master_academic_programs.program_name as program_name',
                'master_classes.class_name as class_name'
            )->where('master_students.id', $request->studentData)->firstOrFail();

        $data = TrxScore::join('master_students', 'master_students.id', '=', 'trx_scores.student_id')
            ->join('master_courses', 'master_courses.id', '=', 'trx_scores.course_id')
            ->join('master_assessments', 'master_assessments.id', '=', 'trx_scores.assessment_id')
            ->where('trx_scores.student_id', $request->studentData)
            ->where('trx_scores.id_period', $request->periode_academic)
            ->where('master_courses.program_id', $student->id_program)
            ->select(
                'master_students.name as name',
                'master_courses.course_name as course_name',
                'trx_scores.score as score',
                'master_courses.id as course_id',
                'master_assessments.name as assessment_name',
                'trx_scores.assessment_id as assessment_id'
            )->groupBy('trx_scores.course_id')
            ->get();

        $category = MasterAssessment::where('program_id', $student->id_program)->get();

        return view(
            'dashboard.report.nilaiAkhir.pdf.generate_pdf_report_final_assessment',
            [
                'student' => $student,
                'period' => $period,
                'score' => $data,
                'category' => $category,
            ]
        );
    }
}
