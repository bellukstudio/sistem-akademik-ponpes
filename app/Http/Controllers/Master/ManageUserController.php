<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\MasterUsers;
use Illuminate\Http\Request;

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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
