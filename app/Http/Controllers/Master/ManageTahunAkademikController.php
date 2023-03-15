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
                'code' => 'required|max:20',
                'information' => 'required|string|max:100',
            ],
            [
                'code.required' => 'Kolom Kode harus diisi.',
                'code.max' => 'Kolom Kode maksimal terdiri dari 20 karakter.',
                'information.required' => 'Kolom Ketrangan harus diisi.',
                'information.string' => 'Kolom Ketrangan harus berupa karakter.',
                'information.max' => 'Kolom Ketrangan maksimal 100 karakter.',

            ]
        );


        try {
            MasterPeriod::create([
                'code' => $request->code,
                'information' => $request->information,
            ]);

            return redirect()->route('kelolaTahunAkademik.index')
                ->with('success', 'Tahun Akademik ' . $request->code . ' berhasil disimpan');
        } catch (\Exception $e) {
            return back()->with('failed', 'Gagal menyimpan data');
        }
    }

    // update status data
    public function updateStatus(Request $request)
    {

        $otherDataWithStatusOne = MasterPeriod::where('status', 1)->where('id', '<>', $request->id)->exists();
        if ($otherDataWithStatusOne) {
            return response()->json(['error' => 'Data cannot be saved.'], 400);
        } else {
            try {
                $data = MasterPeriod::findOrFail($request->id);
                $data->status = $request->status;
                $data->save();

                return response()->json(['message' => 'Berhasil mengupdate status.']);
            } catch (\Exception $e) {
                return response()->json(['message' => 'Tidak bisa mengubah status']);
            }
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
                'code' => 'required|max:20',
                'information' => 'required|string|max:100',
            ],
            [
                'code.required' => 'Kolom Kode harus diisi.',
                'code.max' => 'Kolom Kode maksimal terdiri dari 20 karakter.',
                'information.required' => 'Kolom Ketrangan harus diisi.',
                'information.string' => 'Kolom Ketrangan harus berupa karakter.',
                'information.max' => 'Kolom Ketrangan maksimal 100 karakter.',

            ]
        );
        try {
            $data = MasterPeriod::findOrFail($id);
            $data->code = $request->code;
            $data->information = $request->information;
            $data->update();

            return redirect()->route('kelolaTahunAkademik.index')
                ->with('success', 'Tahun Akademik ' . $request->code . ' berhasil dihapus');
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
        if (auth()->user()->roles_id != 1) {
            abort(403);
        }
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
