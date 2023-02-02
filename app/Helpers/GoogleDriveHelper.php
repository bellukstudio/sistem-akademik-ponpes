<?php

namespace App\Helpers;

use Google_Client;
use Google_Service_Drive;
use Google_Service_Oauth2;
use Google_Service_Drive_DriveFile;
use Google_Service_Drive_Permission;
use Illuminate\Support\Facades\Auth;
use App\Models\MasterUsers;
use App\Models\SessionUser;
use Illuminate\Support\Str;
use Carbon\Carbon;

class GoogleDriveHelper
{
    public static $pdf = 'application/pdf';
    public static $img = 'image/png';
    public static function googleLogin($request)
    {
        //setup
        $gClient = new Google_Client();

        $gClient->setApplicationName('laravel');
        $gClient->setClientId(env('GOOGLE_DRIVE_CLIENT_ID'));
        $gClient->setClientSecret(env('GOOGLE_DRIVE_CLIENT_SECRET'));
        $gClient->setRedirectUri(route('google.login'));
        $gClient->setDeveloperKey(env('GOOGLE_DEVELOPER_KEY'));
        $gClient->setScopes(array(
            'https://www.googleapis.com/auth/drive.file',
            'https://www.googleapis.com/auth/drive'
        ));

        $gClient->setAccessType("offline");

        $gClient->setApprovalPrompt("force");

        // service Oauth2

        $google_oauthV2 = new Google_Service_Oauth2($gClient);

        if ($request->get('code')) {
            $gClient->authenticate($request->get('code'));
            $request->session()->put('token', $gClient->getAccessToken());
        }

        if ($request->session()->get('token')) {
            $gClient->setAccessToken($request->session()->get('token'));
        }

        if ($gClient->getAccessToken()) {

            // save session
            // save acceess token
            $user = MasterUsers::find(Auth::user()->id);
            $checkSession = SessionUser::where('user_id', $user->id)->doesntExist();
            if ($checkSession) {
                //Save users session
                $session = [
                    'id' => Str::random(40),
                    'user_id' => $user->id,
                    'ip_address' => $request->ip(),
                    'user_agent' => $request->server('HTTP_USER_AGENT'),
                    'last_activity' => strtotime(Carbon::now()),
                    'status' => 'ON'
                ];
                SessionUser::create($session);
            } else {
                SessionUser::where('user_id', $user->id)
                    ->update([
                        'id' => Str::random(40),
                        'ip_address' => $request->ip(),
                        'user_agent' => $request->server('HTTP_USER_AGENT'),
                        'last_activity' => strtotime(Carbon::now()),
                        'status' => 'ON'
                    ]);
            }


            $user->access_token = json_encode($request->session()->get('token'));
            $user->save();

            return redirect()->intended('dashboard');
        } else {
            $authUrl = $gClient->createAuthUrl();
            return redirect()->to($authUrl);
        }
    }

