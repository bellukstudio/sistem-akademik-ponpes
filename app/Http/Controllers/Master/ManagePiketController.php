<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\MasterPicket;
use Illuminate\Http\Request;

class ManagePiketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $picket = MasterPicket::latest()->get();
        return view('dashboard.master_data.kategori_piket.index', compact('picket'));
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
            'picket' => 'required|max:100'
        ], [
            'picket.required' => 'Kolom nama piket harus diisi',
            'picket.max' => 'Kolom nama piket maksimal 100 karakter'
        ]);

        try {
            MasterPicket::create(
                [
                    'name' => $request->picket
                ]
            );

            return back()->with('success', 'Berhasil menambah data ' . $request->picket);
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
            'picket' => 'required|max:100'
        ], [
            'picket.required' => 'Kolom nama piket harus diisi',
            'picket.max' => 'Kolom nama piket maksimal 100 karakter'
        ]);

        try {
            $data = MasterPicket::find($id);
            $data->name = $request->picket;
            $data->update();

            return back()->with('success', 'Berhasil mengubah data ' . $request->picket);
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
            $data = MasterPicket::find($id);
            $data->delete();

            return back()->with('success', 'Berhasil menghapus data ' . $data->name);
        } catch (\Exception $e) {
            return back()->with('failed', 'Gagal menghapus data');
        }
    }

    public function trash()
    {
       
        $data = MasterPicket::onlyTrashed()->get();
        return view('dashboard.master_data.kategori_piket.trash', [
            'trash' => $data
        ]);
    }

    public function restore($id)
    {
       

        try {
            $data = MasterPicket::onlyTrashed()->where('id', $id)->firstOrFail();
            $data->restore();
            return redirect()->route('kategoriPiket.index')
                ->with('success', 'Kelas ' . $data->name . ' berhasil dipulihkan ');
        } catch (\Exception $e) {
            return back()->with('failed', 'Gagal memulihkan data');
        }
    }
    public function restoreAll()
    {
       

        try {
            $data = MasterPicket::onlyTrashed();
            $data->restore();
            return redirect()->route('kategoriPiket.index')->with('success', 'Data berhasil dipulihkan');
        } catch (\Exception $e) {
            return back()->with('failed', 'Gagal memulihkan data');
        }
    }
    public function deletePermanent($id)
    {
       

        try {
            $data = MasterPicket::onlyTrashed()->where('id', $id)->firstOrFail();
            $data->forceDelete();
            return redirect()->route('trashPicketCategories')
                ->with('success', 'Kelas ' . $data->name . ' berhasil dihapus permanent');
        } catch (\Exception $e) {
            return back()->with('failed', 'Gagal menghapus data');
        }
    }
    public function deletePermanentAll()
    {
       

        try {
            $data = MasterPicket::onlyTrashed();
            $data->forceDelete();
            return redirect()->route('trashPicketCategories')->with('success', 'Semua data berhasil dihapus permanent');
        } catch (\Exception $e) {
            return back()->with('failed', 'Gagal menghapus data');
        }
    }
}
