<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\MasterStudent;
use App\Models\TrxAttendance;
use Illuminate\Http\Request;

class PresensiController extends Controller
{
    /**
     * history presence
     */
    public function getHistoryPresence(Request $request)
    {
        try {
            // get student data by email
            $student = MasterStudent::where('email', $request->user()->email)->first();
            $presence = TrxAttendance::join('master_users', 'master_users.id', '=', 'trx_attendances.id_operator')
                ->join('master_students', 'master_students.id', '=', 'trx_attendances.student_id')
                ->join('master_attendances', 'master_attendances.id', '=', 'trx_attendances.presence_type')
                ->where('trx_attendances.student_id', '=', $student->id)
                ->select(
                    'trx_attendances.id as id',
                    'master_users.name as name_operator',
                    'master_students.name as student_name',
                    'master_attendances.name as type',
                    'trx_attendances.category_attendance as category',
                    'trx_attendances.other_category as other_category',
                    'trx_attendances.status as status',
                    'trx_attendances.date_presence as date_presence'
                )
                ->latest('trx_attendances.created_at')->get();

            return ApiResponse::success(
                [
                    'presence' => $presence
                ],
                'Get history presence successfully'
            );
        } catch (\Exception $e) {
            return ApiResponse::error([
                'message' => 'Something went wrong',
                'error' => $e
            ], 'Authentication failed', 500);
        }
    }
}
