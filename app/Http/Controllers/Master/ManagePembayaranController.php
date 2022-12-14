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
        $request->validate([
            'payment_name' => 'required',
            'method_name' => 'required',
            'total_payment' => 'required|numeric',
            'payment_number' => 'required|numeric'
        ]);

        try {
            MasterPayment::create([
                'payment_name' => $request->payment_name,
                'total' => $request->total_payment,
                'method' => $request->method_name,
                'payment_number' => $request->payment_number
            ]);
            return back()->with('success', 'Data ' . $request->payment_name . ' berhasil disimpan');
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
        $request->validate([
            'payment_name' => 'required',
            'method_name' => 'required',
            'total_payment' => 'required|numeric',
            'payment_number' => 'required|numeric'
        ]);

        try {
            $data = MasterPayment::find($id);
            $data->payment_name = $request->payment_name;
            $data->total = $request->total_payment;
            $data->method = $request->method_name;
            $data->payment_number = $request->payment_number;
            $data->update();
            return back()->with('success', 'Data ' . $request->payment_name . ' berhasil disimpan');
        } catch (\Exception $e) {
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
        try {
            $data = MasterPayment::find($id);
            $data->delete();
            return back()->with('success', 'Data ' . $data->payment_name . ' berhasil dihapus');
        } catch (\Exception $e) {
            return back()->withErrors($e);
        }
    }
    public function trash()
    {
        $this->authorize('admin');

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
                ->with('success', 'Data ' . $data->payment_name . ' berhasil dipulihkan ');
        } catch (\Exception $e) {
            return back()->withErrors($e);
        }
    }
    public function restoreAll()
    {
        try {
            $data = MasterPayment::onlyTrashed();
            $data->restore();
            return redirect()->route('kelolaPembayaran.index')->with('success', 'Data berhasil dipulihkan');
        } catch (\Exception $e) {
            return back()->withErrors($e);
        }
    }

    public function deletePermanent($id)
    {
        try {
            $data = MasterPayment::onlyTrashed()->where('id', $id)->firstOrFail();
            $data->forceDelete();
            return redirect()->route('trashPayment')
                ->with('success', 'Data ' . $data->payment_name . ' berhasil dihapus permanent');
        } catch (\Exception $e) {
            return back()->withErrors($e);
        }
    }
    public function deletePermanentAll()
    {
        try {
            $data = MasterPayment::onlyTrashed();
            $data->forceDelete();
            return redirect()->route('trashPayment')->with('success', 'Semua data berhasil dihapus permanent');
        } catch (\Exception $e) {
            return back()->withErrors($e);
        }
    }
}
