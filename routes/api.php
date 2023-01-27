<?php

use App\Http\Controllers\Api\V1\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => 'v1'], function () {

    /**
     * [ROUTE AUTH]
     */
    Route::post('/user/login', [AuthController::class, 'login']);

    /**
     * [ROUTE MIDDLEWARE SACTUM]
     */
    Route::group(['middleware' => ['auth:sanctum']], function () {
        /**
         * [ROUTE AUTH]
         */
        Route::post("/user/logout", [AuthController::class, 'logoutUser']);
    });
});
