<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Models\MasterAcademicProgram;
use App\Models\MasterClass;
use App\Models\MasterPeriod;
use App\Models\MasterStudent;
use App\Models\TrxMemorizeSurah;
use Illuminate\Http\Request;

class LaporanNilaiHafalanController extends Controller
{
    public function index()
    {
        $class = MasterClass::latest()->get();
        $period = MasterPeriod::latest()->get();
        $program = MasterAcademicProgram::all();

        return view('dashboard.report.nilaiHafalan.index', compact('class', 'period', 'program'));
    }

    public function filter(Request $request)
    {

        $dataSurah = TrxMemorizeSurah::where('student_id', $request->studentData)
            ->select('surah')
            ->groupBy('surah')->latest()->get();

        $data = TrxMemorizeSurah::join('master_students', 'master_students.id', '=', 'trx_memorize_surahs.student_id')
            ->join('master_periods', 'master_periods.id', '=', 'trx_memorize_surahs.id_period')
            ->where('trx_memorize_surahs.student_id', $request->studentData)
            ->where('trx_memorize_surahs.id_period', $request->periode_academic)
            ->select(
                'master_students.name as name',
                'trx_memorize_surahs.surah as surah',
                'trx_memorize_surahs.verse as verse',
                'trx_memorize_surahs.date_assesment as date',
                'trx_memorize_surahs.score as score'
            )
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
            'dashboard.report.nilaiHafalan.pdf.generate_pdf_report_memorize_surah',
            [
                'student' => $student,
                'period' => $period,
                'score' => $data,
                'dataSurah' => $dataSurah
            ]
        );
    }
}
