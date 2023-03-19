<?php

namespace App\Http\Controllers\Api\V1\Penilaian;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\MasterStudent;
use App\Models\TrxMemorizeSurah;
use App\Models\TrxScore;
use Illuminate\Http\Request;

class PenilaianController extends Controller
{
    /**
     * get assessment
     */
    public function getResultLastAssessment(Request $request)
    {
        try {
            $assessment = TrxScore::latest()->get();
            return ApiResponse::success($assessment, 'Get assessment successfully');
        } catch (\Exception $e) {
            return ApiResponse::error([
                'message' => 'Something went wrong',
                'error' => $e
            ], 'Opps', 500);
        }
    }

    /**
     * get assessment surah
     */
    public function getAssessmentSurah(Request $request)
    {
        try {
            // request surah
            $surah = $request->input('surah');
            // get student by email
            $student = MasterStudent::where('email', $request->user()->email)->first();
            // get assessment by id student
            $assessment = TrxMemorizeSurah::join('master_users', 'master_users.id', '=', 'trx_memorize_surahs.user_id')
                ->where('trx_memorize_surahs.student_id', $student->id);

            if ($surah) {
                $assessment->where('surah', $surah);
            }
            $data = $assessment->select(
                'trx_memorize_surahs.id as id',
                'trx_memorize_surahs.student_id as student_id',
                'trx_memorize_surahs.verse as verse',
                'trx_memorize_surahs.surah as surah',
                'trx_memorize_surahs.score as score',
                'trx_memorize_surahs.date_assesment as date_assessment',
                'master_users.name as tester'
            )
                ->latest('trx_memorize_surahs.created_at')->get()->map(function($item){
                    $item->student_id = (int) $item->student_id;
                    return $item;
                });
            return ApiResponse::success($data, 'Get assessment memorize successfully');
        } catch (\Exception $e) {
            return ApiResponse::error([
                'message' => 'Something went wrong',
                'error' => $e
            ], 'Opps', 500);
        }
    }
}
