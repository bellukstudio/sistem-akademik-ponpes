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
        $request->validate(
            [
                'room_name' => 'required|max:100|unique:master_rooms,room_name',
                'capasity' => 'required|integer',
            ],
            [
                'room_name.required' => 'Nama ruangan harus diisi',
                'room_name.max' => 'Nama ruangan maksimal :max karakter',
                'room_name.unique' => 'Nama ruangan sudah digunakan',
                'capasity.required' => 'Kapasitas ruangan harus diisi',
                'capasity.integer' => 'Kapasitas ruangan harus berupa angka',
            ]
        );


        try {
            MasterRoom::create([
                'room_name' => $request->room_name,
                'capasity' => $request->capasity,
                'type' => 'KAMAR'
            ]);

            return redirect()->route('kelolaKamar.index')
                ->with('success', 'Kamar ' . $request->room_name . ' berhasil disimpan');
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
                'room_name' => 'required|max:100|unique:master_rooms,room_name,' . $id,
                'capasity' => 'required|integer',
            ],
            [
                'room_name.required' => 'Nama ruangan harus diisi',
                'room_name.max' => 'Nama ruangan maksimal :max karakter',
                'room_name.unique' => 'Nama ruangan sudah digunakan',
                'capasity.required' => 'Kapasitas ruangan harus diisi',
                'capasity.integer' => 'Kapasitas ruangan harus berupa angka',
            ]
        );
        try {
            $data = MasterRoom::findOrFail($id);
            $data->room_name = $request->room_name;
            $data->capasity = $request->capasity;
            $data->update();
            return redirect()->route('kelolaKamar.index')
                ->with('success', 'Kamar ' . $request->room_name . ' berhasil diubah');
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
            $data = MasterRoom::find($id);
            $data->delete();
            return back()
                ->with('success', 'Kamar ' . $data->room_name . ' berhasil dihapus');
        } catch (\Exception $e) {
            return back()->with('failed', 'Gagal menghapus data');
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
            $data = MasterRoom::onlyTrashed()->where('id', $id)->firstOrFail();
            $data->restore();
            return redirect()->route('kelolaKamar.index')
                ->with('success', 'Kamar ' . $data->room_name . ' berhasil dipulihkan ');
        } catch (\Exception $e) {
            return back()->with('failed', 'Gagal memulihkan data');
        }
    }
    public function restoreAll()
    {
       

        try {
            $data = MasterRoom::onlyTrashed();
            $data->restore();
            return redirect()->route('kelolaKamar.index')->with('success', 'Data berhasil dipulihkan');
        } catch (\Exception $e) {
            return back()->with('failed', 'Gagal memulihkan data');
        }
    }

    public function deletePermanent($id)
    {
       

        try {
            $data = MasterRoom::onlyTrashed()->where('id', $id)->firstOrFail();
            $data->forceDelete();
            return redirect()->route('trashBedroom')
                ->with('success', 'Kamar ' . $data->room_name . ' berhasil dihapus permanent');
        } catch (\Exception $e) {
            return back()->with('failed', 'Gagal menghapus data');
        }
    }
    public function deletePermanentAll()
    {
       

        try {
            $data = MasterRoom::onlyTrashed();
            $data->forceDelete();
            return redirect()->route('trashBedroom')->with('success', 'Semua data berhasil dihapus permanent');
        } catch (\Exception $e) {
            return back()->with('failed', 'Gagal menghapus data');
        }
    }
}
