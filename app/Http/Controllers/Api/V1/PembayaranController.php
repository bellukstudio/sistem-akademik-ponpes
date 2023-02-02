<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\ApiResponse;
use App\Models\MasterPayment;
use App\Models\MasterStudent;
use App\Models\TrxPayment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PembayaranController extends Controller
{
    /**
     * get history payment
     */
    public function getHistoryPayment(Request $request)
    {
        try {
            $category = $request->input('id_payment');

            $payment = TrxPayment::join('master_users', 'master_users.id', '=', 'trx_payments.id_user')
                ->join('master_payments', 'master_payments.id', '=', 'trx_payments.id_payment')
                ->join('master_students', 'master_students.id', '=', 'trx_payments.id_student')
                ->join('trx_class_groups', 'trx_class_groups.student_id', '=', 'master_students.id')
                ->orWhere(function ($query) {
                    // get student data by email
                    $student = MasterStudent::where('email', Auth::user()->email)->first();
                    $query->where('trx_payments.id_user', Auth::user()->id)
                        ->where('trx_payments.id_student', $student->id);
                });

            if ($category) {
                $payment->where('master_payments.id', $category);
            }
            $data = $payment->select(
                'trx_payments.id as id',
                'master_users.name as name',
                'master_payments.payment_name as payment_name',
                'master_payments.media_payment',
                'master_payments.method as method',
                'trx_payments.photo as photo',
                'trx_payments.date_payment as date',
                'master_payments.total as total',
                'trx_payments.total as total_payment',
                'trx_payments.status as status'
            )
                ->latest('trx_payments.created_at')->get();
            return ApiResponse::success([
                'payment' => $data
            ], 'Get history payment successfully');
        } catch (\Exception $e) {
            return ApiResponse::error([
                'message' => 'Something went wrong',
                'error' => $e
            ], 'Opps', 500);
        }
    }

    /**
     * get all categorie payment
     */
    public function getAllCategoriePayment()
    {
        try {
            $payment = TrxPayment::join('master_users', 'master_users.id', '=', 'trx_payments.id_user')
                ->join('master_payments', 'master_payments.id', '=', 'trx_payments.id_payment')
                ->join('master_students', 'master_students.id', '=', 'trx_payments.id_student')
                ->join('trx_class_groups', 'trx_class_groups.student_id', '=', 'master_students.id')
                ->orWhere(function ($query) {
                    // get student data by email
                    $student = MasterStudent::where('email', Auth::user()->email)->first();
                    $query->where('trx_payments.id_user', Auth::user()->id)
                        ->where('trx_payments.id_student', $student->id);
                });

            $data = $payment->select(
                'trx_payments.id as id_payment',
                'master_payments.payment_name as payment_name',
                'master_payments.media_payment',
                'master_payments.method as method',
                'master_payments.total as total',
                'trx_payments.status as status'
            )
                ->selectRaw('SUM(trx_payments.total) as sum_total')
                ->selectRaw('master_payments.total - SUM(trx_payments.total) as diff')
                ->groupBy('trx_payments.id_student', 'trx_payments.id_payment', 'trx_payments.status')
                ->latest('trx_payments.created_at')->get();

            return ApiResponse::success($data, 'Success get categories payment');
        } catch (\Exception $e) {
            return ApiResponse::error([
                'message' => 'Something went wrong',
                'error' => $e
            ], 'Opps', 500);
        }
    }
    /**
     * save new payment
     */
    public function saveNewPayment(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'type' => 'required',
                'date_payment' => 'required',
                'total' => 'required',
            ], [
                'type.required' => 'Type must be filled',
                'date_payment.required' => 'Date payment must be filled',
                'total.required' => 'Total must be filled'
            ]);

            // return back when validation is false
            if ($validator->fails()) {
                $errorMsg = join(', ', $validator->errors()->all());
                return ApiResponse::error([
                    'message' => 'The given data is invalid',
                    'error' => $errorMsg
                ], 'Request is invalid', 422);
            }
            $student = MasterStudent::where('email', $request->user()->email)->first();
            $data = [
                'id_user' => $request->user()->id,
                'id_student' => $student->id,
                'id_payment' => $request->type,
                'date_payment' => $request->date_payment,
                'total' => $request->total,
            ];
            TrxPayment::create($data);

            return ApiResponse::success([
                'payment' => $data,
                'message' => 'Successfully create new payment'
            ], 'Data Saved');
        } catch (\Exception $e) {
            return ApiResponse::error([
                'message' => 'Something went wrong',
                'error' => $e
            ], 'Opps', 500);
        }
    }

    public function uploadPhoto(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'file' => 'required|image|max:2048'
            ]);
            if ($validator->fails()) {
                return ApiResponse::error([
                    'error' => $validator->errors(),
                ], 'Update Photo failed', 401);
            }
            // get student by email
            $student = MasterStudent::where('email', $request->user()->email)->first();
            // get payment categorie
            $trxPayment = TrxPayment::findOrFail($id);
            $paymentCategorie = MasterPayment::where('id', $trxPayment->id_payment)->firstOrFail();
            // remove space in name student
            $name = str_replace(' ', '_', $student->name);
            if ($request->file('file')) {
                $file = $request->file
                    ->storeAs(
                        'payment/' . $student->noId,
                        strtolower($name) . '_'
                            . date('Y-m-d') . '_' . strtolower($paymentCategorie->payment_name) . '.png',
                        'public'
                    );

                //save photo url to db
                $payment = TrxPayment::findOrFail($id);
                $payment->photo = $file;
                $payment->update();

                return ApiResponse::success([$file], 'File successfully uploaded');
            }
        } catch (\Exception $e) {
            return ApiResponse::error([
                'message' => 'Something went wrong',
                'error' => $e
            ], 'Opps', 500);
        }
    }
}
