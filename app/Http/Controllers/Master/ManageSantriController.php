<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\MasterAcademicProgram;
use App\Models\MasterPeriod;
use App\Models\MasterStudent;
use Illuminate\Http\Request;
use App\Models\MasterProvince;
use Illuminate\Support\Facades\File;
use App\Helpers\GoogleDriveHelper;

use function PHPUnit\Framework\isEmpty;

class ManageSantriController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $santri = MasterStudent::latest()->get();
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
            'id_number' => 'required|integer|unique:master_students,noId',
            'address' => 'required',
            'email' => 'required|email:dns|unique:master_students',
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
            $upload = null;
            if ($request->file('photo')) {
                $file = $request->file('photo');
                $upload = GoogleDriveHelper::googleDriveFileUpload(
                    $request->id_number . '.png',
                    $file,
                    'STUDENT',
                    GoogleDriveHelper::$img
                );
            }

            MasterStudent::create([
                'noId' => $request->id_number,
                'email' => $request->email,
                'name' => $request->fullName,
                'photo' => $upload,
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
                ->with('success', 'Santri ' . $request->fullName . ' berhasil disimpan');
        } catch (\Exception $e) {
            return back()->withErrors($e);
        }
    }
    /**
     * get all student with json
     */
    public function getAllStudents()
    {
        $empData['data'] = MasterStudent::whereNotIn('noId', function ($query) {
            $query->select('no_induk')->from('trx_caretakers');
        })->get();

        return response()->json($empData);
    }
    /**
     * get all student with json
     */
    public function getAllStudentsByProgramClass($programId)
    {
        $empData['data'] = MasterStudent::where('program_id', $programId)->whereNotIn('id', function ($query) {
            $query->select('student_id')->from('trx_class_groups');
        })->get();

        return response()->json($empData);
    }
    /**
     * get all student with json
     */
    public function getAllStudentsByProgramRoom($programId)
    {
        $empData['data'] = MasterStudent::where('program_id', $programId)->whereNotIn('id', function ($query) {
            $query->select('student_id')->from('trx_room_groups');
        })->get();

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
            'email' => 'required|email:dns',
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
            if ($request->file('photo')) {
                $file = $request->file('photo');
                if (isEmpty($data->photo)) {
                    $upload = GoogleDriveHelper::googleDriveFileUpload(
                        $request->noId . '.png',
                        $file,
                        'STUDENT',
                        GoogleDriveHelper::$img
                    );

                    $data->photo = $upload;
                } else {
                    //delete file
                    GoogleDriveHelper::deleteFile($data->noId, GoogleDriveHelper::$img);
                    //upload new file
                    $upload = GoogleDriveHelper::googleDriveFileUpload(
                        $request->noId . '.png',
                        $file,
                        'TEACHER',
                        GoogleDriveHelper::$img
                    );

                    $data->photo = $upload;
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
            $data->student_parent = $request->student_parent;
            $data->program_id = $request->program;
            $data->period_id = $request->period;
            $data->update();
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
            if ($data->photo != null) {
                $fileName = $data->noId . '.png';
                GoogleDriveHelper::deleteFile($fileName, GoogleDriveHelper::$img);
                $data->photo = null;
                $data->update();
            }

            $data->delete();
            return redirect()->route('kelolaSantri.index')
                ->with('success', 'Santri ' . $data->name . ' berhasil dihapus');
        } catch (\Exception $e) {
            return back()->withErrors($e);
        }
    }

    public function trash()
    {
        $this->authorize('admin');

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
                ->with('success', 'Santri ' . $data->name . ' berhasil dipulihkan ');
        } catch (\Exception $e) {
            return back()->withErrors($e);
        }
    }
    public function restoreAll()
    {
        try {
            $data = MasterStudent::onlyTrashed();
            $data->restore();
            return redirect()->route('kelolaSantri.index')->with('success', 'Semua Data berhasil dipulihkan');
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
                ->with('success', 'Santri ' . $data->name . ' berhasil dihapus permanent');
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
