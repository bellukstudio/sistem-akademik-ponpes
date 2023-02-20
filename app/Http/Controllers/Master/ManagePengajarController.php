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
            'id_number' => 'required|integer',
            'address' => 'required',
            'email' => 'required|email:dns|unique:master_teachers',
            'fullName' => 'required|max:100',
            'dateBirth' => 'required|date',
            'gender' => 'required',
            'phone_number' => 'sometimes|integer',
            'province' => 'required',
            'city' => 'required',
            'photo' => 'sometimes|image|max:2048|mimes:png,jpg,jpeg',
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
                GoogleDriveHelper::allowEveryonePermission($upload);
            }
            MasterTeacher::create([
                'noId' => $request->id_number,
                'email' => $request->email,
                'name' => $request->fullName,
                'photo' => $upload,
                'gender' => $request->gender,
                'province_id' => $request->province,
                'city_id' => $request->city,
                'date_birth' => $request->dateBirth,
                'no_tlp' => $request->phone_number,
                'address' => $request->address
            ]);

            return redirect()->route('kelolaPengajar.index')
                ->with('success', 'Pengajar ' . $request->fullName . ' berhasil disimpan');
        } catch (\Exception $e) {
            return back()->withErrors($e);
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
            'id_number' => 'required|integer',
            'address' => 'required',
            'email' => 'required|email:dns',
            'fullName' => 'required|max:100',
            'dateBirth' => 'required|date',
            'gender' => 'required',
            'phone_number' => 'sometimes|integer',
            'province' => 'required',
            'city' => 'required',
            'photo' => 'sometimes|image|max:2048|mimes:png,jpg,jpeg',
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
                        $request->noId . '.png',
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
            $data->no_tlp = $request->phone_number;
            $data->address = $request->address;
            $data->update();


            return redirect()->route('kelolaPengajar.index')
                ->with('success', 'Pengajar ' . $request->fullName . ' berhasil diubah');
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
        $this->authorize('admin');
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
            return back()->withErrors($e);
        }
    }
    public function restoreAll()
    {
        try {
            $data = MasterTeacher::onlyTrashed();
            $data->restore();
            return redirect()->route('kelolaPengajar.index')->with('success', 'Semua Data berhasil dipulihkan');
        } catch (\Exception $e) {
            return back()->withErrors($e);
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
            return back()->withErrors($e);
        }
    }
    public function deletePermanentAll()
    {
        try {
            $data = MasterTeacher::onlyTrashed();
            $data->forceDelete();
            return redirect()->route('trashTeachers')->with('success', 'Semua data berhasil dihapus permanent');
        } catch (\Exception $e) {
            return back()->withErrors($e);
        }
    }
}
