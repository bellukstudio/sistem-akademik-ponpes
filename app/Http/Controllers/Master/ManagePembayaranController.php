<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\MasterPayment;
use Illuminate\Http\Request;

class ManagePembayaranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = MasterPayment::latest()->get();
        return view('dashboard.master_data.kelola_pembayaran.index', [
            'pembayaran' => $data
        ]);
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
        $request->validate(
            [
                'payment_name' => 'required', 'method_name' => 'required',
                'media_payment' => 'required|max:50', 'total_payment' => 'required|numeric',
                'payment_number' => 'required|numeric'
            ],
            [
                'payment_name.required' => 'Kolom Nama Pembayaran harus diisi.',
                'method_name.required' => 'Kolom Metode Pembayaran harus diisi.',
                'media_payment.required' => 'Kolom Media Pembayaran harus diisi.',
                'media_payment.max' => 'Kolom Media Pembayaran maksimal terdiri dari 50 karakter.',
                'total_payment.required' => 'Kolom Jumlah Pembayaran harus diisi.',
                'total_payment.numeric' => 'Kolom Jumlah Pembayaran harus berupa angka.',
                'payment_number.required' => 'Kolom Nomor Pembayaran harus diisi.',
                'payment_number.numeric' => 'Kolom Nomor Pembayaran harus berupa angka.'
            ]
        );


        try {
            MasterPayment::create([
                'payment_name' => $request->payment_name,
                'total' => $request->total_payment,
                'method' => $request->method_name,
                'payment_number' => $request->payment_number,
                'media_payment' => $request->media_payment
            ]);
            return back()->with('success', 'Pembayaran ' . $request->payment_name . ' berhasil disimpan');
        } catch (\Exception $e) {
            return back()->with('failed', 'Gagal menyimpan data');
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
        $request->validate(
            [
                'payment_name' => 'required', 'method_name' => 'required',
                'media_payment' => 'required|max:50', 'total_payment' => 'required|numeric',
                'payment_number' => 'required|numeric'
            ],
            [
                'payment_name.required' => 'Kolom Nama Pembayaran harus diisi.',
                'method_name.required' => 'Kolom Metode Pembayaran harus diisi.',
                'media_payment.required' => 'Kolom Media Pembayaran harus diisi.',
                'media_payment.max' => 'Kolom Media Pembayaran maksimal terdiri dari 50 karakter.',
                'total_payment.required' => 'Kolom Jumlah Pembayaran harus diisi.',
                'total_payment.numeric' => 'Kolom Jumlah Pembayaran harus berupa angka.',
                'payment_number.required' => 'Kolom Nomor Pembayaran harus diisi.',
                'payment_number.numeric' => 'Kolom Nomor Pembayaran harus berupa angka.'
            ]
        );


        try {
            $data = MasterPayment::find($id);
            $data->payment_name = $request->payment_name;
            $data->total = $request->total_payment;
            $data->method = $request->method_name;
            $data->media_payment = $request->media_payment;
            $data->payment_number = $request->payment_number;
            $data->update();
            return back()->with('success', 'Pembayaran ' . $request->payment_name . ' berhasil diubah');
        } catch (\Exception $e) {
            return back()->with('failed', 'Gagal mengubah data');
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
        try {
            $data = MasterPayment::find($id);
            $data->delete();
            return back()->with('success', 'Pembayaran ' . $data->payment_name . ' berhasil dihapus');
        } catch (\Exception $e) {
            return back()->with('failed', 'Gagal menghapus data');
        }
    }
    public function trash()
    {
       

        $data = MasterPayment::onlyTrashed()->get();
        return view('dashboard.master_data.kelola_pembayaran.trash', [
            'trash' => $data
        ]);
    }

    public function restore($id)
    {
       

        try {
            $data = MasterPayment::onlyTrashed()->where('id', $id)->firstOrFail();
            $data->restore();
            return redirect()->route('kelolaPembayaran.index')
                ->with('success', 'Pembayaran ' . $data->payment_name . ' berhasil dipulihkan ');
        } catch (\Exception $e) {
            return back()->with('failed', 'Gagal memulihkan data');
        }
    }
    public function restoreAll()
    {
       

        try {
            $data = MasterPayment::onlyTrashed();
            $data->restore();
            return redirect()->route('kelolaPembayaran.index')->with('success', 'Data berhasil dipulihkan');
        } catch (\Exception $e) {
            return back()->with('failed', 'Gagal memulihkan data');
        }
    }

    public function deletePermanent($id)
    {
       

        try {
            $data = MasterPayment::onlyTrashed()->where('id', $id)->firstOrFail();
            $data->forceDelete();
            return redirect()->route('trashPayment')
                ->with('success', 'Pembayaran ' . $data->payment_name . ' berhasil dihapus permanent');
        } catch (\Exception $e) {
            return back()->with('failed', 'Gagal menghapus data');
        }
    }
    public function deletePermanentAll()
    {
       

        try {
            $data = MasterPayment::onlyTrashed();
            $data->forceDelete();
            return redirect()->route('trashPayment')->with('success', 'Semua data berhasil dihapus permanent');
        } catch (\Exception $e) {
            return back()->with('failed', 'Gagal menghapus data');
        }
    }
}
