<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\MasterProvince;
use App\Models\MasterTeacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

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
            if ($request->file('photo')) {
                $file = $request->file('photo')->store('assets/teachers', 'public');
                $request->photo = $file;
            }
            MasterTeacher::create([
                'no_id' => $request->id_number,
                'email' => $request->email,
                'name' => $request->fullName,
                'photo' => $request->photo,
                'gender' => $request->gender,
                'province_id' => $request->province,
                'city_id' => $request->city,
                'date_birth' => $request->dateBirth,
                'no_tlp' => $request->phone_number,
                'address' => $request->address
            ]);

            return redirect()->route('kelolaPengajar.index')
                ->with('success', 'Data Pengajar ' . $request->fullName . ' berhasil disimpan');
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
            $photo = $data->photo;
            if ($request->file('photo')) {
                $file = $request->file('photo')->store('assets/teachers', 'public');
                $request->photo = $file;

                $data->no_id = $request->id_number;
                $data->email = $request->email;
                $data->name = $request->fullName;
                $data->photo = $request->photo;
                $data->gender = $request->gender;
                $data->province_id = $request->province;
                $data->city_id = $request->city;
                $data->date_birth = $request->dateBirth;
                $data->no_tlp = $request->phone_number;
                $data->address = $request->address;
                $data->update();

                /// remove old photo
                if ($photo != 'http://localhost:8000/storage/') {
                    $img = explode('/', $photo);
                    $path = $img[3] . '/' . $img[4] . '/' . $img[5] . '/' . $img[6];
                    if (File::exists($path)) {
                        unlink($path);
                    }
                }
            } else {
                $data->no_id = $request->id_number;
                $data->email = $request->email;
                $data->name = $request->fullName;
                $data->gender = $request->gender;
                $data->province_id = $request->province;
                $data->city_id = $request->city;
                $data->date_birth = $request->dateBirth;
                $data->no_tlp = $request->phone_number;
                $data->address = $request->address;
                $data->update();
            }


            return redirect()->route('kelolaPengajar.index')
                ->with('success', 'Data Pengajar ' . $request->fullName . ' berhasil diubah');
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
            if ($data->photo != 'http://localhost:8000/storage/') {
                $img = explode('/', $data->photo);
                $path = $img[3] . '/' . $img[4] . '/' . $img[5] . '/' . $img[6];
                if (File::exists($path)) {
                    $data->photo = null;
                    $data->update();
                }
            }

            $data->delete();
            return redirect()->route('kelolaPengajar.index')
                ->with('success', 'Data Pengajar ' . $data->name . ' berhasil dihapus');
        } catch (\Exception $e) {
            return back()->withErrors($e);
        }
    }

    public function trash()
    {
        $data = MasterTeacher::with(['province', 'city'])->onlyTrashed()->get();
        return view('dashboard.master_data.kelola_pengajar.trash', [
            'trash' => $data
        ]);
    }

    public function restore($id)
    {
        try {
            $data = MasterTeacher::onlyTrashed()->where('id', $id);
            $data->restore();
            return redirect()->route('kelolaPengajar.index')->with('success', 'Data berhasil dipulihkan ');
        } catch (\Exception $e) {
            return back()->withErrors($e);
        }
    }
    public function restoreAll()
    {
        try {
            $data = MasterTeacher::onlyTrashed();
            $data->restore();
            return redirect()->route('kelolaPengajar.index')->with('success', 'Data berhasil dipulihkan');
        } catch (\Exception $e) {
            return back()->withErrors($e);
        }
    }

    public function deletePermanent($id)
    {
        try {
            $data = MasterTeacher::onlyTrashed()->where('id', $id);
            $data->forceDelete();
            return redirect()->route('trashTeachers')->with('success', 'Data berhasil dihapus permanent');
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
