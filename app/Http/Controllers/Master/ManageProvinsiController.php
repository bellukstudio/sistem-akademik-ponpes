<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\MasterProvince;
use Illuminate\Http\Request;

class ManageProvinsiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = MasterProvince::latest()->get();
        return view('dashboard.master_data.kelola_provinsi.index', [
            'provinsi' => $data
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
            'province_name' => 'required|max:50|unique:master_provinces,province_name'
        ]);

        try {
            MasterProvince::create([
                'province_name' => $request->province_name
            ]);
            return redirect()->route('kelolaProvinsi.index')
                ->with('success', 'Provinsi ' . $request->province_name . ' berhasil di simpan');
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
            'province_name' => 'required|max:50'
        ]);

        try {
            $data = MasterProvince::findOrFail($id);
            $data->province_name = $request->province_name;
            $data->update();
            return redirect()->route('kelolaProvinsi.index')
                ->with('success', 'Provinsi ' . $request->province_name . ' berhasil di ubah');
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
            $data = MasterProvince::find($id);
            $data->delete();
            return redirect()->route('kelolaProvinsi.index')
                ->with('success', 'Provinsi ' . $data->province_name . ' berhasil dihapus');
        } catch (\Exception $e) {
            return back()->withErrors($e);
        }
    }


    public function trash()
    {
        $this->authorize('admin');
        $data = MasterProvince::onlyTrashed()->get();
        return view('dashboard.master_data.kelola_provinsi.trash', [
            'trash' => $data
        ]);
    }

    public function restore($id)
    {
        try {
            $data = MasterProvince::onlyTrashed()->where('id', $id)->firstOrFail();
            $data->restore();
            return redirect()->route('kelolaProvinsi.index')
                ->with('success', 'Provinsi ' . $data->province_name . ' berhasil dipulihkan ');
        } catch (\Exception $e) {
            return back()->withErrors($e);
        }
    }
    public function restoreAll()
    {
        try {
            $data = MasterProvince::onlyTrashed();
            $data->restore();
            return redirect()->route('kelolaProvinsi.index')->with('success', 'Data berhasil dipulihkan');
        } catch (\Exception $e) {
            return back()->withErrors($e);
        }
    }

    public function deletePermanent($id)
    {
        try {
            $data = MasterProvince::onlyTrashed()->where('id', $id)->firstOrFail();
            $data->forceDelete();
            return redirect()->route('trashProgram')
                ->with('success', 'Provinsi ' . $data->province_name . ' berhasil dihapus permanent');
        } catch (\Exception $e) {
            return back()->withErrors($e);
        }
    }
    public function deletePermanentAll()
    {
        try {
            $data = MasterProvince::onlyTrashed();
            $data->forceDelete();
            return redirect()->route('trashProgram')->with('success', 'Semua data berhasil dihapus permanent');
        } catch (\Exception $e) {
            return back()->withErrors($e);
        }
    }
}
