<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Models\MasterAcademicProgram;
use App\Models\MasterAttendance;
use App\Models\MasterClass;
use App\Models\MasterPeriod;
use App\Models\MasterStudent;
use App\Models\TrxAttendance;
use Illuminate\Http\Request;

class LaporanPresensiController extends Controller
{
    public function index()
    {
        $class = MasterClass::latest()->get();
        $period = MasterPeriod::latest()->get();
        $program = MasterAcademicProgram::all();
        return view('dashboard.report.presensi.index', compact('class', 'period','program'));
    }

    public function filter(Request $request)
    {
        $masterAttendance = MasterAttendance::all();
        $attendances = TrxAttendance::join('master_students', 'master_students.id', '=', 'trx_attendances.student_id')
            ->join('master_periods', 'master_periods.id', '=', 'trx_attendances.id_period')
            ->join('master_attendances', 'master_attendances.id', '=', 'trx_attendances.presence_type')
            ->join('master_academic_programs', 'master_academic_programs.id', 'trx_attendances.program_id')
            ->where('trx_attendances.student_id', $request->studentData)
            ->where('trx_attendances.id_period', $request->periode_academic)
            ->select(
                'master_attendances.name as name_attendance',
                'master_attendances.categories as categories_attendance',
                'trx_attendances.category_attendance as name_category',
                'trx_attendances.other_category as other_category',
                'trx_attendances.status as status',
                'trx_attendances.date_presence as date_presence',
                'trx_attendances.presence_type as presence_type'
            )
            ->orderBy('trx_attendances.date_presence', 'ASC')
            ->get();

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
            'dashboard.report.presensi.pdf.generate_report_pdf_presensi',
            [
                'presence' => $attendances,
                'student' => $student,
                'masterAttendance' => $masterAttendance,
                'period' => $period
            ]
        );
        ///
    }
}
