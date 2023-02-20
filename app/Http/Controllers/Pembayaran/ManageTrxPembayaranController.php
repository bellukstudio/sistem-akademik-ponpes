<?php

namespace App\Http\Controllers\Pembayaran;

use App\Helpers\FcmHelper;
use App\Http\Controllers\Controller;
use App\Models\MasterClass;
use App\Models\MasterPayment;
use App\Models\MasterStudent;
use App\Models\MasterTokenFcm;
use Illuminate\Support\Facades\DB;
use App\Models\MasterUsers;
use App\Models\TrxCaretakers;
use App\Models\TrxPayment;
use Illuminate\Http\Request;

class ManageTrxPembayaranController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (auth()->user()->roles_id === 2  || auth()->user()->roles_id === 4) {

            abort(403);
        }
        //category
        $category = MasterPayment::latest()->get();
        //class
        $class = MasterClass::latest()->get();
        // student
        $student = MasterStudent::all();
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
        //payment
        if (auth()->user()->roles_id === 3) {
            $payment = TrxPayment::join('master_users', 'master_users.id', '=', 'trx_payments.id_user')
                ->join('master_payments', 'master_payments.id', '=', 'trx_payments.id_payment')
                ->join('master_students', 'master_students.id', '=', 'trx_payments.id_student')
                ->join('trx_class_groups', 'trx_class_groups.student_id', '=', 'master_students.id')
                ->join('master_academic_programs', 'master_academic_programs.id', '=', 'master_students.program_id')
                ->join('trx_caretakers', 'trx_caretakers.program_id', '=', 'master_academic_programs.id');
            $caretakers = TrxCaretakers::where('user_id', auth()->user()->id)->firstOrFail();
            $data = $payment->select(
                'trx_payments.id as id',
                'master_users.name as name',
                'trx_payments.id_student as id_student',
                'master_payments.payment_name as payment_name',
                'master_payments.media_payment',
                'master_payments.method as method',
                'trx_payments.photo as photo',
                'trx_payments.date_payment as date',
                'master_payments.total as total',
                'trx_payments.total as total_payment',
                'trx_payments.status as status',
                'trx_payments.id_payment as id_payment',

            )->where('trx_caretakers.program_id', '=', $caretakers->program_id)
                ->groupBy(
                    'trx_payments.id_student',
                    'trx_payments.id_payment',
                    'trx_payments.id',
                    'trx_payments.date_payment',
                    'trx_payments.status'
                )
                ->latest('trx_payments.created_at')->get();
            return view('dashboard.pembayaran.index', compact('data', 'category', 'class', 'sum', 'diff'));
        }
        $payment = TrxPayment::join('master_users', 'master_users.id', '=', 'trx_payments.id_user')
            ->join('master_payments', 'master_payments.id', '=', 'trx_payments.id_payment')
            ->join('master_students', 'master_students.id', '=', 'trx_payments.id_student')
            ->join('trx_class_groups', 'trx_class_groups.student_id', '=', 'master_students.id');


        if (request('filter') === 'Kelas') {
            $payment->where('trx_payments.id_payment', request('category'))
                ->where('trx_class_groups.class_id', request('class'));
        } elseif (request('filter') === 'Individu') {
            $payment->where('trx_payments.id_payment', request('category'))
                ->where('trx_payments.id_student', request('student'));
        }

        $data = $payment->select(
            'trx_payments.id as id',
            'master_users.name as name',
            'trx_payments.id_student as id_student',
            'master_payments.payment_name as payment_name',
            'master_payments.media_payment',
            'master_payments.method as method',
            'trx_payments.photo as photo',
            'trx_payments.date_payment as date',
            'master_payments.total as total',
            'trx_payments.total as total_payment',
            'trx_payments.status as status',
            'trx_payments.id_payment as id_payment',
        )
            ->groupBy(
                'trx_payments.id_student',
                'trx_payments.id_payment',
                'trx_payments.id',
                'trx_payments.date_payment',
                'trx_payments.status'
            )
            ->latest('trx_payments.created_at')->get();
        return view('dashboard.pembayaran.index', compact('data', 'category', 'class', 'sum', 'diff', 'student'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('admin');

        $student = MasterUsers::where('roles_id', 4)->get();
        $metode = MasterPayment::all();
        return view('dashboard.pembayaran.create', compact('student', 'metode'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('admin');
        $request->validate([
            'student_id' => 'required',
            'santriList' => 'required',
            'metode' => 'required',
            'datePayment' => 'required',
            'total' => 'required|max:50'
        ]);

        try {
            $student = explode(':', $request->santriList);
            TrxPayment::create([
                'id_user' => $student[0],
                'id_student' => $request->student_id,
                'id_payment' => $request->metode,
                'date_payment' => $request->datePayment,
                'total' => $request->total
            ]);
            return redirect()->route('pembayaran.index')
                ->with('success', 'Pembayaran ' . $student[1] . ' berhasil disimpan');
        } catch (\Exception $e) {
            return back()->withErrors($e);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->authorize('admin');
        $student = MasterUsers::where('roles_id', 4)->get();
        $metode = MasterPayment::all();
        $data = TrxPayment::find($id);
        return view('dashboard.pembayaran.edit', compact('student', 'metode', 'data'));
    }

    public function updateUserPayment(Request $request, $id)
    {
        $this->authorize('admin');
        $request->validate([
            'student_id' => 'required',
            'santriList' => 'required',
            'metode' => 'required',
            'datePayment' => 'required',
            'total' => 'required|max:50'
        ]);

        try {
            $student = explode(':', $request->santriList);
            $data = TrxPayment::find($id);
            $data->id_user = $student[0];
            $data->id_student = $request->student_id;
            $data->id_payment = $request->metode;
            $data->date_payment = $request->datePayment;
            $data->total = $request->total;
            $data->update();

            return redirect()->route('pembayaran.index')
                ->with('success', 'Pembayaran ' . $student[1] . ' berhasil diubah');
        } catch (\Exception $e) {
            return back()->withErrors($e);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (auth()->user()->roles_id === 2  || auth()->user()->roles_id === 4) {
            abort(403);
        }
        $request->validate([
            'status' => 'required'
        ]);

        try {
            $data = TrxPayment::find($id);
            $data->status = $request->status;
            $data->update();

            // send notification
            sleep(1);
            $data['page'] = 'paymentPage';
            $checkAvaiableToken = MasterTokenFcm::all();
            $deviceRegistration = MasterTokenFcm::where('id_user', $data->id_user)->firstOrFail();
            $masterPayment = MasterPayment::find($data->id_payment);
            if (count($checkAvaiableToken) > 0) {
                $status = $request->status == 1 ? 'Di Setujui' : 'Di Tolak!';
                $dataFcm = [
                    'data' => $data
                ];
                FcmHelper::sendNotificationWithGuzzle(
                    'Pembayaran ' . $masterPayment->payment_name . ' ' . $status,
                    $dataFcm,
                    false,
                    $deviceRegistration->token
                );
            }

            return back()->with('success', 'Berhasil mengubah status ' . $data->user->name);
        } catch (\Throwable $e) {
            return back()->withErrors($e);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('admin');

        if (auth()->user()->roles_id === 2  || auth()->user()->roles_id === 4) {

            abort(403);
        }
        try {
            $data = TrxPayment::find($id);
            $data->delete();

            return back()->with('success', 'Berhasil menghapus data  ' . $data->user->name);
        } catch (\Throwable $e) {
            return back()->withErrors($e);
        }
    }
}
