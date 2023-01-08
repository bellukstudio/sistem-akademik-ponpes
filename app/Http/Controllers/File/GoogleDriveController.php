<?php

namespace App\Http\Controllers\File;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\GoogleDriveHelper;

class GoogleDriveController extends Controller
{
    /**
     * google auth request
     *
     * @param Request $request
     * @return void
     */
    public function googleAuth(Request $request)
    {
        return GoogleDriveHelper::googleLogin($request);
    }

    public function checkRefreshToken()
    {
        return GoogleDriveHelper::checkRefreshToken();
    }
}
