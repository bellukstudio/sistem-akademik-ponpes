<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\MasterRoom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Helpers\GoogleDriveHelper;

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
        $request->validate(
            [
                'room_name' => 'required|max:100|unique:master_rooms,room_name',
                'capasity' => 'required|integer',
                'photo' => 'sometimes|image|max:2048|mimes:png,jpg,jpeg'
            ],
            [
                'room_name.required' => 'Nama ruangan harus diisi',
                'room_name.max' => 'Nama ruangan maksimal :max karakter',
                'room_name.unique' => 'Nama ruangan sudah digunakan',
                'capasity.required' => 'Kapasitas ruangan harus diisi',
                'capasity.integer' => 'Kapasitas ruangan harus berupa angka',
                'photo.image' => 'Foto harus dalam format gambar',
                'photo.max' => 'Ukuran foto maksimal :max KB',
                'photo.mimes' => 'Foto harus dalam format :values'
            ]
        );


        try {
            $upload = null;
            if ($request->file('photo')) {
                $file = $request->file('photo');
                $upload =  GoogleDriveHelper::googleDriveFileUpload(
                    $request->room_name . '.png',
                    $file,
                    'ROOM',
                    GoogleDriveHelper::$img
                );
            }
            MasterRoom::create(
                [
                    'room_name' => $request->room_name,
                    'capasity' => $request->capasity,
                    'type' => 'RUANGAN',
                    'photo' => $upload
                ]
            );

            return redirect()->route('kelolaRuangan.index')
                ->with('success', 'Ruangan ' . $request->room_name . ' berhasil disimpan');
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
                'photo' => 'sometimes|image|max:2048|mimes:png,jpg,jpeg'
            ],
            [
                'room_name.required' => 'Nama ruangan harus diisi',
                'room_name.max' => 'Nama ruangan maksimal :max karakter',
                'room_name.unique' => 'Nama ruangan sudah digunakan',
                'capasity.required' => 'Kapasitas ruangan harus diisi',
                'capasity.integer' => 'Kapasitas ruangan harus berupa angka',
                'photo.image' => 'Foto harus dalam format gambar',
                'photo.max' => 'Ukuran foto maksimal :max KB',
                'photo.mimes' => 'Foto harus dalam format :values'
            ]
        );
        try {
            $data = MasterRoom::findOrFail($id);
            if ($request->file('photo')) {
                $file = $request->file('photo');
                if (isEmpty($data->photo)) {
                    //new file
                    $upload =  GoogleDriveHelper::googleDriveFileUpload(
                        $request->room_name . '.png',
                        $file,
                        'ROOM',
                        GoogleDriveHelper::$img
                    );
                    $data->photo = $upload;
                } else {
                    //delete file
                    GoogleDriveHelper::deleteFile($data->room_name, GoogleDriveHelper::$img);
                    //new file
                    $upload =  GoogleDriveHelper::googleDriveFileUpload(
                        $request->room_name . '.png',
                        $file,
                        'ROOM',
                        GoogleDriveHelper::$img
                    );
                    $data->photo = $upload;
                }
            }

            if ($data->photo != null) {
                // rename img
                $fileName = $request->room_name . '.png';
                GoogleDriveHelper::renameFile($data->photo, $fileName);
            }

            $data->room_name = $request->room_name;
            $data->capasity = $request->capasity;
            $data->update();

            return redirect()->route('kelolaRuangan.index')
                ->with('success', 'Ruangan ' . $request->room_name . ' berhasil diubah');
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
            // delete file
            $data = MasterRoom::find($id);
            //delete image
            if ($data->photo != null) {
                $fileName = $data->room_name . '.png';
                GoogleDriveHelper::deleteFile($fileName, GoogleDriveHelper::$img);
                $data->photo = null;
                $data->update();
            }
            $data->delete();
            return redirect()->route('kelolaRuangan.index')
                ->with('success', 'Ruangan ' . $data->room_name . ' berhasil dihapus');
        } catch (\Exception $e) {
            return back()->with('failed', 'Gagal menghapus data');
        }
    }

    public function trash()
    {
        $this->authorize('admin');
        $data = MasterRoom::where('type', 'RUANGAN')->onlyTrashed()->get();
        return view('dashboard.master_data.kelola_ruangan.trash', [
            'trash' => $data
        ]);
    }

    public function restore($id)
    {
        try {
            $data = MasterRoom::onlyTrashed()->find($id);
            $data->restore();
            return redirect()->route('kelolaRuangan.index')
                ->with('success', 'Ruangan ' . $data->room_name . ' berhasil dipulihkan ');
        } catch (\Exception $e) {
            return back()->with('failed', 'Gagal memulihkan data');
        }
    }
    public function restoreAll()
    {
        try {
            $data = MasterRoom::onlyTrashed();
            $data->restore();
            return redirect()->route('kelolaRuangan.index')->with('success', 'Data berhasil dipulihkan');
        } catch (\Exception $e) {
            return back()->with('failed', 'Gagal memulihkan data');
        }
    }

    public function deletePermanent($id)
    {
        try {
            $data = MasterRoom::onlyTrashed()->find($id);
            $data->forceDelete();
            return redirect()->route('trashRoom')
                ->with('success', 'Ruangan' . $data->room_name . ' berhasil dihapus permanent');
        } catch (\Exception $e) {
            return back()->with('failed', 'Gagal menghapus data');
        }
    }
    public function deletePermanentAll()
    {
        try {
            $data = MasterRoom::onlyTrashed();
            $data->forceDelete();
            return redirect()->route('trashRoom')->with('success', 'Semua data berhasil dihapus permanent');
        } catch (\Exception $e) {
            return back()->with('failed', 'Gagal menghapus data');
        }
    }
}
