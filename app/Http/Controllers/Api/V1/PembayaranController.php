<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\ApiResponse;
use App\Models\MasterStudent;
use App\Models\TrxPayment;

class PembayaranController extends Controller
{
    /**
     * get history payment
     */
    public function getHistoryPayment(Request $request)
    {
        try {
            // get student data by email
            $student = MasterStudent::where('email', $request->user()->email)->first();
            $payment = TrxPayment::join('master_users', 'master_users.id', '=', 'trx_payments.id_user')
                ->join('master_payments', 'master_payments.id', '=', 'trx_payments.id_payment')
                ->join('master_students', 'master_students.id', '=', 'trx_payments.id_student')
                ->join('trx_class_groups', 'trx_class_groups.student_id', '=', 'master_students.id')
                ->join('master_academic_programs', 'master_academic_programs.id', '=', 'master_students.program_id')
                ->join('trx_caretakers', 'trx_caretakers.program_id', '=', 'master_academic_programs.id');
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
            )->where('trx_payments.id_user', $request->user()->id)
                ->orWhere('trx_payments.id_student', $student->id)
                ->groupBy('trx_payments.id_student', 'trx_payments.id_payment', 'trx_payments.status')
                ->latest('trx_payments.created_at')->get();
            return ApiResponse::success([
                'payment' => $data
            ], 'Get history payment successfully');
        } catch (\Exception $e) {
            return ApiResponse::error([
                'message' => 'Something went wrong',
                'error' => $e
            ], 'Authentication failed', 500);
        }
    }
}
