<?php

namespace App\Http\Controllers\Perizinan;

use App\Http\Controllers\Controller;
use App\Models\TrxStudentPermits;
use Illuminate\Http\Request;

class ManagePerizinanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = TrxStudentPermits::with(['user', 'program'])->latest()->get();
        return view('dashboard.perizinan.index', [
            'perizinan' => $data
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
        $request->validate([
            'status' => 'required'
        ]);

        try {
            $data = TrxStudentPermits::find($id);
            $data->status = $request->status;
            $data->update();

            return back()->with('success', 'Data berhasil diubah');
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
            $data = TrxStudentPermits::find($id);
            $data->delete();

            return back()->with('success', 'Data berhasil dihapus');
        } catch (\Exception $e) {
            return back()->withErrors($e);
        }
    }
    /**
     * softdeletes
     */
    public function trash()
    {
        $this->authorize('admin');

        $data = TrxStudentPermits::with(['user', 'program'])->onlyTrashed()->get();
        return view('dashboard.perizinan.trash', [
            'trash' => $data
        ]);
    }

    public function restore($id)
    {
        try {
            $data = TrxStudentPermits::onlyTrashed()->where('id', $id)->firstOrFail();
            $data->restore();
            return redirect()->route('perizinan.index')
                ->with('success', 'Data berhasil dipulihkan ');
        } catch (\Exception $e) {
            return back()->withErrors($e);
        }
    }
    public function restoreAll()
    {
        try {
            $data = TrxStudentPermits::onlyTrashed();
            $data->restore();
            return redirect()->route('perizinan.index')->with('success', 'Data berhasil dipulihkan');
        } catch (\Exception $e) {
            return back()->withErrors($e);
        }
    }

    public function deletePermanent($id)
    {
        try {
            $data = TrxStudentPermits::onlyTrashed()->where('id', $id)->firstOrFail();
            $data->forceDelete();
            return redirect()->route('trashPermit')
                ->with('success', 'Data berhasil dihapus permanent');
        } catch (\Exception $e) {
            return back()->withErrors($e);
        }
    }
    public function deletePermanentAll()
    {
        try {
            $data = TrxStudentPermits::onlyTrashed();
            $data->forceDelete();
            return redirect()->route('trashPermit')->with('success', 'Semua data berhasil dihapus permanent');
        } catch (\Exception $e) {
            return back()->withErrors($e);
        }
    }
}