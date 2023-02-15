<?php

namespace App\Http\Controllers\Berita;

use App\Http\Controllers\Controller;
use App\Models\MasterNews;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class BeritaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $timLine = MasterNews::orderBy('created_at', 'desc')->get()->groupBy(function ($date) {
            return Carbon::parse($date->created_at)->format('Y-m-d');
        });
        $data = MasterNews::latest()->get();
        return view('dashboard.berita.index', [
            "berita" => $data,
            'timeLine' => $timLine
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
            MasterNews::create(
                [
                    'id_user' => Auth::user()->id,
                    'title' => $request->judul,
                    'description' => $request->keterangan
                ]
            );
            return redirect()->route('beritaAcara.index')
                ->with('success', 'Pengumuman (' . $request->judul . ') berhasil di post');
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
        $data = MasterNews::findOrFail($id);
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
            $berita = MasterNews::findOrFail($id);

            // update data
            $berita->title = $request->judul;
            $berita->description = $request->keterangan;
            $berita->update();

            return redirect()->route('beritaAcara.index')
                ->with('success', 'Pengumuman (' . $request->judul . ') berhasil di update');
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
            $data = MasterNews::find($id);
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
        $data = MasterNews::onlyTrashed()->get();
        return view('dashboard.berita.trash', [
            'trash' => $data
        ]);
    }

    public function restore($id)
    {
        try {
            $data = MasterNews::onlyTrashed()->where('id', $id);
            $data->restore();
            return redirect()->route('beritaAcara.index')->with('success', 'Data berhasil dipulihkan');
        } catch (\Exception $e) {
            return back()->withErrors($e);
        }
    }
    public function restoreAll()
    {
        try {
            $data = MasterNews::onlyTrashed();
            $data->restore();
            return redirect()->route('beritaAcara.index')->with('success', 'Data berhasil dipulihkan');
        } catch (\Exception $e) {
            return back()->withErrors($e);
        }
    }

    public function deletePermanent($id)
    {
        try {
            $data = MasterNews::onlyTrashed()->where('id', $id);
            $data->forceDelete();
            return redirect()->route('trashBeritaAcara')->with('success', 'Data berhasil dihapus permanent');
        } catch (\Exception $e) {
            return back()->withErrors($e);
        }
    }
    public function deletePermanentAll()
    {
        try {
            $data = MasterNews::onlyTrashed();
            $data->forceDelete();
            return redirect()->route('trashBeritaAcara')->with('success', 'Data berhasil dihapus permanent');
        } catch (\Exception $e) {
            return back()->withErrors($e);
        }
    }
}
