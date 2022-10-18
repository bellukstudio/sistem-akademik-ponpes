<?php

namespace App\Http\Controllers\Akademik;

use App\Http\Controllers\Controller;
use App\Models\MasterTahunAjar;
use Illuminate\Http\Request;

class TahunAkademikController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = MasterTahunAjar::latest()->get();
        return view('dashboard.master_data.kelola_tahunAkademik.index', [
            'tahunAkademik' => $data
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
            'kode' => 'required|max:20',
            'tgl_mulai' => 'required|date',
            'tgl_selesai' => 'required|date'
        ]);

        try {
            MasterTahunAjar::create([
                'kode' => $request->kode,
                'tgl_mulai' => $request->tgl_mulai,
                'tgl_selesai' => $request->tgl_selesai
            ]);

            return redirect()->route('manageTahunAkademik.index')->with('success', 'Berhasil menambah data baru');
        } catch (\Exception $e) {
            return back()->withErrors($e);
        }
    }

    // update status data
    public function updateStatus(Request $request)
    {

        try {
            $data = MasterTahunAjar::findOrFail($request->id);
            $data->status = $request->status;
            $data->save();

            return response()->json(['message' => 'Berhasil mengupdate status.']);
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
            'kode' => 'required|max:20',
            'tgl_mulai' => 'required|date',
            'tgl_selesai' => 'required|date'
        ]);

        try {
            $data = MasterTahunAjar::findOrFail($id);
            $data->kode = $request->kode;
            $data->tgl_mulai = $request->tgl_mulai;
            $data->tgl_selesai = $request->tgl_selesai;
            $data->update();

            return redirect()->route('manageTahunAkademik.index')
                ->with('success', 'Berhasil mengubah data ' . $data->kode . '');
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
            $data = MasterTahunAjar::find($id);
            $data->delete();
            return redirect()->route('manageTahunAkademik.index')
                ->with('success', 'Berhasil menghapus data ' . $data->kode . '');
        } catch (\Exception $e) {
            return back()->withErrors($e);
        }
    }

    public function trash()
    {
        $data = MasterTahunAjar::onlyTrashed()->get();
        return view('dashboard.master_data.kelola_tahunAkademik.trash', [
            'trash' => $data
        ]);
    }

    public function restore($id)
    {
        try {
            $data = MasterTahunAjar::onlyTrashed()->where('id', $id);
            $data->restore();
            return redirect()->route('manageTahunAkademik.index')->with('success', 'Data berhasil dipulihkan ');
        } catch (\Exception $e) {
            return back()->withErrors($e);
        }
    }
    public function restoreAll()
    {
        try {
            $data = MasterTahunAjar::onlyTrashed();
            $data->restore();
            return redirect()->route('manageTahunAkademik.index')->with('success', 'Data berhasil dipulihkan');
        } catch (\Exception $e) {
            return back()->withErrors($e);
        }
    }

    public function deletePermanent($id)
    {
        try {
            $data = MasterTahunAjar::onlyTrashed()->where('id', $id);
            $data->forceDelete();
            return redirect()->route('trashTahunAkademik')->with('success', 'Data berhasil dihapus permanent');
        } catch (\Exception $e) {
            return back()->withErrors($e);
        }
    }
    public function deletePermanentAll()
    {
        try {
            $data = MasterTahunAjar::onlyTrashed();
            $data->forceDelete();
            return redirect()->route('trashTahunAkademik')->with('success', 'Semua data berhasil dihapus permanent');
        } catch (\Exception $e) {
            return back()->withErrors($e);
        }
    }
}