    public static function googleDriveFileUpload($filename, $data, $folderName, $mimeType)
    {
        // setup
        $gClient = new Google_Client();

        $gClient->setApplicationName('laravel');
        $gClient->setClientId(env('GOOGLE_DRIVE_CLIENT_ID'));
        $gClient->setClientSecret(env('GOOGLE_DRIVE_CLIENT_SECRET'));
        $gClient->setRedirectUri(route('google.login'));
        $gClient->setDeveloperKey(env('GOOGLE_DEVELOPER_KEY'));
        $gClient->setScopes(array(
            'https://www.googleapis.com/auth/drive.file',
            'https://www.googleapis.com/auth/drive'
        ));

        // service drive
        $service = new Google_Service_Drive($gClient);

        $user = MasterUsers::find(Auth::user()->id);

        if (is_null($user->access_token)) {
            return redirect()->route('google.login');
        } else {
            $gClient->setAccessToken(json_decode($user->access_token, true));
            print_r('error 1');

            if ($gClient->isAccessTokenExpired()) {
                print_r('error 2');

                // SAVE REFRESH TOKEN TO SOME VARIABLE
                $refreshTokenSaved = $gClient->getRefreshToken();

                // UPDATE ACCESS TOKEN
                $gClient->fetchAccessTokenWithRefreshToken($refreshTokenSaved);

                // PASS ACCESS TOKEN TO SOME VARIABLE
                $updatedAccessToken = $gClient->getAccessToken();

                // APPEND REFRESH TOKEN
                $updatedAccessToken['refresh_token'] = $refreshTokenSaved;

                // SET THE NEW ACCES TOKEN
                $gClient->setAccessToken($updatedAccessToken);

                $user->access_token = $updatedAccessToken;

                $user->save();
            }

            // Set the name of the parent folder
            $parentFolderName = env('GOOGLE_DRIVE_FOLDER');

            // Set the name of the subfolder
            $subfolderName = $folderName;
            // Set the ID of the root folder (the top-level folder in Google Drive)
            $rootFolderId = 'root';

            // Search for existing folders with the same name as the parent folder in the root folder
            $query = "mimeType='application/vnd.google-apps.folder' and trashed = false and name='" . $parentFolderName . "' and parents in '" . $rootFolderId . "'";
            $existingFolders = $service->files->listFiles(array('q' => $query));

            if (count($existingFolders->getFiles()) == 0) {
                // No existing folders with the same name were found, so create a new parent folder
                $parentFolderMetadata = new Google_Service_Drive_DriveFile(array(
                    'name' => $parentFolderName,
                    'mimeType' => 'application/vnd.google-apps.folder'
                ));
                $parentFolder = $service->files->create($parentFolderMetadata, array('fields' => 'id'));
                $parentFolderId = $parentFolder->id;
            } else {
                // An existing folder with the same name was found, so use its ID
                $parentFolderId = $existingFolders->getFiles()[0]->id;
            }

            // Search for existing folders with the same name as the subfolder in the parent folder
            $querySubFolder = "mimeType='application/vnd.google-apps.folder' and trashed = false and name='" . $subfolderName . "' and parents in '" . $parentFolderId . "'";
            $existingSubFolders = $service->files->listFiles(array('q' => $querySubFolder));
            if (count($existingSubFolders->getFiles()) == 0) {
                // No existing folders with the same name were found, so create a new subfolder
                $subfolderMetadata = new Google_Service_Drive_DriveFile(array(
                    'name' => $subfolderName,
                    'mimeType' => 'application/vnd.google-apps.folder',
                    'parents' => array($parentFolderId)
                ));
                $subfolder = $service->files->create($subfolderMetadata, array('fields' => 'id'));
                $subfolderId = $subfolder->id;
            } else {
                $subfolderId = $existingSubFolders->getFiles()[0]->id;
            }
            // create parent folder
            $fileMetadata = new Google_Service_Drive_DriveFile(array(
                'name' => $filename,             // ADD YOUR GOOGLE DRIVE FOLDER NAME
                'parents' => array($subfolderId)
            ));

            try {
                $result = $service->files->create($fileMetadata, array(
                    'data' => file_get_contents($data), // ADD YOUR FILE PATH WHICH YOU WANT TO UPLOAD ON GOOGLE DRIVE
                    'mimeType' => $mimeType,
                    'uploadType' => 'multipart',
                    'fields' => 'id'
                ));
            } catch (\Google_Service_Exception  $e) {
                return back()->with('error', $e);
            }
            //get all email in table users
            $users = MasterUsers::latest()->get();

            foreach ($users as $value) {
                //permission
                $permission = new Google_Service_Drive_Permission();
                $permission->setType('user');
                $permission->setRole('reader');
                $permission->setEmailAddress($value->email);

                // Grant the permission
                try {
                    $service->permissions->create($result->id, $permission, array('sendNotificationEmail' => false));
                    // Permission granted successfully
                } catch (\Google_Service_Exception $e) {
                    // Handle error
                    return back()->with('error', $e);
                }
            }

            // GET URL OF UPLOADED FILE

            // $urlOpen = 'https://drive.google.com/open?id=' . $result->id;
            // $urlView = 'https://drive.google.com/file/d/' . $result->id . '/view';

            return
                $result->id;
        }
    }

    public static function deleteFile($filename, $mimeType)
    {
        // setup
        $gClient = new Google_Client();

        $gClient->setApplicationName('laravel');
        $gClient->setClientId(env('GOOGLE_DRIVE_CLIENT_ID'));
        $gClient->setClientSecret(env('GOOGLE_DRIVE_CLIENT_SECRET'));
        $gClient->setRedirectUri(route('google.login'));
        $gClient->setDeveloperKey(env('GOOGLE_DEVELOPER_KEY'));
        $gClient->setScopes(array(
            'https://www.googleapis.com/auth/drive.file',
            'https://www.googleapis.com/auth/drive'
        ));

        // service drive
        $service = new Google_Service_Drive($gClient);

        $user = MasterUsers::find(Auth::user()->id);

        if (is_null($user->access_token)) {
            return redirect()->route('google.login');
        } else {
            $gClient->setAccessToken(json_decode($user->access_token, true));
            if ($gClient->isAccessTokenExpired()) {

                // SAVE REFRESH TOKEN TO SOME VARIABLE
                $refreshTokenSaved = $gClient->getRefreshToken();

                // UPDATE ACCESS TOKEN
                $gClient->fetchAccessTokenWithRefreshToken($refreshTokenSaved);

                // PASS ACCESS TOKEN TO SOME VARIABLE
                $updatedAccessToken = $gClient->getAccessToken();

                // APPEND REFRESH TOKEN
                $updatedAccessToken['refresh_token'] = $refreshTokenSaved;

                // SET THE NEW ACCES TOKEN
                $gClient->setAccessToken($updatedAccessToken);

                $user->access_token = $updatedAccessToken;

                $user->save();
            }

            // Search for the file by name and get the file ID
            $query = "name='" . $filename . "' and mimeType='" . $mimeType . "'";
            $results = $service->files->listFiles(array('q' => $query));
            if (count($results->getFiles()) == 0) {
                print "No files found 1.\n";
            } else {
                $file = $results->getFiles()[0];
                $fileId = $file->getId();
            }

            // Or, list all files and get the file ID
            $results = $service->files->listFiles();
            if (count($results->getFiles()) == 0) {
                print "No files found 2.\n";
            } else {
                foreach ($results->getFiles() as $file) {
                    if (
                        $file->getName() == $filename
                    ) {
                        $fileId = $file->getId();
                        break;
                    }
                }
            }
            $service->files->delete($fileId);
        }
    }

