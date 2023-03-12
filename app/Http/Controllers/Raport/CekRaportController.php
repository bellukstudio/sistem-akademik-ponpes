<?php

namespace App\Http\Controllers\Raport;

use App\Http\Controllers\Controller;
use App\Models\MasterAssessment;
use App\Models\MasterPeriod;
use App\Models\MasterStudent;
use App\Models\TrxScore;
use Illuminate\Http\Request;

class CekRaportController extends Controller
{
    public function index()
    {
        $isShow = false;
        $period = MasterPeriod::all();
        return view('check-raport.index', compact('period', 'isShow'));
    }

    public function filter(Request $request)
    {
        $request->validate([
            'noId' => 'required|exists:master_students,noId',
            'date_birth' => 'required|max:15'
        ], [
            'noId.required' => 'Nomer ID harus diisi',
            'noId.exists' => 'Nomer ID tidak di temukan',
            'date_birth.required' => 'Tanggal lahir harus diisi',
            'date_birth.max' => 'Tanggal lahir maksimal 15 Karakter'
        ]);

        $student = MasterStudent::where('noId', $request->noId)
            ->where(function ($query) use ($request) {
                $query->where('date_birth_mother', $request->date_birth)
                    ->orWhere('date_birth_father', $request->date_birth);
            })
            ->first();
        $data = TrxScore::join('master_students', 'master_students.id', '=', 'trx_scores.student_id')
            ->join('master_courses', 'master_courses.id', '=', 'trx_scores.course_id')
            ->join('master_assessments', 'master_assessments.id', '=', 'trx_scores.assessment_id')
            ->where('trx_scores.student_id', $student->id)
            ->where('trx_scores.id_period', 4)
            ->select(
                'master_students.name as name',
                'master_courses.course_name as course_name',
                'trx_scores.score as score',
                'trx_scores.id_period as id_period',
                'master_courses.id as course_id',
                'master_assessments.name as assessment_name',
                'trx_scores.assessment_id as assessment_id'
            )->groupBy('trx_scores.course_id')
            ->get();
        $isShow = true;
        $category = MasterAssessment::where('program_id', $student->program_id)->get();
        $period = MasterPeriod::all();
        return view('check-raport.index', compact('period', 'isShow', 'data', 'category'));
    }
}
