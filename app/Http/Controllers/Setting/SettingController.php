<?php

namespace App\Http\Controllers\Setting;

use App\Helpers\GoogleDriveHelper;
use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $settings = Setting::first();

        return view('dashboard.setting.setting', compact('settings'));
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

        $validator = Validator::make($request->all(), [
            'site_name' => 'required|max:200',
            'logo' => 'mimes:png,jpg', // Logo is required when creating new data
            'pesantren_name' => 'required|max:200',
            'address' => 'required',
            'no_telp' => 'required'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $data = Setting::all();

            if ($data->count() > 0) {
                // Update existing data

                // Check if the logo is present in the request and upload it
                $upload = null;
                if ($request->hasFile('logo')) {
                    $file = $request->file('logo');
                    GoogleDriveHelper::deleteFile('logo.png', GoogleDriveHelper::$img);
                    sleep(1);
                    $upload = GoogleDriveHelper::googleDriveFileUpload(
                        'logo.png',
                        $file,
                        'LOGO',
                        GoogleDriveHelper::$img
                    );
                    if ($upload) {
                        GoogleDriveHelper::allowEveryonePermission($upload);
                    } else {
                        return redirect()->back()
                            ->with('error', 'Gagal mengupload logo.');
                    }
                }
                $updateData = [
                    'site_name' => $request->site_name,
                    'address' => $request->address,
                    'no_telp' => $request->no_telp,
                    'pesantren_name' => $request->pesantren_name
                ];

                if ($upload) {
                    $updateData['logo'] = $upload;
                }
                $data->first()->update($updateData);
            } else {

                if (!$request->hasFile('logo')) {
                    return back()->with('failed', 'Logo harus di isi')->withInput();
                }
                // Create new data
                $upload = null;
                if ($request->hasFile('logo')) {
                    $file = $request->file('logo');
                    $upload = GoogleDriveHelper::googleDriveFileUpload(
                        'logo.png',
                        $file,
                        'LOGO',
                        GoogleDriveHelper::$img
                    );
                    if ($upload) {
                        GoogleDriveHelper::allowEveryonePermission($upload);
                    } else {
                        return redirect()->back()
                            ->with('error', 'Gagal mengupload logo.');
                    }
                }
                Setting::create([
                    'site_name' => $request->site_name,
                    'logo' => $upload,
                    'address' => $request->address,
                    'no_telp' => $request->no_telp,
                    'pesantren_name' => $request->pesantren_name
                ]);
            }
            return redirect()->route('settings.index')->with('success', 'Berhasil disimpan.');
        } catch (\Throwable $e) {
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
