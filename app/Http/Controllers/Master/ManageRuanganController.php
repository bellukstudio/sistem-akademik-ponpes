<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\MasterRoom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

use function PHPUnit\Framework\isEmpty;

class ManageRuanganController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = MasterRoom::where('type', 'RUANGAN')->latest()->get();
        return view('dashboard.master_data.kelola_ruangan.index', [
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
            'room_name' => 'required|max:100|unique:master_rooms,room_name',
            'capasity' => 'required|integer',
            'photo' => 'image|max:2048|mimes:png,jpg,jpeg'
        ]);

        try {
            if ($request->file('photo')) {
                $file = $request->file('photo')->store('assets/rooms', 'public');
                $request->photo = $file;
            }
            MasterRoom::create(
                [
                    'room_name' => $request->room_name,
                    'capasity' => $request->capasity,
                    'type' => 'RUANGAN',
                    'photo' => $request->photo
                ]
            );

            return redirect()->route('kelolaRuangan.index')
                ->with('success', 'Data ruangan ' . $request->room_name . ' berhasil disimpan');
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
            'room_name' => 'required|max:100',
            'capasity' => 'required|integer',
            'photo' => 'image|max:2048|mimes:png,jpg,jpeg'
        ]);

        try {
            $data = MasterRoom::findOrFail($id);

            if ($request->file('photo')) {
                $file = $request->file('photo')->store('assets/rooms', 'public');
                $request->photo = $file;

                if (!isEmpty($data->photo)) {
                    // explode url image
                    $img = explode('/', $data->photo);
                    $path = $img[3] . '/' . $img[4] . '/' . $img[5] . '/' . $img[6];
                    unlink($path);
                }
            }
            $data->room_name = $request->room_name;
            $data->capasity = $request->capasity;
            $data->photo = $request->photo;
            $data->update();
            return redirect()->route('kelolaRuangan.index')
                ->with('success', 'Data ruangan ' . $request->room_name . ' berhasil diubah');
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
            return redirect()->route('kelolaRuangan.index')
                ->with('success', 'Data ruangan  berhasil dihapus');
        } catch (\Exception $e) {
            return back()->withErrors($e);
        }
    }

    public function trash()
    {
        $data = MasterRoom::where('type', 'RUANGAN')->onlyTrashed()->get();
        return view('dashboard.master_data.kelola_ruangan.trash', [
            'trash' => $data
        ]);
    }

    public function restore($id)
    {
        try {
            $data = MasterRoom::onlyTrashed()->where('id', $id);
            $data->restore();
            return redirect()->route('kelolaRuangan.index')->with('success', 'Data berhasil dipulihkan ');
        } catch (\Exception $e) {
            return back()->withErrors($e);
        }
    }
    public function restoreAll()
    {
        try {
            $data = MasterRoom::onlyTrashed();
            $data->restore();
            return redirect()->route('kelolaRuangan.index')->with('success', 'Data berhasil dipulihkan');
        } catch (\Exception $e) {
            return back()->withErrors($e);
        }
    }

    public function deletePermanent($id)
    {
        try {
            $data = MasterRoom::onlyTrashed()->find($id);
            $img = explode('/', $data->photo);
            $path = $img[3] . '/' . $img[4] . '/' . $img[5] . '/' . $img[6];
            if (File::exists($path)) {
                unlink($path);
            }
            $data->forceDelete();
            return redirect()->route('trashRoom')->with('success', 'Data berhasil dihapus permanent');
        } catch (\Exception $e) {
            return back()->withErrors($e);
        }
    }
    public function deletePermanentAll()
    {
        try {
            $data = MasterRoom::onlyTrashed();
            $data->forceDelete();
            return redirect()->route('trashRoom')->with('success', 'Semua data berhasil dihapus permanent');
        } catch (\Exception $e) {
            return back()->withErrors($e);
        }
    }
}
