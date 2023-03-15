<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\MasterCategorieSchedule;
use Illuminate\Http\Request;

class ManageKategoriMapelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = MasterCategorieSchedule::latest()->get();
        return view('dashboard.master_data.kelola_kategori_mapel.index', compact('data'));
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
                'name' => 'required|max:50',
            ],
            [
                'name.required' => 'Kolom Nama harus diisi.',
                'name.max' => 'Kolom Nama maksimal 50. Karakter',
            ]
        );

        try {
            MasterCategorieSchedule::create([
                'categorie_name' => $request->name
            ]);
            return back()->with('success', 'Kategori ' . $request->name . ' berhasil disimpan');
        } catch (\Exception $e) {
            return back()->with('failed', 'Gagal menyimpan data');
        }
    }
    /**
     * get all student with json
     */
    public function getAllCategoryCourse()
    {
        $empData['data'] = MasterCategorieSchedule::all();

        return response()->json($empData);
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
                'name' => 'required|max:50',
            ],
            [
                'name.required' => 'Kolom Nama harus diisi.',
                'name.max' => 'Kolom Nama maksimal 50. Karakter',
            ]
        );
        try {
            $data = MasterCategorieSchedule::find($id);
            $data->categorie_name = $request->name;
            $data->update();
            return back()->with('success', 'Kategori ' . $request->name . ' berhasil diubah');
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
            $data = MasterCategorieSchedule::find($id);
            $data->delete();
            return back()->with('success', 'Kategori ' . $data->categorie_name . ' berhasil dihapus');
        } catch (\Exception $e) {
            return back()->with('failed', 'Gagal menghapus data');
        }
    }

    public function trash()
    {
        if (auth()->user()->roles_id != 1) {
            abort(403);
        }
        $data = MasterCategorieSchedule::onlyTrashed()->get();
        return view('dashboard.master_data.kelola_kategori_mapel.trash', [
            'trash' => $data
        ]);
    }

    public function restore($id)
    {
        try {
            $data = MasterCategorieSchedule::onlyTrashed()->where('id', $id)->firstOrFail();
            $data->restore();
            return redirect()->route('kategoriMapel.index')
                ->with('success', 'Program ' . $data->categorie_name . ' berhasil dipulihkan ');
        } catch (\Exception $e) {
            return back()->with('failed', 'Gagal memulihkan data');
        }
    }
    public function restoreAll()
    {
        try {
            $data = MasterCategorieSchedule::onlyTrashed();
            $data->restore();
            return redirect()->route('kategoriMapel.index')->with('success', 'Data berhasil dipulihkan');
        } catch (\Exception $e) {
            return back()->with('failed', 'Gagal memulihkan data');
        }
    }

    public function deletePermanent($id)
    {
        try {
            $data = MasterCategorieSchedule::onlyTrashed()->where('id', $id)->firstOrFail();
            $data->forceDelete();
            return redirect()->route('trashCategorieSchedule')
                ->with('success', 'Program ' . $data->categorie_name . ' berhasil dihapus permanent');
        } catch (\Exception $e) {

            return back()->with('failed', 'Gagal menghapus data');
        }
    }
    public function deletePermanentAll()
    {
        try {
            $data = MasterCategorieSchedule::onlyTrashed();
            $data->forceDelete();
            return redirect()->route('trashCategorieSchedule')
                ->with('success', 'Semua data berhasil dihapus permanent');
        } catch (\Exception $e) {

            return back()->with('failed', 'Gagal menghapus data');
        }
    }
}
