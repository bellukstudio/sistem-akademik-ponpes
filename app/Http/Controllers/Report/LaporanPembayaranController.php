<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Models\MasterAcademicProgram;
use App\Models\MasterClass;
use App\Models\MasterPayment;
use App\Models\MasterPeriod;
use App\Models\MasterStudent;
use App\Models\TrxPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaporanPembayaranController extends Controller
{
    public function index()
    {
        $class = MasterClass::latest()->get();
        $period = MasterPeriod::latest()->get();
        $program = MasterAcademicProgram::all();

        return view('dashboard.report.pembayaran.index', compact('class', 'period', 'program'));
    }

    public function filter(Request $request)
    {

        $payment = TrxPayment::join('master_students', 'master_students.id', '=', 'trx_payments.id_student')
            ->join('master_periods', 'master_periods.id', '=', 'trx_payments.id_period')
            ->join('master_payments', 'master_payments.id', '=', 'trx_payments.id_payment')
            ->where('trx_payments.id_student', $request->studentData)
            ->where('trx_payments.id_period', $request->periode_academic)
            ->select(
                'master_students.id as id_student',
                'master_students.name as name',
                'master_payments.payment_name as payment_name',
                'trx_payments.date_payment as date',
                'trx_payments.total as total',
                'trx_payments.id_payment as id_payment',
                'trx_payments.status as status',
            )->latest('trx_payments.created_at')->get();

        $masterPayment = MasterPayment::all();

        // sum total and diff payment
        $sum = DB::table('trx_payments')
            ->select('id_student', 'id_payment', 'status', DB::raw('SUM(total) as sum_total'))->where('status', '1')
            ->groupBy(['id_student', 'id_payment'])
            ->get();

        $diff = DB::table('master_payments')
            ->join('trx_payments', 'master_payments.id', '=', 'trx_payments.id_payment')
            ->select(
                'trx_payments.id_student as id_student',
                'trx_payments.id_payment as id_payment',
                'trx_payments.status as status',
                DB::raw(
                    'master_payments.total - SUM(trx_payments.total) as difference'
                )
            )->where('trx_payments.status', '1')
            ->groupBy(['trx_payments.id_student', 'trx_payments.id_payment'])
            ->get();
        $period = MasterPeriod::find($request->periode_academic);

        $student = MasterStudent::join(
            'master_academic_programs',
            'master_academic_programs.id',
            '=',
            'master_students.program_id'
        )->join('trx_class_groups', 'trx_class_groups.student_id', '=', 'master_students.id')
            ->join('master_classes', 'master_classes.id', '=', 'trx_class_groups.class_id')
            ->select(
                'master_students.noId as noId',
                'master_students.name as name',
                'master_academic_programs.program_name as program_name',
                'master_classes.class_name as class_name'
            )->where('master_students.id', $request->studentData)->firstOrFail();
        return view(
            'dashboard.report.pembayaran.pdf.generate_report_payment_pdf',
            [
                'student' => $student,
                'period' => $period,
                'payment' => $payment,
                'masterPayment' => $masterPayment,
                'sum' => $sum,
                'diff' => $diff
            ]
        );
    }
}
