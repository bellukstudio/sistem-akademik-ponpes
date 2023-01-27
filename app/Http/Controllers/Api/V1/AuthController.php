<?php

namespace App\Http\Controllers\Api\V1;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Helpers\ApiResponse;
use App\Models\MasterStudent;
use App\Models\MasterUsers;
use App\Models\SessionUser;
use App\Models\TrxCaretakers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{

    /**
     * function login API
     */
    public function login(Request $request)
    {
        try {

            // validator login
            $validator = Validator::make(
                $request->all(),
                [
                    'email' => 'required|email:dns',
                    'password' => 'required|min:8'
                ],
                [
                    'email.required' => 'Email must be filled',
                    'password.required' => 'Password must be filled',
                    'password.min' => "Password can't be less than 8 words",
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

            // check input email and session user
            $user = MasterUsers::where('email', $request->email)->first();
            if (!Hash::check($request->password, $user->password, [])) {
                return ApiResponse::error([
                    'message' => 'Incorrect user email or password!',
                    'error' => ''
                ], 'Incorrect credential', 401);
            }

            /**
             * check email from table student and teacher
             */
            $data = '';
            if ($user->roles_id === 4) {
                $data = MasterStudent::where('email', $request->email)->first();
                //create token
                $tokenResult = $user->createToken('authToken')->plainTextToken;
                $checkSession = SessionUser::where('user_id', $user->id)->doesntExist();
                if ($checkSession) {
                    //Save users session
                    $session = [
                        'user_id' => $user->id,
                        'ip_address' => $request->ip(),
                        'user_agent' => $request->server('HTTP_USER_AGENT'),
                        'last_activity' => strtotime(Carbon::now()),
                        'status' => 'ON'
                    ];
                    SessionUser::create($session);
                } else {
                    SessionUser::where('user_id', $user->id)
                        ->update([
                            'ip_address' => $request->ip(),
                            'user_agent' => $request->server('HTTP_USER_AGENT'),
                            'last_activity' => strtotime(Carbon::now()),
                            'status' => 'ON'
                        ]);
                }

                return ApiResponse::success([
                    'access_token' => $tokenResult,
                    'token_type' => 'Bearer',
                    'user' => $data,
                ], 'Authenticated', 200);
            } elseif ($user->roles_id === 3) {
                $caretakers = TrxCaretakers::where('email', $request->email)->first();
                if ($caretakers->categories === 'students') {
                    $data = MasterStudent::where('email', $request->email)->first();
                    //create token
                    $tokenResult = $user->createToken('authToken')->plainTextToken;
                    $checkSession = SessionUser::where('user_id', $user->id)->doesntExist();
                    if ($checkSession) {
                        //Save users session
                        $session = [
                            'user_id' => $user->id,
                            'ip_address' => $request->ip(),
                            'user_agent' => $request->server('HTTP_USER_AGENT'),
                            'last_activity' => strtotime(Carbon::now()),
                            'status' => 'ON'
                        ];
                        SessionUser::create($session);
                    } else {
                        SessionUser::where('user_id', $user->id)
                            ->update([
                                'ip_address' => $request->ip(),
                                'user_agent' => $request->server('HTTP_USER_AGENT'),
                                'last_activity' => strtotime(Carbon::now()),
                                'status' => 'ON'
                            ]);
                    }

                    return ApiResponse::success([
                        'access_token' => $tokenResult,
                        'token_type' => 'Bearer',
                        'user' => $data,
                    ], 'Authenticated', 200);
                } else {
                    return ApiResponse::error([
                        'message' => "Your'e account do not have access",
                    ], 'Do not have access', 404);
                }
            }
        } catch (\Exception $e) {
            return ApiResponse::error([
                'message' => 'Something went wrong',
                'error' => $e
            ], 'Authentication failed', 500);
        }
    }

    /**
     * route logout
     */
    public function logoutUser(Request $request)
    {
        try {
            SessionUser::where('user_id', $request->user()->id)
                ->update([
                    'ip_address' => $request->ip(),
                    'last_activity' => strtotime(Carbon::now()),
                    'status' => 'OFF'
                ]);
            $request->user()->tokens()->delete();
            return ApiResponse::success('Logout successfully', 'Token Revoked');
        } catch (\Exception $e) {
            return ApiResponse::error([
                'message' => 'Something went wrong',
                'error' => $e
            ], 'Authentication failed', 500);
        }
    }
}
