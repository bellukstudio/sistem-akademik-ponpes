<?php

namespace App\Http\Controllers\Pembayaran;

use App\Http\Controllers\Controller;
use App\Models\MasterClass;
use App\Models\MasterPayment;
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
        //payment
        $payment = TrxPayment::join('master_users', 'master_users.id', '=', 'trx_payments.id_user')
            ->join('master_payments', 'master_payments.id', '=', 'trx_payments.id_payment')
            ->join('master_students', 'master_students.id', '=', 'trx_payments.id_student')
            ->join('trx_class_groups', 'trx_class_groups.student_id', '=', 'master_students.id');
        if (request('category') && request('class')) {
            $payment->where('trx_payments.id_payment', request('category'))
                ->where('trx_class_groups.class_id', request('class'));
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
            ->selectRaw('SUM(trx_payments.total) as sum_total')
            ->selectRaw('master_payments.total - SUM(trx_payments.total) as remaining')
            ->groupBy('trx_payments.id_student', 'trx_payments.id_payment', 'trx_payments.status')
            ->latest('trx_payments.created_at')->get();
        return view('dashboard.pembayaran.index', compact('data', 'category', 'class'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
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
