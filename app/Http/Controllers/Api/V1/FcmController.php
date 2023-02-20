<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\ApiResponse;
use App\Models\MasterTokenFcm;
use Illuminate\Support\Facades\Validator;


class FcmController extends Controller
{

    public function saveToken(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'token' => 'required',

            ], [
                'token.required' => 'Token must be filled',

            ]);
            // return back when validation is false
            if ($validator->fails()) {
                $errorMsg = join(', ', $validator->errors()->all());
                return ApiResponse::error([
                    'message' => 'The given data is invalid',
                    'error' => $errorMsg
                ], 'Request is invalid', 422);
            }
            $user = MasterTokenFcm::where('id_user', $request->user()->id)->get();
            if (count($user) == 0) {
                //save
                MasterTokenFcm::create(
                    [
                        'token' => $request->token,
                        'id_user' => $request->user()->id,
                    ]
                );
            } else {
                $userToken = MasterTokenFcm::where('id_user', $request->user()->id)->firstOrFail();
                $userToken->token = $request->token;
                $userToken->update();
            }
            return ApiResponse::success('Berhasil menyimpan token', 'Successfully');
        } catch (\Exception $e) {
            return ApiResponse::error([
                'message' => 'Something went wrong',
                'error' => $e
            ], 'Opps server Error', 500);
        }
    }
}
