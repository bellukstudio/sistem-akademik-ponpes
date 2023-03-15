<?php

namespace App\Http\Controllers\Master;

use App\Helpers\GoogleDriveHelper;
use App\Http\Controllers\Controller;
use App\Models\MasterProvince;
use App\Models\MasterTeacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use function PHPUnit\Framework\isEmpty;

class ManagePengajarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = MasterTeacher::with(['province', 'city'])->latest()->get();
        return view('dashboard.master_data.kelola_pengajar.index', [
            'pengajar' => $data
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $province = MasterProvince::all();

        return view('dashboard.master_data.kelola_pengajar.create', compact('province'));
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
            'id_number' => 'required|integer|unique:master_teachers,noId',
            'address' => 'required',
            'email' => 'required|email|unique:master_teachers,email',
            'fullName' => 'required|max:100',
            'dateBirth' => 'required|date',
            'gender' => 'required',
            'phone_number' => 'sometimes|integer',
            'province' => 'required',
            'city' => 'required',
            'photo' => 'sometimes|image|max:2048|mimes:png,jpg,jpeg',
        ], [
            'id_number.required' => 'Nomor ID harus diisi.',
            'id_number.unique' => 'Nomor ID sudah terdaftar.',
            'id_number.integer' => 'Nomor ID harus berupa angka.',
            'address.required' => 'Alamat harus diisi.',
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'fullName.required' => 'Nama lengkap harus diisi.',
            'fullName.max' => 'Nama lengkap tidak boleh lebih dari :max karakter.',
            'dateBirth.required' => 'Tanggal lahir harus diisi.',
            'dateBirth.date' => 'Format tanggal lahir tidak valid.',
            'gender.required' => 'Jenis kelamin harus diisi.',
            'phone_number.integer' => 'Nomor telepon harus berupa angka.',
            'province.required' => 'Provinsi harus diisi.',
            'city.required' => 'Kota/kabupaten harus diisi.',
            'photo.image' => 'Foto profil harus berupa gambar.',
            'photo.max' => 'Ukuran foto profil tidak boleh lebih dari :max kilobita.',
            'photo.mimes' => 'Format foto profil harus berupa :values.',
        ]);

        try {
            $upload = null;
            if ($request->file('photo')) {
                $file = $request->file('photo');
                $upload = GoogleDriveHelper::googleDriveFileUpload(
                    $request->id_number . '.png',
                    $file,
                    'TEACHER',
                    GoogleDriveHelper::$img
                );
                // set access file
                if ($upload) {
                    GoogleDriveHelper::allowEveryonePermission($upload);
                } else {
                    return redirect()->back()
                        ->with('error', 'Gagal mengupload foto pengajar.');
                }
            }
            $data = [
                'noId' => $request->id_number,
                'email' => $request->email,
                'name' => $request->fullName,
                'gender' => $request->gender,
                'province_id' => $request->province,
                'city_id' => $request->city,
                'date_birth' => $request->dateBirth,
                'phone' => $request->phone_number,
                'address' => $request->address
            ];
            if ($upload) {
                $data['photo'] = $upload;
            }

            $teacher =  MasterTeacher::create($data);
            if ($teacher) {
                return redirect()->route('kelolaPengajar.index')
                    ->with('success', 'Pengajar ' . $request->fullName . ' berhasil disimpan');
            } else {
                return redirect()->back()
                    ->with('error', 'Gagal menyimpan data pengajar.');
            }
        } catch (\Exception $e) {
            return back()->with('failed', 'Gagal menyimpan data');
        }
    }
    /**
     * get all teachers with json
     */
    public function getAllTeachersCaretakers()
    {
        $empData['data'] = MasterTeacher::whereNotIn('noId', function ($query) {
            $query->select('no_induk')->from('trx_caretakers');
        })->get();

        return response()->json($empData);
    }
    public function getAllTeachers()
    {
        if (Auth::user()->roles_id === 4) {
            abort(403);
        }
        $empData['data'] = MasterTeacher::all();

        return response()->json($empData);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = MasterTeacher::with(['province', 'city'])->findOrFail($id);
        return view('dashboard.master_data.kelola_pengajar.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $province = MasterProvince::all();

        $data = MasterTeacher::findOrFail($id);
        return view('dashboard.master_data.kelola_pengajar.edit', [
            'pengajar' => $data,
            'province' => $province
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
            'id_number' => 'required|integer|unique:master_teachers,noId,' . $id,
            'address' => 'required',
            'email' => 'required|email|unique:master_teachers,email,' . $id,
            'fullName' => 'required|max:100',
            'dateBirth' => 'required|date',
            'gender' => 'required',
            'phone_number' => 'sometimes|integer',
            'province' => 'required',
            'city' => 'required',
            'photo' => 'sometimes|image|max:2048|mimes:png,jpg,jpeg',
        ], [
            'id_number.required' => 'Nomor ID harus diisi.',
            'id_number.unique' => 'Nomor ID sudah terdaftar.',
            'id_number.integer' => 'Nomor ID harus berupa angka.',
            'address.required' => 'Alamat harus diisi.',
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'fullName.required' => 'Nama lengkap harus diisi.',
            'fullName.max' => 'Nama lengkap tidak boleh lebih dari :max karakter.',
            'dateBirth.required' => 'Tanggal lahir harus diisi.',
            'dateBirth.date' => 'Format tanggal lahir tidak valid.',
            'gender.required' => 'Jenis kelamin harus diisi.',
            'phone_number.integer' => 'Nomor telepon harus berupa angka.',
            'province.required' => 'Provinsi harus diisi.',
            'city.required' => 'Kota/kabupaten harus diisi.',
            'photo.image' => 'Foto profil harus berupa gambar.',
            'photo.max' => 'Ukuran foto profil tidak boleh lebih dari :max kilobita.',
            'photo.mimes' => 'Format foto profil harus berupa :values.',
        ]);
        try {
            $data = MasterTeacher::findOrFail($id);
            if ($request->file('photo')) {
                $file = $request->file('photo');
                if ($data->photo == null) {
                    $uploadNewPhoto = GoogleDriveHelper::googleDriveFileUpload(
                        $request->id_number . '.png',
                        $file,
                        'TEACHER',
                        GoogleDriveHelper::$img
                    );

                    $data->photo = $uploadNewPhoto;
                    sleep(1);
                    // set access file
                    GoogleDriveHelper::allowEveryonePermission($uploadNewPhoto);
                }
                if ($data->photo != null) {
                    //delete file
                    $fileName = $data->noId . '.png';
                    GoogleDriveHelper::deleteFile($fileName, GoogleDriveHelper::$img);
                    sleep(3);
                    //upload new file
                    $uploadOrReplaceOldPhoto = GoogleDriveHelper::googleDriveFileUpload(
                        $request->id_number . '.png',
                        $file,
                        'TEACHER',
                        GoogleDriveHelper::$img
                    );

                    $data->photo = $uploadOrReplaceOldPhoto;
                    // set access file
                    sleep(1);
                    GoogleDriveHelper::allowEveryonePermission($uploadOrReplaceOldPhoto);
                }
            }

            if ($data->photo != null) {
                // rename img
                $fileName = $request->id_number . '.png';
                GoogleDriveHelper::renameFile($data->photo, $fileName);
            }
            $data->noId = $request->id_number;
            $data->email = $request->email;
            $data->name = $request->fullName;
            $data->gender = $request->gender;
            $data->province_id = $request->province;
            $data->city_id = $request->city;
            $data->date_birth = $request->dateBirth;
            $data->phone = $request->phone_number;
            $data->address = $request->address;
            $data->update();


            return redirect()->route('kelolaPengajar.index')
                ->with('success', 'Pengajar ' . $request->fullName . ' berhasil diubah');
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
            $data = MasterTeacher::find($id);
            /// remove  photo
            if ($data->photo != null) {
                $fileName = $data->noId . '.png';
                GoogleDriveHelper::deleteFile($fileName, GoogleDriveHelper::$img);
                $data->photo = null;
                $data->update();
            }

            $data->delete();
            return redirect()->route('kelolaPengajar.index')
                ->with('success', 'Pengajar ' . $data->name . ' berhasil dihapus');
        } catch (\Exception $e) {
            return back()->withErrors($e);
        }
    }

    public function trash()
    {
        if (auth()->user()->roles_id != 1) {
            abort(403);
        }
        $data = MasterTeacher::with(['province', 'city'])->onlyTrashed()->get();
        return view('dashboard.master_data.kelola_pengajar.trash', [
            'trash' => $data
        ]);
    }

    public function restore($id)
    {
        try {
            $data = MasterTeacher::onlyTrashed()->where('id', $id)->firstOrFail();
            $data->restore();
            return redirect()->route('kelolaPengajar.index')
                ->with('success', 'Pengajar ' . $data->name . ' berhasil dipulihkan ');
        } catch (\Exception $e) {
            return back()->with('failed', 'Gagal memulihkan data');
        }
    }
    public function restoreAll()
    {
        try {
            $data = MasterTeacher::onlyTrashed();
            $data->restore();
            return redirect()->route('kelolaPengajar.index')->with('success', 'Semua Data berhasil dipulihkan');
        } catch (\Exception $e) {
            return back()->with('failed', 'Gagal memulihkan data');
        }
    }

    public function deletePermanent($id)
    {
        try {
            $data = MasterTeacher::onlyTrashed()->where('id', $id)->firstOrFail();
            $data->forceDelete();
            return redirect()->route('trashTeachers')
                ->with('success', 'Pengajar ' . $data->name . ' berhasil dihapus permanent');
        } catch (\Exception $e) {
            return back()->with('failed', 'Gagal menghapus data');
        }
    }
    public function deletePermanentAll()
    {
        try {
            $data = MasterTeacher::onlyTrashed();
            $data->forceDelete();
            return redirect()->route('trashTeachers')->with('success', 'Semua data berhasil dihapus permanent');
        } catch (\Exception $e) {
            return back()->with('failed', 'Gagal menghapus data');
        }
    }
}
