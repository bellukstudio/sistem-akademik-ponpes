<?php

namespace App\Http\Controllers\File;

use App\Http\Controllers\Controller;
use App\Models\MasterFileShare;
use Illuminate\Http\Request;
use App\Helpers\GoogleDriveHelper;
use Illuminate\Support\Facades\Auth;

class ManageFileShareController extends Controller
{

    /**
     * manage file ebook
     *
     * @return void
     */
    public function indexEbook()
    {
        $data = MasterFileShare::where('type', 'BOOK')->latest()->get();
        return view('dashboard.file_sharing.ebook.index', compact('data'));
    }
    /**
     * upload file to gdrive
     *
     * @param Request $request
     * @return void
     */
    public function uploadFileToGdrive(Request $request)
    {
        $request->validate([
            'file_name' => 'required|max:100|unique:master_file_shares,file_name',
            'file' => 'required|mimes:pdf|max:2048',
        ]);
        try {
            $file = $request->file('file');
            //upload file
            $upload = GoogleDriveHelper::googleDriveFileUpload(
                $request->file_name . '.pdf',
                $file,
                'EBOOK',
                GoogleDriveHelper::$pdf
            );
            // link
            sleep(1);
            GoogleDriveHelper::allowEveryonePermission($upload);
            $link = 'https://drive.google.com/file/d/' . $upload . '/view';
            MasterFileShare::create([
                'file_name' => $request->file_name,
                'type' => 'BOOK',
                'id_user' => Auth::user()->id,
                'link' => $link,
                'id_file' => $upload
            ]);
            return back()->with('success', 'File ' . $request->file_name . ' berhasil disimpan');
        } catch (\Throwable $e) {
            return back()->withErrors($e);
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'file_name' => 'required|max:100',
            'file' => 'sometimes|mimes:pdf|max:2048',
        ]);

        try {
            // //get data
            $data = MasterFileShare::find($id);
            if ($request->file('file')) {
                $file = $request->file('file');
                //delete file
                GoogleDriveHelper::deleteFile($data->file_name, GoogleDriveHelper::$pdf);
                //upload file
                $upload = GoogleDriveHelper::googleDriveFileUpload(
                    $request->file_name . '.pdf',
                    $file,
                    'EBOOK',
                    GoogleDriveHelper::$pdf
                );
                sleep(1);
                GoogleDriveHelper::allowEveryonePermission($upload);
                //link
                $link = 'https://drive.google.com/file/d/' . $upload . '/view';
                //save link
                $data->link = $link;
                $data->id_file = $upload;
            }

            $data->file_name = $request->file_name;
            //rename
            GoogleDriveHelper::renameFile($data->id_file, $request->file_name);
            $data->update();
            return back()->with('success', 'File ' . $request->file_name . ' berhasil diubah');
        } catch (\Throwable $e) {
            return back()->withErrors($e);
        }
    }

    public function destroy($id)
    {
        try {

            $data = MasterFileShare::findOrFail($id);
            if ($data->type === 'BOOK') {
                //remove file
                GoogleDriveHelper::deleteFile($data->file_name . '.pdf', GoogleDriveHelper::$pdf);
            }
            $data->delete();

            return back()->with('success', 'File ' . $data->file_name . ' berhasil dihapus');
        } catch (\Throwable $e) {
            return back()->withErrors($e);
        }
    }

    /**
     * manage file video
     */

    public function indexVideo()
    {
        $data = MasterFileShare::where('type', 'VIDEO')->latest()->get();
        return view('dashboard.file_sharing.video.index', compact('data'));
    }

    public function saveVideo(Request $request)
    {
        $request->validate([
            'file_name' => 'required|max:100|unique:master_file_shares,file_name',
            'link' => 'required',
        ]);

        try {
            MasterFileShare::create([
                'file_name' => $request->file_name,
                'type' => 'VIDEO',
                'id_user' => Auth::user()->id,
                'link' => $request->link,
            ]);

            return back()->with('success', 'Url Video ' . $request->file_name . ' berhasil disimpan');
        } catch (\Throwable $e) {
            return back()->withErrors($e);
        }
    }

    public function updateVideo(Request $request, $id)
    {
        $request->validate([
            'file_name' => 'required|max:100|unique:master_file_shares,file_name',
            'link' => 'required',
        ]);

        try {
            $data = MasterFileShare::find($id);
            $data->file_name = $request->file_name;
            $data->link = $request->link;
            $data->update();

            return back()->with('success', 'URL Video ' . $request->file_name . ' berhasil diubah');
        } catch (\Throwable $e) {
            return back()->withErrors($e);
        }
    }

    public function destoryVideo($id)
    {
        try {

            $data = MasterFileShare::findOrFail($id);
            $data->delete();

            return back()->with('success', 'File ' . $data->file_name . ' berhasil dihapus');
        } catch (\Throwable $e) {
            return back()->withErrors($e);
        }
    }
}
