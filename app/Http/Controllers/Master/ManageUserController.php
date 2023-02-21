<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\MasterStudent;
use App\Models\MasterTeacher;
use App\Models\MasterUsers;
use App\Models\SessionUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ManageUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $data = MasterUsers::with(['roles'])->whereNotIn('roles_id', [1])->latest()->get();
            return view(
                'dashboard.master_data.kelola_user.index',
                [
                    'user' => $data
                ]
            );
        } catch (\Throwable $e) {
            return redirect()->route('kelolaUser.index')->withErrors($e);
        }
    }
    /**
     * get user by roles
     */
    public function getUserByRoles(Request $request)
    {
        $empData['data'] = MasterUsers::join('roles', 'roles.id', '=', 'master_users.roles_id')
            ->where('roles.name', $request->name)
            ->select('master_users.name as name', 'master_users.id as id', 'master_users.email as email')->get();
        return response()->json($empData);
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
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:100',
            'email' => 'required|email:dns',
            'password' => 'sometimes',
        ], [
            'name.required' => 'Nama wajib diisi',
            'name.max' => 'Nama tidak boleh lebih dari 100 karakter',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
        ]);
        try {

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }
            $data = MasterUsers::findOrFail($id);
            $data->name = $request->name;
            $data->email = $request->email;
            if (!empty($request->password)) {
                $data->password = Hash::make($request->password);
            }

            $data->update();

            return redirect()->route('kelolaUser.index')->with('success', 'Berhasil mengubah data user');
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
            $data = MasterUsers::findOrFail($id);
            $teacher = MasterTeacher::where('email', $data->email)->exists();
            $student = MasterStudent::where('email', $data->email)->exists();
            $session = SessionUser::where('user_id', $data->id)->exists();

            if ($teacher) {
                if ($session) {
                    $dataSession = SessionUser::where('user_id', $data->id)->first();
                    $dataSession->delete();
                }
                $user = MasterTeacher::where('email', $data->email)->first();
                $user->is_activate = 0;
                $user->save();
                $data->delete();
            } elseif ($student) {
                if ($session) {
                    $dataSession = SessionUser::where('user_id', $data->id)->first();
                    $dataSession->delete();
                }
                $user = MasterStudent::where('email', $data->email)->first();
                $user->is_activate = 0;
                $user->save();
                $data->delete();
            } else {
                if ($session) {
                    $dataSession = SessionUser::where('user_id', $data->id)->first();
                    $dataSession->delete();
                }
                $data->delete();
            }

            return redirect()->route('kelolaUser.index')->with('success', 'Berhasil menghapus data user');
        } catch (\Exception $e) {
            return back()->with('failed', 'Tidak dapat menghapus user karena terhubung dengan beberapa tabel');
        }
    }
}
