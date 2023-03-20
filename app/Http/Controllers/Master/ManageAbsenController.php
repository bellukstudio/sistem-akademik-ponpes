<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\MasterAttendance;
use Illuminate\Http\Request;

class ManageAbsenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = MasterAttendance::latest()->get();
        return view('dashboard.master_data.kelola_absen.index', [
            'absen' => $data
        ]);
        //
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
                'name' => 'required',
                'categories' => 'required'
            ],
            [
                'name.required' => 'Kolom Nama harus diisi.',
                'categories.required' => 'Kolom Kategori harus diisi.'
            ]
        );

        try {
            MasterAttendance::create([
                'name' => $request->name,
                'categories' => $request->categories
            ]);
            return back()->with('success', 'Absen ' . $request->name . ' berhasil disimpan');
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
                'name' => 'required',
                'categories' => 'required'
            ],
            [
                'name.required' => 'Kolom Nama harus diisi.',
                'categories.required' => 'Kolom Kategori harus diisi.'
            ]
        );

        try {
            $data = MasterAttendance::find($id);
            $data->name = $request->name;
            $data->categories = $request->categories;
            $data->update();
            return back()->with('success', 'Absen ' . $request->name . ' berhasil diupdate');
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
            $data = MasterAttendance::find($id);
            $data->delete();
            return back()->with('success', 'Absen ' . $data->name . ' berhasil dihapus');
        } catch (\Exception $e) {
            return back()->with('failed', 'Gagal menghapus data');
        }
    }
    public function trash()
    {
        $data = MasterAttendance::onlyTrashed()->get();
        return view('dashboard.master_data.kelola_absen.trash', [
            'trash' => $data
        ]);
    }

    public function restore($id)
    {

        try {
            $data = MasterAttendance::onlyTrashed()->where('id', $id)->firstOrFail();
            $data->restore();
            return redirect()->route('kelolaAbsen.index')
                ->with('success', 'Absen ' . $data->name . ' berhasil dipulihkan ');
        } catch (\Exception $e) {
            return back()->with('failed', 'Gagal memulihkan data');
        }
    }
    public function restoreAll()
    {

        try {
            $data = MasterAttendance::onlyTrashed();
            $data->restore();
            return redirect()->route('kelolaAbsen.index')->with('success', 'Data berhasil dipulihkan');
        } catch (\Exception $e) {
            return back()->with('failed', 'Gagal memulihkan data');
        }
    }

    public function deletePermanent($id)
    {

        try {
            $data = MasterAttendance::onlyTrashed()->where('id', $id)->firstOrFail();
            $data->forceDelete();
            return redirect()->route('trashAttendance')
                ->with('success', 'Absen ' . $data->name . ' berhasil dihapus permanent');
        } catch (\Exception $e) {
            return back()->with('failed', 'Gagal menghapus data');
        }
    }
    public function deletePermanentAll()
    {

        try {
            $data = MasterAttendance::onlyTrashed();
            $data->forceDelete();
            return redirect()->route('trashAttendance')->with('success', 'Semua data berhasil dihapus permanent');
        } catch (\Exception $e) {
            return back()->with('failed', 'Gagal menghapus data');
        }
    }
}
