<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\MasterAcademicProgram;
use App\Models\MasterPeriod;
use App\Models\MasterStudent;
use Illuminate\Http\Request;
use App\Models\MasterProvince;
use Illuminate\Support\Facades\File;

class ManageSantriController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $santri = MasterStudent::with(['province', 'city', 'program', 'period'])->latest()->get();

        return view('dashboard.master_data.kelola_santri.index', compact('santri'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $province = MasterProvince::all();
        $program = MasterAcademicProgram::all();
        $periode = MasterPeriod::where('status', 1)->get();
        return view('dashboard.master_data.kelola_santri.create', compact('province', 'program', 'periode'));
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
            'student_parent' => 'required|max:100',
            'program' => 'required',
            'period' => 'required',
            'province' => 'required',
            'city' => 'required',
            'photo' => 'sometimes|image|max:2048|mimes:png,jpg,jpeg',
        ]);

        try {
            if ($request->file('photo')) {
                $file = $request->file('photo')->store('assets/students', 'public');
                $request->photo = $file;
            }

            MasterStudent::create([
                'no_id' => $request->id_number,
                'email' => $request->email,
                'name' => $request->fullName,
                'photo' => $request->photo,
                'gender' => $request->gender,
                'address' => $request->address,
                'province_id' => $request->province,
                'city_id' => $request->city,
                'date_birth' => $request->dateBirth,
                'student_parent' => $request->student_parent,
                'no_tlp' => $request->phone_number,
                'program_id' => $request->program,
                'period_id' => $request->period
            ]);
            return redirect()->route('kelolaSantri.index')
                ->with('success', 'Data Santri ' . $request->fullName . ' berhasil disimpan');
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
        $data = MasterStudent::with(['province', 'city', 'program', 'period'])->findOrFail($id);
        return view('dashboard.master_data.kelola_santri.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = MasterStudent::find($id);
        $program = MasterAcademicProgram::all();
        $periode = MasterPeriod::where('status', 1)->get();
        $province = MasterProvince::all();

        return view('dashboard.master_data.kelola_santri.edit', [
            'santri' => $data,
            'program' => $program,
            'periode' => $periode,
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
            'email' => 'required|email:dns|unique:master_teachers',
            'fullName' => 'required|max:100',
            'dateBirth' => 'required|date',
            'gender' => 'required',
            'phone_number' => 'sometimes|integer',
            'student_parent' => 'required|max:100',
            'program' => 'required',
            'period' => 'required',
            'province' => 'required',
            'city' => 'required',
            'photo' => 'sometimes|image|max:2048|mimes:png,jpg,jpeg',
        ]);

        try {
            $data = MasterStudent::find($id);
            $photo = $data->photo;
            if ($request->file('photo')) {
                $file = $request->file('photo')->store('assets/students', 'public');
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
                $data->student_parent = $request->student_parent;
                $data->program_id = $request->program;
                $data->period_id = $request->period;
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
                $data->student_parent = $request->student_parent;
                $data->program_id = $request->program;
                $data->period_id = $request->period;
                $data->update();
            }
            return redirect()->route('kelolaSantri.index')
                ->with('success', 'Data Santri ' . $request->fullName . ' berhasil diubah');
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
            $data = MasterStudent::find($id);
            /// remove  photo
            if ($data->photo != 'http://localhost:8000/storage/') {
                $img = explode('/', $data->photo);
                $path = $img[3] . '/' . $img[4] . '/' . $img[5] . '/' . $img[6];
                if (File::exists($path)) {
                    unlink($path);
                    $data->photo = null;
                    $data->update();
                }
            }

            $data->delete();
            return redirect()->route('kelolaSantri.index')
                ->with('success', 'Data Santri ' . $data->name . ' berhasil dihapus');
        } catch (\Exception $e) {
            return back()->withErrors($e);
        }
    }

    public function trash()
    {
        $data = MasterStudent::with(['province', 'city', 'program', 'period'])->onlyTrashed()->get();
        return view('dashboard.master_data.kelola_santri.trash', [
            'trash' => $data
        ]);
    }

    public function restore($id)
    {
        try {
            $data = MasterStudent::onlyTrashed()->where('id', $id)->firstOrFail();
            $data->restore();
            return redirect()->route('kelolaSantri.index')
                ->with('success', 'Data ' . $data->name . ' berhasil dipulihkan ');
        } catch (\Exception $e) {
            return back()->withErrors($e);
        }
    }
    public function restoreAll()
    {
        try {
            $data = MasterStudent::onlyTrashed();
            $data->restore();
            return redirect()->route('kelolaSantri.index')->with('success', 'Data berhasil dipulihkan');
        } catch (\Exception $e) {
            return back()->withErrors($e);
        }
    }

    public function deletePermanent($id)
    {
        try {
            $data = MasterStudent::onlyTrashed()->where('id', $id)->firstOrFail();
            $data->forceDelete();
            return redirect()->route('trashStudents')
                ->with('success', 'Data ' . $data->name . ' berhasil dihapus permanent');
        } catch (\Exception $e) {
            return back()->withErrors($e);
        }
    }
    public function deletePermanentAll()
    {
        try {
            $data = MasterStudent::onlyTrashed();
            $data->forceDelete();
            return redirect()->route('trashStudents')->with('success', 'Semua data berhasil dihapus permanent');
        } catch (\Exception $e) {
            return back()->withErrors($e);
        }
    }
}
