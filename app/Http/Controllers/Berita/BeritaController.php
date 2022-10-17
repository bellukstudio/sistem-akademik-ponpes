<?php

namespace App\Http\Controllers\Berita;

use App\Http\Controllers\Controller;
use App\Models\MasterBerita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BeritaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = MasterBerita::latest()->get();
        return view('dashboard.berita.index', [
            "berita" => $data
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.berita.create');
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
            'judul' => 'max:50|required',
            'keterangan' => 'required'
        ]);

        try {
            MasterBerita::create(
                [
                    'id_user' => Auth::user()->id,
                    'judul' => $request->judul,
                    'keterangan' => $request->keterangan
                ]
            );
            return redirect()->route('beritaAcara.index')->with('success', 'Pengumuman terbaru berhasil di post');
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
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = MasterBerita::findOrFail($id);
        return view('dashboard.berita.edit', [
            'berita' => $data
        ]);
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
            'judul' => 'max:50|required',
            'keterangan' => 'required'
        ]);
        try {
            $berita = MasterBerita::findOrFail($id);

            // update data
            $berita->judul = $request->judul;
            $berita->keterangan = $request->keterangan;
            $berita->update();

            return redirect()->route('beritaAcara.index')->with('success', 'Pengumuman berhasil di update');
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
            $data = MasterBerita::find($id);
            $data->delete();
            return redirect()->route('beritaAcara.index')->with('success', 'Data yang dipilih berhasil dihapus');
        } catch (\Exception $e) {
            return back()->withErrors($e);
        }
    }


    /**
     * show data in trash
     */

    public function trash()
    {
        $data = MasterBerita::onlyTrashed()->get();
        return view('dashboard.berita.trash', [
            'trash' => $data
        ]);
    }

    public function restore($id)
    {
        try {
            $data = MasterBerita::onlyTrashed()->where('id', $id);
            $data->restore();
            return redirect()->route('beritaAcara.index')->with('success', 'Data berhasil dipulihkan');
        } catch (\Exception $e) {
            return back()->withErrors($e);
        }
    }
    public function restoreAll()
    {
        try {
            $data = MasterBerita::onlyTrashed();
            $data->restore();
            return redirect()->route('beritaAcara.index')->with('success', 'Data berhasil dipulihkan');
        } catch (\Exception $e) {
            return back()->withErrors($e);
        }
    }

    public function deletePermanent($id)
    {
        try {
            $data = MasterBerita::onlyTrashed()->where('id', $id);
            $data->forceDelete();
            return redirect()->route('trashBeritaAcara')->with('success', 'Data berhasil dihapus permanent');
        } catch (\Exception $e) {
            return back()->withErrors($e);
        }
    }
    public function deletePermanentAll()
    {
        try {
            $data = MasterBerita::onlyTrashed();
            $data->forceDelete();
            return redirect()->route('trashBeritaAcara')->with('success', 'Data berhasil dihapus permanent');
        } catch (\Exception $e) {
            return back()->withErrors($e);
        }
    }
}
