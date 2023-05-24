<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\MasterAcademicProgram;
use App\Models\MasterUsers;
use App\Models\TrxCaretakers;
use Illuminate\Http\Request;

class ManagePengurusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = TrxCaretakers::with(['program'])->latest()->get();

        return view('dashboard.master_data.kelola_pengurus.index', [
            'pengurus' => $data
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $program = MasterAcademicProgram::all();
        return view('dashboard.master_data.kelola_pengurus.create', [
            'program' => $program
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
            'categories' => 'required',
            'dataList' => 'required',
            'id_number' => 'required',
            'fullName' => 'required',
            'email' => 'required|email',
            'program' => 'required'
        ], [
            'categories.required' => 'Kategori harus diisi.',
            'dataList.required' => 'Data list harus diisi.',
            'id_number.required' => 'Nomor ID harus diisi.',
            'fullName.required' => 'Nama lengkap harus diisi.',
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Email tidak valid.',
            'program.required' => 'Program harus diisi.'
        ]);

        try {
            TrxCaretakers::create([
                'user_id' => $request->id_number,
                'name' => $request->fullName,
                'categories' => $request->categories,
                'program_id' => $request->program,
                'email' => $request->email
            ]);

            //update users roles
            $user = MasterUsers::find($request->id_number);
            $user->roles_id = 3;
            $user->update();

            return redirect()->route('kelolaPengurus.index')
                ->with('success', 'Pengurus ' . $request->fullName . ' berhasil disimpan');
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
        $data = TrxCaretakers::find($id);
        $program = MasterAcademicProgram::all();

        return view('dashboard.master_data.kelola_pengurus.edit', compact('data', 'program'));
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
            'categories' => 'required',
            'dataList' => 'required',
            'id_number' => 'required',
            'fullName' => 'required',
            'email' => 'required|email',
            'program' => 'required'
        ], [
            'categories.required' => 'Kategori harus diisi.',
            'dataList.required' => 'Data list harus diisi.',
            'id_number.required' => 'Nomor ID harus diisi.',
            'fullName.required' => 'Nama lengkap harus diisi.',
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Email tidak valid.',
            'program.required' => 'Program harus diisi.'
        ]);

        try {

            $data = TrxCaretakers::find($id);
            if (
                $request->id_number !== $data->user_id
                && $request->email !== $data->email && $request->fullName !== $data->name
            ) {
                //update users roles
                $user = MasterUsers::find($data->user_id);
                $user->roles_id = 2;
                $user->update();

                $data->categories = $request->categories;
                $data->user_id = $request->id_number;
                $data->name = $request->fullName;
                $data->program_id = $request->program;
                $data->email = $request->email;
                $data->update();

                //update users roles
                $userUpdate = MasterUsers::find($request->id_number);
                $userUpdate->roles_id = 3;
                $userUpdate->update();
            }
            $data->categories = $request->categories;
            $data->user_id = $request->id_number;
            $data->name = $request->fullName;
            $data->program_id = $request->program;
            $data->email = $request->email;
            $data->update();


            return redirect()->route('kelolaPengurus.index')
                ->with('success', 'Pengurus ' . $request->fullName . ' berhasil diubah');
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
            $data = TrxCaretakers::find($id);

            //update users roles
            $user = MasterUsers::find($data->user_id);
            if ($data->categories === 'students') {
                $user->roles_id = 4;
            } elseif ($data->categories === 'teachers') {
                $user->roles_id = 2;
            }
            $user->update();
            //delete
            $data->delete();
            return redirect()->route('kelolaPengurus.index')
                ->with('success', 'Pengurus ' . $data->name . ' berhasil disimpan');
        } catch (\Exception $e) {
            return back()->with('failed', 'Gagal menghapus data');
        }
    }

    public function trash()
    {
       

        $data = TrxCaretakers::with(['program'])->onlyTrashed()->get();
        return view('dashboard.master_data.kelola_pengurus.trash', [
            'trash' => $data
        ]);
    }

    public function restore($id)
    {
       

        try {
            $data = TrxCaretakers::onlyTrashed()->where('id', $id)->firstOrFail();
            //update users roles
            $userUpdate = MasterUsers::find($data->user_id);
            $userUpdate->roles_id = 3;
            $userUpdate->update();
            $data->restore();
            return redirect()->route('kelolaPengurus.index')
                ->with('success', 'Pengurus ' . $data->name . ' berhasil dipulihkan ');
        } catch (\Exception $e) {
            return back()->with('failed', 'Gagal memulihkan data');
        }
    }
    public function restoreAll()
    {
       

        try {
            $data = TrxCaretakers::onlyTrashed();
            $data->restore();
            return redirect()->route('kelolaPengurus.index')->with('success', 'Data berhasil dipulihkan');
        } catch (\Exception $e) {
            return back()->with('failed', 'Gagal memulihkan data');
        }
    }

    public function deletePermanent($id)
    {
       

        try {
            $data = TrxCaretakers::onlyTrashed()->where('id', $id)->firstOrFail();
            $data->forceDelete();
            return redirect()->route('trashCaretakers')
                ->with('success', 'Pengurus ' . $data->name . ' berhasil dihapus permanent');
        } catch (\Exception $e) {
            return back()->with('failed', 'Gagal menghapus data');
        }
    }
    public function deletePermanentAll()
    {
       

        try {
            $data = TrxCaretakers::onlyTrashed();
            $data->forceDelete();
            return redirect()->route('trashCaretakers')->with('success', 'Semua data berhasil dihapus permanent');
        } catch (\Exception $e) {
            return back()->with('failed', 'Gagal menghapus data');
        }
    }
}
