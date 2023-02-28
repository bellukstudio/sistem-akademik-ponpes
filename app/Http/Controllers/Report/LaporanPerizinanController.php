<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Models\MasterAcademicProgram;
use App\Models\MasterClass;
use App\Models\MasterPeriod;
use App\Models\MasterStudent;
use App\Models\TrxStudentPermits;
use Illuminate\Http\Request;

class LaporanPerizinanController extends Controller
{
    public function index()
    {
        $class = MasterClass::latest()->get();
        $period = MasterPeriod::latest()->get();
        $program = MasterAcademicProgram::all();

        return view('dashboard.report.perizinan.index', compact('class', 'period', 'program'));
    }

    public function filter(Request $request)
    {

        $permit = TrxStudentPermits::join(
            'master_students',
            'master_students.id',
            '=',
            'trx_student_permits.student_id'
        )
            ->join('master_academic_programs', 'master_academic_programs.id', 'trx_student_permits.id_program')
            ->join('master_periods', 'master_periods.id', '=', 'trx_student_permits.id_period')
            ->where('trx_student_permits.student_id', $request->studentData)
            ->where('trx_student_permits.id_period', $request->periode_academic)
            ->select(
                'master_students.name as name',
                'trx_student_permits.permit_type as title_permit',
                'trx_student_permits.description as desc',
                'trx_student_permits.permit_date as date',
                'trx_student_permits.status as status'
            )->latest('trx_student_permits.created_at')->get();

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
                'master_academic_programs.program_name as program_name',
                'master_classes.class_name as class_name'
            )->where('master_students.id', $request->studentData)->firstOrFail();

        return view(
            'dashboard.report.perizinan.pdf.generate_pdf_report_permit',
            [
                'student' => $student,
                'period' => $period,
                'permit' => $permit
            ]
        );
    }
}
