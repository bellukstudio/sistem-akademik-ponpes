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
            ], 'Opps', 500);
        }
    }
    /**
     * create new permit
     */
    public function saveNewPermit(Request $request)
    {
        try {
            $validator = Validator::make(
                $request->all(),
                [
                    'title' => 'required|max:50',
                    'description' => 'required',
                    'date_permit' => 'required'
                ],
                [
                    'title.required' => 'Title must be filled',
                    'title.max' => 'Maximum title is 50 characters',
                    'description.required' => 'Description must be filled',
                    'date_permit.required' => 'Date must be filled'
                ]
            );

            // return back when validation is false
            if ($validator->fails()) {
                $errorMsg = join(', ', $validator->errors()->all());
                return ApiResponse::error([
                    'message' => 'The given data is invalid',
                    'error' => $errorMsg
                ], 'Request is invalid', 422);
            }

            // get student by email
            $student = MasterStudent::where('email', $request->user()->email)->first();
            $data = [
                'student_id' => $student->id,
                'description' => $request->description,
                'permit_date' => $request->date_permit,
                'permit_type' => $request->title,
                'id_program' => $student->program_id
            ];
            TrxStudentPermits::create($data);
            return ApiResponse::success([
                'permit' => $data,
                'message' => 'Successfully create new permit'
            ], 'Data Saved');
        } catch (\Exception $e) {
            return ApiResponse::error([
                'message' => 'Something went wrong',
                'error' => $e
            ], 'Opps', 500);
        }
    }
    /**
     * count history permit
     */
    public function countHistoryPermit(Request $request)
    {
        try {
            // get student data by email
            $student = MasterStudent::where('email', $request->user()->email)->first();
            $data = TrxStudentPermits::where('student_id', $student->id)->count();
            return ApiResponse::success([
                'total' => $data,
            ], 'Get count history permit successfully');
        } catch (\Exception $e) {
            return ApiResponse::error([
                'message' => 'Something went wrong',
                'error' => $e
            ], 'Opps', 500);
        }
    }
}
