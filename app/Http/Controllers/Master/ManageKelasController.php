<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\MasterClass;
use Illuminate\Http\Request;

class ManageKelasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = MasterClass::latest()->get();
        return view('dashboard.master_data.kelola_kelas.index', [
            'kelas' => $data
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
            'class_name' => 'required|unique:master_classes,class_name'
        ]);

        try {
            MasterClass::create([
                'class_name' => $request->class_name
            ]);

            return redirect()->route('kelolaKelas.index')
                ->with('success', 'Data kamar ' . $request->class_name . ' berhasil disimpan');
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
            'class_name' => 'required|unique:master_classes,class_name'
        ]);

        try {
            $data = MasterClass::findOrFail($id);
            $data->class_name = $request->class_name;
            $data->update();
            return redirect()->route('kelolaKelas.index')
                ->with('success', 'Data kamar ' . $request->class_name . ' berhasil diupdate');
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
            $data = MasterClass::find($id);
            $data->delete();
            return redirect()->route('kelolaKelas.index')
                ->with('success', 'Data kelas ' . $data->class_name . ' berhasil dihapus');
        } catch (\Exception $e) {
            return back()->withErrors($e);
        }
    }

    //

    public function trash()
    {
        $data = MasterClass::onlyTrashed()->get();
        return view('dashboard.master_data.kelola_kelas.trash', [
            'trash' => $data
        ]);
    }

    public function restore($id)
    {
        try {
            $data = MasterClass::onlyTrashed()->where('id', $id);
            $data->restore();
            return redirect()->route('kelolaKelas.index')->with('success', 'Data berhasil dipulihkan ');
        } catch (\Exception $e) {
            return back()->withErrors($e);
        }
    }
    public function restoreAll()
    {
        try {
            $data = MasterClass::onlyTrashed();
            $data->restore();
            return redirect()->route('kelolaKelas.index')->with('success', 'Data berhasil dipulihkan');
        } catch (\Exception $e) {
            return back()->withErrors($e);
        }
    }
    public function deletePermanent($id)
    {
        try {
            $data = MasterClass::onlyTrashed()->where('id', $id);
            $data->forceDelete();
            return redirect()->route('trashClass')->with('success', 'Data berhasil dihapus permanent');
        } catch (\Exception $e) {
            return back()->withErrors($e);
        }
    }
    public function deletePermanentAll()
    {
        try {
            $data = MasterClass::onlyTrashed();
            $data->forceDelete();
            return redirect()->route('trashClass')->with('success', 'Semua data berhasil dihapus permanent');
        } catch (\Exception $e) {
            return back()->withErrors($e);
        }
    }
}
