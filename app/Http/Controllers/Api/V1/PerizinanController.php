<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\TrxStudentPermits;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Helpers\ApiResponse;
use App\Models\MasterStudent;

class PerizinanController extends Controller
{

    /**
     * history permit
     */
    public function getHistoryPermit(Request $request)
    {
        try {
            // get student data by email
            $student = MasterStudent::where('email', $request->user()->email)->first();
            $data = TrxStudentPermits::where('student_id', $student->id)->latest()->get();
            return ApiResponse::success([
                'permit' => $data,
            ], 'Get history permit successfully');
        } catch (\Exception $e) {
            return ApiResponse::error([
                'message' => 'Something went wrong',
                'error' => $e
            ], 'Authentication failed', 500);
        }
    }
    /**
     * create new permit
     */
    public function saveNewPermit(Request $request)
    {
    }
}
