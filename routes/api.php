<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\BeritaController;
use App\Http\Controllers\Api\V1\JadwalController;
use App\Http\Controllers\Api\V1\PembayaranController;
use App\Http\Controllers\Api\V1\PenilaianController;
use App\Http\Controllers\Api\V1\PerizinanController;
use App\Http\Controllers\Api\V1\PresensiController;
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
        /**
         * [ROUTE NEWS]
         */
        Route::get('/app/news', [BeritaController::class, 'getAllNews']);
        Route::post('/app/news/{news}/read', [BeritaController::class, 'readNews']);
        /**
         * [ROUTE PERMIT]
         */
        Route::get('/app/permit/history', [PerizinanController::class, 'getHistoryPermit']);
        Route::get('/app/permit/history/count', [PerizinanController::class, 'countHistoryPermit']);
        Route::post('/app/permit/save', [PerizinanController::class, 'saveNewPermit']);
        Route::post('/app/permit/{id}/update', [PerizinanController::class, 'updatePermit']);
        Route::delete('/app/permit/{id}/delete', [PerizinanController::class, 'deletePermit']);
        /**
         * [ROUTE PAYMENT]
         */
        Route::get('/app/payment/history', [PembayaranController::class, 'getHistoryPayment']);
        Route::post('/app/payment/uploadPhoto/{id}', [PembayaranController::class, 'uploadPhoto']);
        Route::post('/app/payment/save', [PembayaranController::class, 'saveNewPayment']);
        Route::get('/app/payment/category', [PembayaranController::class, 'getAllCategoriePayment']);
        Route::get('/app/payment/method', [PembayaranController::class, 'getMethodPayment']);
        Route::get('/app/payment/categoryPayment', [PembayaranController::class, 'getCategoryPayment']);
        /**
         * [ROUTE PRESENCE]
         */
        Route::get('/app/presence/history', [PresensiController::class, 'getHistoryPresence']);
        Route::get('/app/presence/history/count', [PresensiController::class, 'countHistoryPresence']);
        Route::get('/app/presence/type', [PresensiController::class, 'getTypePresence']);
        /**
         * [ROUTE ASSESSMENT]
         */
        Route::get('/app/assessment/memorize', [PenilaianController::class, 'getAssessmentSurah']);
        /**
         * [ROUTE SCHEDULE]
         */
        Route::get('/app/schedules', [JadwalController::class, 'getScheduleByClass']);
        Route::get('/app/schedules/category', [JadwalController::class, 'getCategorySchedule']);
    });
});
