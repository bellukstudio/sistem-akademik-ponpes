<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\MasterProgram;
use Illuminate\Http\Request;

class ManageProgramController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = MasterProgram::latest()->get();
        return view(
            'dashboard.master_data.kelola_program.index',
            [
                'program' => $data
            ]
        );
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
            'kode' => 'required|max:50',
            'nama_program' => 'required|max:100'
        ]);
        try {
            MasterProgram::create(
                [
                    'kode' => $request->kode,
                    'nama_program' => $request->nama_program
                ]
            );
            return redirect()->route('manageProgram.index')
                ->with('success', 'Data (' . $request->nama_program . ') berhasil di tambahkan');
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
            'kode' => 'required|max:50',
            'nama_program' => 'required|max:100'
        ]);
        try {
            $data = MasterProgram::findOrfail($id);
            $data->kode = $request->kode;
            $data->nama_program = $request->nama_program;
            $data->update();
            return redirect()->route('manageProgram.index')
                ->with('success', 'Data (' . $request->nama_program . ') berhasil di update');
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
            $data = MasterProgram::find($id);
            $data->delete();
            return redirect()->route('manageProgram.index')
                ->with('success', 'Data berhasil di hapus');
        } catch (\Exception $e) {
            return back()->withErrors($e);
        }
    }

    public function trash()
    {
        $data = MasterProgram::onlyTrashed()->get();
        return view('dashboard.master_data.kelola_program.trash', [
            'trash' => $data
        ]);
    }

    public function restore($id)
    {
        try {
            $data = MasterProgram::onlyTrashed()->where('id', $id);
            $data->restore();
            return redirect()->route('manageProgram.index')->with('success', 'Data berhasil dipulihkan ');
        } catch (\Exception $e) {
            return back()->withErrors($e);
        }
    }
    public function restoreAll()
    {
        try {
            $data = MasterProgram::onlyTrashed();
            $data->restore();
            return redirect()->route('manageProgram.index')->with('success', 'Data berhasil dipulihkan');
        } catch (\Exception $e) {
            return back()->withErrors($e);
        }
    }

    public function deletePermanent($id)
    {
        try {
            $data = MasterProgram::onlyTrashed()->where('id', $id);
            $data->forceDelete();
            return redirect()->route('trashProgram')->with('success', 'Data berhasil dihapus permanent');
        } catch (\Exception $e) {
            return back()->withErrors($e);
        }
    }
    public function deletePermanentAll()
    {
        try {
            $data = MasterProgram::onlyTrashed();
            $data->forceDelete();
            return redirect()->route('trashProgram')->with('success', 'Semua data berhasil dihapus permanent');
        } catch (\Exception $e) {
            return back()->withErrors($e);
        }
    }
}
