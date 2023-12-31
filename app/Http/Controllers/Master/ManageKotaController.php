<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\MasterCity;
use App\Models\MasterProvince;
use Illuminate\Http\Request;

class ManageKotaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = MasterCity::with(['province'])->latest()->get();
        return view('dashboard.master_data.kelola_kota.index', [
            'kota' => $data
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // search province by name
        $data = MasterProvince::latest();
        if (request('search')) {
            $data->where('province_name', 'like', '%' . request('search') . '%');
        }
        $province = $data->paginate(10);
        return view('dashboard.master_data.kelola_kota.create', [
            'province' => $province
        ]);
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
            'province_id' => 'required|integer',
            'province_name' => 'required',
            'city_name' => 'required|unique:master_cities,city_name|max:50',
        ], [
            'province_id.required' => 'Kolom ID Provinsi harus diisi.',
            'province_id.integer' => 'Kolom ID Provinsi harus berupa angka.',
            'province_name.required' => 'Kolom Nama Provinsi harus diisi.',
            'city_name.required' => 'Kolom Nama Kota harus diisi.',
            'city_name.unique' => 'Nama Kota sudah terdaftar di database.',
            'city_name.max' => 'Panjang Nama Kota maksimal 50 karakter.',
        ]);


        try {
            MasterCity::create([
                'id_province' => $request->province_id,
                'city_name' => $request->city_name
            ]);

            return redirect()->route('kelolaKota.index')
                ->with('success', 'Kota ' . $request->city_name . ' berhasil disimpan');
        } catch (\Exception $e) {
            return back()->with('failed', 'Gagal menyimpan data');
        }
    }

    /**
     * filter city with by province
     */
    public function getCityByProvinceId($idProvince)
    {
        $empData['data'] = MasterCity::where('id_province', $idProvince)
            ->get();

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
        // search province by name
        $data = MasterProvince::latest();
        if (request('search')) {
            $data->where('province_name', 'like', '%' . request('search') . '%');
        }
        $province = $data->paginate(10);
        $city = MasterCity::with(['province'])->findOrFail($id);
        return view('dashboard.master_data.kelola_kota.edit', [
            'province' => $province,
            'city' => $city
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
            'province_id' => 'required|integer',
            'province_name' => 'required',
            'city_name' => 'required|max:50|unique:master_cities,city_name,' . $id,
        ], [
            'province_id.required' => 'Kolom ID Provinsi harus diisi.',
            'province_id.integer' => 'Kolom ID Provinsi harus berupa angka.',
            'province_name.required' => 'Kolom Nama Provinsi harus diisi.',
            'city_name.required' => 'Kolom Nama Kota harus diisi.',
            'city_name.unique' => 'Nama Kota sudah terdaftar di database.',
            'city_name.max' => 'Panjang Nama Kota maksimal 50 karakter.',
        ]);
        try {
            $data = MasterCity::findOrFail($id);
            $data->id_province = $request->province_id;
            $data->city_name = $request->city_name;
            $data->update();
            return redirect()->route('kelolaKota.index')
                ->with('success', 'Kota ' . $request->city_name . ' berhasil diubah');
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
            $data = MasterCity::find($id);
            $data->delete();
            return back()
                ->with('success', 'Kota ' . $data->city_name . ' berhasil dihapus');
        } catch (\Exception $e) {
            return back()->with('failed', 'Gagal menghapus data');
        }
    }
    public function trash()
    {
       
        $data = MasterCity::with(['province'])->onlyTrashed()->get();
        return view('dashboard.master_data.kelola_kota.trash', [
            'trash' => $data
        ]);
    }

    public function restore($id)
    {
       

        try {
            $data = MasterCity::onlyTrashed()->where('id', $id)->firstOrFail();
            $data->restore();
            return redirect()->route('kelolaKota.index')
                ->with('success', 'Kota ' . $data->city_name . ' berhasil dipulihkan ');
        } catch (\Exception $e) {
            return back()->with('failed', 'Gagal memulihkan data');
        }
    }
    public function restoreAll()
    {
       

        try {
            $data = MasterCity::onlyTrashed();
            $data->restore();
            return redirect()->route('kelolaKota.index')->with('success', 'Data berhasil dipulihkan');
        } catch (\Exception $e) {
            return back()->with('failed', 'Gagal memulihkan data');
        }
    }

    public function deletePermanent($id)
    {
       

        try {
            $data = MasterCity::onlyTrashed()->where('id', $id)->firstOrFail();
            $data->forceDelete();
            return redirect()->route('trashCity')
                ->with('success', 'Kota ' . $data->city_name . ' berhasil dihapus permanent');
        } catch (\Exception $e) {
            return back()->with('failed', 'Gagal menghapus data');
        }
    }
    public function deletePermanentAll()
    {
       
        try {
            $data = MasterCity::onlyTrashed();
            $data->forceDelete();
            return redirect()->route('trashCity')->with('success', 'Semua data berhasil dihapus permanent');
        } catch (\Exception $e) {
            return back()->with('failed', 'Gagal menghapus data');
        }
    }
}
