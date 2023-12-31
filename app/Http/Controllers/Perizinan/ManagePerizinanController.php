<?php

namespace App\Http\Controllers\Perizinan;

use App\Helpers\FcmHelper;
use App\Http\Controllers\Controller;
use App\Models\MasterPeriod;
use App\Models\MasterStudent;
use App\Models\MasterTokenFcm;
use App\Models\MasterUsers;
use App\Models\TrxStudentPermits;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ManagePerizinanController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('adminpengurus');

        $data = TrxStudentPermits::with(['student', 'program'])->latest()->get();
        return view('dashboard.perizinan.index', [
            'perizinan' => $data
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('admin');
        $student = MasterStudent::latest()->get();
        return view('dashboard.perizinan.create', compact('student'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('admin');
        $request->validate(
            [
                'student' => 'required',
                'datePermit' => 'required|date',
                'titlePermit' => 'required|max:100',
                'desc' => 'required'
            ],
            [
                'student.required' => 'Kolom Nama Siswa harus diisi.',
                'datePermit.required' => 'Kolom Tanggal Izin harus diisi.',
                'datePermit.date' => 'Kolom Tanggal Izin harus berupa tanggal yang valid.',
                'titlePermit.required' => 'Kolom Judul Izin harus diisi.',
                'titlePermit.max' => 'Kolom Judul Izin maksimal terdiri dari 100 karakter.',
                'desc.required' => 'Kolom Deskripsi harus diisi.'
            ]
        );

        try {
            $period = MasterPeriod::where('status', 1)->first();
            $student = MasterStudent::find($request->student);
            TrxStudentPermits::create([
                'student_id' => $student->id,
                'description' => $request->desc,
                'permit_date' => $request->datePermit,
                'permit_type' => $request->titlePermit,
                'id_program' => $student->program_id,
                'id_period' => $period->id ?? null
            ]);
            return redirect()->route('perizinan.index')
                ->with('success', 'Berhasil membuat perizinan ' . $request->titlePermit);
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
        $this->authorize('admin');
        $student = MasterStudent::latest()->get();
        $data =  TrxStudentPermits::find($id);
        return view('dashboard.perizinan.edit', compact('student', 'data'));
    }

    public function updatePermit(Request $request, $id)
    {
        $this->authorize('admin');
        $request->validate(
            [
                'student' => 'required',
                'datePermit' => 'required|date',
                'titlePermit' => 'required|max:100',
                'desc' => 'required'
            ],
            [
                'student.required' => 'Kolom Nama Siswa harus diisi.',
                'datePermit.required' => 'Kolom Tanggal Izin harus diisi.',
                'datePermit.date' => 'Kolom Tanggal Izin harus berupa tanggal yang valid.',
                'titlePermit.required' => 'Kolom Judul Izin harus diisi.',
                'titlePermit.max' => 'Kolom Judul Izin maksimal terdiri dari 100 karakter.',
                'desc.required' => 'Kolom Deskripsi harus diisi.'
            ]
        );
        try {
            $period = MasterPeriod::where('status', 1)->first();
            $student = MasterStudent::find($request->student);
            $data = TrxStudentPermits::find($id);
            $data->student_id = $request->student;
            $data->description = $request->desc;
            $data->permit_date = $request->datePermit;
            $data->permit_type = $request->titlePermit;
            $data->id_program = $student->program_id;
            $data->id_period = $period->id ?? null;
            $data->update();

            return redirect()->route('perizinan.index')
                ->with('success', 'Berhasil mengubah perizinan ' . $request->titlePermit);
        } catch (\Exception $e) {
            return back()->with('failed', 'Gagal mengubah data');
        }
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
        $this->authorize('adminpengurus');

        $request->validate([
            'status' => 'required'
        ], [
            'status.required' => 'Status harus diisi'
        ]);

        try {
            $data = TrxStudentPermits::find($id);
            $data->status = $request->status;
            $data->update();


            try {
                // send notification

                sleep(1);
                $data['page'] = 'permitPage';
                $checkAvaiableToken = MasterTokenFcm::all();
                // query to get id_user student
                $student = MasterStudent::find($data->student_id);
                $user = MasterUsers::where('email', $student->email)->firstOrFail();
                //
                $deviceRegistration = MasterTokenFcm::where('id_user', $user->id)->firstOrFail();
                if (count($checkAvaiableToken) > 0) {
                    $status = $request->status == 1 ? 'Di setujui' : 'Tidak di setujui';
                    $dataFcm = [
                        'data' => $data
                    ];
                    FcmHelper::sendNotificationWithGuzzle(
                        'Perizinan ' . $data->permit_type . ' ' . $status,
                        $dataFcm,
                        false,
                        $deviceRegistration->token
                    );
                }
                return back()->with('success', 'Data berhasil diubah');
            } catch (\Exception $e) {
                return back()->with('success', 'Data berhasil diubah, Notif gagal terkirim');
            }
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
        $this->authorize('admin');
        try {
            $data = TrxStudentPermits::find($id);
            $data->delete();

            return back()->with('success', 'Data berhasil dihapus');
        } catch (\Exception $e) {
            return back()->with('failed', 'Gagal menghapus data');
        }
    }

    // /**
    //  * softdeletes
    //  */
    // public function trash()
    // {
    //     $this->authorize('admin');

    //     $data = TrxStudentPermits::with(['student', 'program'])->onlyTrashed()->get();
    //     return view('dashboard.perizinan.trash', [
    //         'trash' => $data
    //     ]);
    // }
    ///
    // public function restore($id)
    // {
    //     $this->authorize('admin');

    //     try {
    //         $data = TrxStudentPermits::onlyTrashed()->where('id', $id)->firstOrFail();
    //         $data->restore();
    //         return redirect()->route('perizinan.index')
    //             ->with('success', 'Data berhasil dipulihkan ');
    //     } catch (\Exception $e) {
    //         return back()->withErrors($e);
    //     }
    // }
    // public function restoreAll()
    // {
    //     $this->authorize('admin');
    ///
    //     try {
    //         $data = TrxStudentPermits::onlyTrashed();
    //         $data->restore();
    //         return redirect()->route('perizinan.index')->with('success', 'Data berhasil dipulihkan');
    //     } catch (\Exception $e) {
    //         return back()->withErrors($e);
    //     }
    // }
    ///
    // public function deletePermanent($id)
    // {
    //     $this->authorize('admin');

    //     try {
    //         $data = TrxStudentPermits::onlyTrashed()->where('id', $id)->firstOrFail();
    //         $data->forceDelete();
    //         return redirect()->route('trashPermit')
    //             ->with('success', 'Data berhasil dihapus permanent');
    //     } catch (\Exception $e) {
    //         return back()->withErrors($e);
    //     }
    // }
    // public function deletePermanentAll()
    // {
    //     $this->authorize('admin');
    ///
    //     try {
    //         $data = TrxStudentPermits::onlyTrashed();
    //         $data->forceDelete();
    //         return redirect()->route('trashPermit')->with('success', 'Semua data berhasil dihapus permanent');
    //     } catch (\Exception $e) {
    //         return back()->withErrors($e);
    //     }
    // }
    ///
}
