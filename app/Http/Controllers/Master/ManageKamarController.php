<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\MasterRoom;
use Illuminate\Http\Request;

class ManageKamarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = MasterRoom::where('type', 'kamar')->latest()->get();
        return view('dashboard.master_data.kelola_kamar.index', [
            'kamar' => $data
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
            'room_name' => 'required|max:50|unique:master_rooms,room_name',
            'capasity' => 'required|integer'
        ]);

        try {
            MasterRoom::create([
                'room_name' => $request->room_name,
                'capasity' => $request->capasity,
                'type' => 'KAMAR'
            ]);

            return redirect()->route('kelolaKamar.index')
                ->with('success', 'Data kamar ' . $request->room_name . ' berhasil di simpan');
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
            'room_name' => 'required|max:50',
            'capasity' => 'required|integer'
        ]);

        try {
            $data = MasterRoom::findOrFail($id);
            $data->room_name = $request->room_name;
            $data->capasity = $request->capasity;
            $data->update();
            return redirect()->route('kelolaKamar.index')
                ->with('success', 'Data kamar ' . $request->room_name . ' berhasil di ubah');
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
            $data = MasterRoom::find($id);
            $data->delete();
            return back()
                ->with('success', 'Data kamar ' . $data->room_name . ' berhasil dihapus');
        } catch (\Exception $e) {
            return back()->withErrors($e);
        }
    }

    public function trash()
    {
        $data = MasterRoom::onlyTrashed()->get();
        return view('dashboard.master_data.kelola_kamar.trash', [
            'trash' => $data
        ]);
    }

    public function restore($id)
    {
        try {
            $data = MasterRoom::onlyTrashed()->where('id', $id);
            $data->restore();
            return redirect()->route('kelolaKamar.index')
                ->with('success', 'Data ' . $data->room_name . ' berhasil dipulihkan ');
        } catch (\Exception $e) {
            return back()->withErrors($e);
        }
    }
    public function restoreAll()
    {
        try {
            $data = MasterRoom::onlyTrashed();
            $data->restore();
            return redirect()->route('kelolaKamar.index')->with('success', 'Data berhasil dipulihkan');
        } catch (\Exception $e) {
            return back()->withErrors($e);
        }
    }

    public function deletePermanent($id)
    {
        try {
            $data = MasterRoom::onlyTrashed()->where('id', $id);
            $data->forceDelete();
            return redirect()->route('trashBedroom')
                ->with('success', 'Data ' . $data->room_name . ' berhasil dihapus permanent');
        } catch (\Exception $e) {
            return back()->withErrors($e);
        }
    }
    public function deletePermanentAll()
    {
        try {
            $data = MasterRoom::onlyTrashed();
            $data->forceDelete();
            return redirect()->route('trashBedroom')->with('success', 'Semua data berhasil dihapus permanent');
        } catch (\Exception $e) {
            return back()->withErrors($e);
        }
    }
}
