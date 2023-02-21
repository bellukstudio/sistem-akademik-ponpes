<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\MasterPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ManageTahunAkademikController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $data = MasterPeriod::latest()->get();
        return view('dashboard.master_data.kelola_tahunAkademik.index', [
            'tahunAkademik' => $data
        ]);
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
        $request->validate(
            [
                'kode' => 'required|max:20',
                'tgl_mulai' => 'required|date',
                'tgl_selesai' => 'required|date'
            ],
            [
                'kode.required' => 'Kolom Kode harus diisi.',
                'kode.max' => 'Kolom Kode maksimal terdiri dari 20 karakter.',
                'tgl_mulai.required' => 'Kolom Tanggal Mulai harus diisi.',
                'tgl_mulai.date' => 'Kolom Tanggal Mulai harus berupa tanggal yang valid.',
                'tgl_selesai.required' => 'Kolom Tanggal Selesai harus diisi.',
                'tgl_selesai.date' => 'Kolom Tanggal Selesai harus berupa tanggal yang valid.'
            ]
        );


        try {
            MasterPeriod::create([
                'code' => $request->kode,
                'start_date' => $request->tgl_mulai,
                'end_date' => $request->tgl_selesai
            ]);

            return redirect()->route('kelolaTahunAkademik.index')
                ->with('success', 'Tahun Akademik ' . $request->kode . ' berhasil disimpan');
        } catch (\Exception $e) {
            return back()->with('failed', 'Gagal menyimpan data');
        }
    }

    // update status data
    public function updateStatus(Request $request)
    {

        try {
            $data = MasterPeriod::findOrFail($request->id);
            $data->status = $request->status;
            $data->save();

            return response()->json(['message' => 'Berhasil mengupdate status.']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error']);
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
                'kode' => 'required|max:20',
                'tgl_mulai' => 'required|date',
                'tgl_selesai' => 'required|date'
            ],
            [
                'kode.required' => 'Kolom Kode harus diisi.',
                'kode.max' => 'Kolom Kode maksimal terdiri dari 20 karakter.',
                'tgl_mulai.required' => 'Kolom Tanggal Mulai harus diisi.',
                'tgl_mulai.date' => 'Kolom Tanggal Mulai harus berupa tanggal yang valid.',
                'tgl_selesai.required' => 'Kolom Tanggal Selesai harus diisi.',
                'tgl_selesai.date' => 'Kolom Tanggal Selesai harus berupa tanggal yang valid.'
            ]
        );
        try {
            $data = MasterPeriod::findOrFail($id);
            $data->code = $request->kode;
            $data->start_date = $request->tgl_mulai;
            $data->end_date = $request->tgl_selesai;
            $data->update();

            return redirect()->route('kelolaTahunAkademik.index')
                ->with('success', 'Tahun Akademik ' . $request->kode . ' berhasil dihapus');
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
            $data = MasterPeriod::find($id);
            $data->delete();
            return redirect()->route('kelolaTahunAkademik.index')
                ->with('success', 'Tahun Akademik ' . $data->code . ' berhasil dihapus');
        } catch (\Exception $e) {
            return back()->with('failed', 'Gagal menghapus data');
        }
    }

    public function trash()
    {
        $this->authorize('admin');
        $data = MasterPeriod::onlyTrashed()->get();
        return view('dashboard.master_data.kelola_tahunAkademik.trash', [
            'trash' => $data
        ]);
    }

    public function restore($id)
    {
        try {
            $data = MasterPeriod::onlyTrashed()->where('id', $id)->firstOrFail();
            $data->restore();
            return redirect()->route('kelolaTahunAkademik.index')
                ->with('success', 'Tahun Akademik ' . $data->code . ' berhasil dipulihkan ');
        } catch (\Exception $e) {
            return back()->with('failed', 'Gagal memulihkan data');
        }
    }
    public function restoreAll()
    {
        try {
            $data = MasterPeriod::onlyTrashed();
            $data->restore();
            return redirect()->route('kelolaTahunAkademik.index')
                ->with('success', 'Semua data berhasil dipulihkan');
        } catch (\Exception $e) {
            return back()->with('failed', 'Gagal memulihkan data');
        }
    }

    public function deletePermanent($id)
    {
        try {
            $data = MasterPeriod::onlyTrashed()->where('id', $id)->firstOrFail();
            $data->forceDelete();
            return redirect()->route('trashTahunAkademik')
                ->with('success', 'Tahun Akademik ' . $data->code . ' berhasil dihapus permanent');
        } catch (\Exception $e) {
            return back()->with('failed', 'Gagal menghapus data');
        }
    }
    public function deletePermanentAll()
    {
        try {
            $data = MasterPeriod::onlyTrashed();
            $data->forceDelete();
            return redirect()->route('trashTahunAkademik')->with('success', 'Semua data berhasil dihapus permanent');
        } catch (\Exception $e) {
            return back()->with('failed', 'Gagal menghapus data');
        }
    }
}
