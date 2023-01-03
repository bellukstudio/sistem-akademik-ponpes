<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\MasterRoom;
use App\Models\MasterStudent;
use App\Models\MasterTeacher;
use App\Models\TrxCaretakers;
use Illuminate\Http\Request;

class ManagePengurusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = TrxCaretakers::with(['room'])->latest()->get();

        return view('dashboard.master_data.kelola_pengurus.index', [
            'pengurus' => $data
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $room = MasterRoom::where('type','KAMAR')->whereNotIn('id', function ($query) {
            $query->select('id_room')->from('trx_caretakers');
        })->get();
        return view('dashboard.master_data.kelola_pengurus.create', [
            'room' => $room
        ]);
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
            'categories' => 'required',
            'dataList' => 'required',
            'id_number' => 'required',
            'fullName' => 'required',
            'room' => 'required'
        ]);

        try {
            TrxCaretakers::create([
                'no_induk' => $request->id_number,
                'name' => $request->fullName,
                'categories' => $request->categories,
                'id_room' => $request->room
            ]);
            return redirect()->route('kelolaPengurus.index')
                ->with('success', 'Pengurus ' . $request->fullName . ' berhasil disimpan');
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
        $data = TrxCaretakers::find($id);
        $room = MasterRoom::where('type', 'KAMAR')->get();

        return view('dashboard.master_data.kelola_pengurus.edit', compact('data', 'room'));
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
            'categories' => 'required',
            'id_number' => 'required',
            'fullName' => 'required',
            'room' => 'required'
        ]);

        try {
            $data = TrxCaretakers::find($id);
            $data->categories = $request->categories;
            $data->no_induk = $request->id_number;
            $data->name = $request->fullName;
            $data->id_room = $request->room;
            $data->update();
            return redirect()->route('kelolaPengurus.index')
                ->with('success', 'Pengurus ' . $request->fullName . ' berhasil diubah');
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
            $data = TrxCaretakers::find($id);
            $data->delete();
            return redirect()->route('kelolaPengurus.index')
                ->with('success', 'Pengurus ' . $data->name . ' berhasil disimpan');
        } catch (\Exception $e) {
            return back()->withErrors($e);
        }
    }

    public function trash()
    {
        $this->authorize('admin');

        $data = TrxCaretakers::with(['room'])->onlyTrashed()->get();
        return view('dashboard.master_data.kelola_pengurus.trash', [
            'trash' => $data
        ]);
    }

    public function restore($id)
    {
        try {
            $data = TrxCaretakers::onlyTrashed()->where('id', $id)->firstOrFail();
            $data->restore();
            return redirect()->route('kelolaPengurus.index')
                ->with('success', 'Pengurus ' . $data->name . ' berhasil dipulihkan ');
        } catch (\Exception $e) {
            return back()->withErrors($e);
        }
    }
    public function restoreAll()
    {
        try {
            $data = TrxCaretakers::onlyTrashed();
            $data->restore();
            return redirect()->route('kelolaPengurus.index')->with('success', 'Data berhasil dipulihkan');
        } catch (\Exception $e) {
            return back()->withErrors($e);
        }
    }

    public function deletePermanent($id)
    {
        try {
            $data = TrxCaretakers::onlyTrashed()->where('id', $id)->firstOrFail();
            $data->forceDelete();
            return redirect()->route('trashCaretakers')
                ->with('success', 'Pengurus ' . $data->name . ' berhasil dihapus permanent');
        } catch (\Exception $e) {
            return back()->withErrors($e);
        }
    }
    public function deletePermanentAll()
    {
        try {
            $data = TrxCaretakers::onlyTrashed();
            $data->forceDelete();
            return redirect()->route('trashCaretakers')->with('success', 'Semua data berhasil dihapus permanent');
        } catch (\Exception $e) {
            return back()->withErrors($e);
        }
    }
}
