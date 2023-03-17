<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\TrxStudentPermits;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Helpers\ApiResponse;
use App\Helpers\FcmHelper;
use App\Models\MasterPeriod;
use App\Models\MasterStudent;
use App\Models\MasterTokenFcm;

class PerizinanController extends Controller
{

    /**
     * history permit
     */
    public function getHistoryPermit(Request $request)
    {
        try {
            $date = $request->input('date');
            // get student data by email
            $student = MasterStudent::where('email', $request->user()->email)->first();
            $permit = TrxStudentPermits::where('student_id', $student->id);
            if ($date) {
                $permit->where('permit_date', $date);
            }
            $data =
                $permit->latest()->get();
            return ApiResponse::success([
                'permit' => $data,
            ], 'Get history permit successfully');
        } catch (\Exception $e) {
            return ApiResponse::error([
                'message' => 'Something went wrong.',
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
            $period = MasterPeriod::where('status', 1)->first();
            $student = MasterStudent::where('email', $request->user()->email)->first();
            $data = [
                'student_id' => $student->id,
                'description' => $request->description,
                'permit_date' => $request->date_permit,
                'permit_type' => $request->title,
                'id_program' => intval($student->program_id),
                'id_period' => intval($period->id) ?? null
            ];
            TrxStudentPermits::create($data);


            try {
                // send notification

                sleep(1);
                $checkAvaiableToken = MasterTokenFcm::all();
                if (count($checkAvaiableToken) > 0) {
                    $dataFcm = [
                        'data' => $data
                    ];
                    FcmHelper::sendNotificationWithGuzzleForWeb(
                        title: 'Ada Perizinan Baru ',
                        body: $request->title . PHP_EOL . $request->description,
                        data: $dataFcm,
                        programId: $student->program_id
                    );
                }
            } catch (\Throwable $e) {
                return ApiResponse::success([
                    'permit' => $data,
                    'message' => 'Successfully create new permit'
                ], 'Data Saved without send notif');
            }
            return ApiResponse::success([
                'permit' => $data,
                'message' => 'Successfully create new permit'
            ], 'Data Saved');
        } catch (\Exception $e) {
            return ApiResponse::error([
                'message' => 'Something went wrong..',
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
                'message' => 'Something went wrong...',
                'error' => $e
            ], 'Opps', 500);
        }
    }
    /**
     * edit permit if status null
     */
    public function updatePermit(Request $request, $id)
    {
        try {

            //
            $period = MasterPeriod::where('status', 1)->first();
            $student = MasterStudent::where('email', $request->user()->email)->first();
            $data = TrxStudentPermits::find($id);
            if ($data->student_id === $student->id) {
                if ($data->status == null) {
                    $data->permit_date = $request->date_permit;
                    $data->permit_type = $request->title;
                    $data->description = $request->description;
                    $data->id_period = intval($period->id) ?? null;
                    $data->update();
                    return ApiResponse::success([
                        'permit' => $data,
                        'message' => 'Successfully update permit'
                    ], 'Data Saved');
                } else {
                    return ApiResponse::error([
                        'message' => 'Failed update permit'
                    ], 'Failed Update Data', 401);
                }
            } else {
                return ApiResponse::error([
                    'message' => 'Failed update permit'
                ], 'Failed Update Data', 404);
            }
        } catch (\Exception $e) {
            return ApiResponse::error([
                'message' => 'Something went wrong',
                'error' => $e
            ], 'Opps', 500);
        }
    }

    /**
     * delete permit if status null
     */
    public function deletePermit(Request $request, $id)
    {
        try {

            //
            $student = MasterStudent::where('email', $request->user()->email)->first();
            $data = TrxStudentPermits::find($id);
            if ($data->student_id === $student->id) {
                if ($data->status == null) {
                    $data->delete();
                    return ApiResponse::success([
                        'permit' => $data,
                        'message' => 'Successfully delete permit'
                    ], 'Data deleted');
                } else {
                    return ApiResponse::error([
                        'message' => 'Failed update permit'
                    ], 'Failed Update Data', 401);
                }
            } else {
                return ApiResponse::error([
                    'message' => 'Failed update permit'
                ], 'Failed Update Data', 404);
            }
        } catch (\Exception $e) {
            return ApiResponse::error([
                'message' => 'Something went wrong',
                'error' => $e
            ], 'Opps', 500);
        }
    }
}