    public static function checkRefreshToken()
    {
        // get id user logged in
        $user = MasterUsers::find(Auth::user()->id);

        if (is_null($user->access_token)) {
            return redirect()->route('google.login');
        } else {
            return redirect()->intended('dashboard');
        }
    }

    public static function renameFile($fileId, $newName)
    {
        // setup
        $gClient = new Google_Client();

        $gClient->setApplicationName('laravel');
        $gClient->setClientId(env('GOOGLE_DRIVE_CLIENT_ID'));
        $gClient->setClientSecret(env('GOOGLE_DRIVE_CLIENT_SECRET'));
        $gClient->setRedirectUri(route('google.login'));
        $gClient->setDeveloperKey(env('GOOGLE_DEVELOPER_KEY'));
        $gClient->setScopes(array(
            'https://www.googleapis.com/auth/drive.file',
            'https://www.googleapis.com/auth/drive'
        ));

        // service drive
        $service = new Google_Service_Drive($gClient);

        $user = MasterUsers::find(Auth::user()->id);

        if (is_null($user->access_token)) {
            return redirect()->route('google.login');
        } else {
            $gClient->setAccessToken(json_decode($user->access_token, true));
            if ($gClient->isAccessTokenExpired()) {

                // SAVE REFRESH TOKEN TO SOME VARIABLE
                $refreshTokenSaved = $gClient->getRefreshToken();

                // UPDATE ACCESS TOKEN
                $gClient->fetchAccessTokenWithRefreshToken($refreshTokenSaved);

                // PASS ACCESS TOKEN TO SOME VARIABLE
                $updatedAccessToken = $gClient->getAccessToken();

                // APPEND REFRESH TOKEN
                $updatedAccessToken['refresh_token'] = $refreshTokenSaved;

                // SET THE NEW ACCES TOKEN
                $gClient->setAccessToken($updatedAccessToken);

                $user->access_token = $updatedAccessToken;

                $user->save();
            }

            // Rename the file
            $file = new Google_Service_Drive_DriveFile();
            $file->setName($newName);
            $service->files->update($fileId, $file, ['fields' => 'name']);
        }
    }

    public function setPermission($id)
    {
        // setup
        $gClient = new Google_Client();

        $gClient->setApplicationName('laravel');
        $gClient->setClientId(env('GOOGLE_DRIVE_CLIENT_ID'));
        $gClient->setClientSecret(env('GOOGLE_DRIVE_CLIENT_SECRET'));
        $gClient->setRedirectUri(route('google.login'));
        $gClient->setDeveloperKey(env('GOOGLE_DEVELOPER_KEY'));
        $gClient->setScopes(array(
            'https://www.googleapis.com/auth/drive.file',
            'https://www.googleapis.com/auth/drive'
        ));

        // service drive
        $service = new Google_Service_Drive($gClient);

        $user = MasterUsers::find(Auth::user()->id);

        if (is_null($user->access_token)) {
            return redirect()->route('google.login');
        } else {
            $gClient->setAccessToken(json_decode($user->access_token, true));
            print_r('error 1');

            if ($gClient->isAccessTokenExpired()) {
                print_r('error 2');

                // SAVE REFRESH TOKEN TO SOME VARIABLE
                $refreshTokenSaved = $gClient->getRefreshToken();

                // UPDATE ACCESS TOKEN
                $gClient->fetchAccessTokenWithRefreshToken($refreshTokenSaved);

                // PASS ACCESS TOKEN TO SOME VARIABLE
                $updatedAccessToken = $gClient->getAccessToken();

                // APPEND REFRESH TOKEN
                $updatedAccessToken['refresh_token'] = $refreshTokenSaved;

                // SET THE NEW ACCES TOKEN
                $gClient->setAccessToken($updatedAccessToken);

                $user->access_token = $updatedAccessToken;

                $user->save();
            }
        }
        //get all email in table users
        $users = MasterUsers::latest()->get();

        foreach ($users as $value) {
            //permission
            $permission = new Google_Service_Drive_Permission();
            $permission->setType('user');
            $permission->setRole('reader');
            $permission->setEmailAddress($value->email);

            // Grant the permission
            try {
                $service->permissions->create($id, $permission, array('sendNotificationEmail' => false));
                // Permission granted successfully
            } catch (\Google_Service_Exception $e) {
                // Handle error
                return back()->with('error', $e);
            }
        }
    }
}
