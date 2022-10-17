<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Berita\BeritaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Master\ManageUserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// authentication
Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate'])->name('authenticate');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


Route::middleware('checkRole:1')->group(function () {
    Route::get('/dashboardAdmin', [DashboardController::class, 'index'])->name('dashboardAdmin');

    // route berita acara
    Route::get('beritaAcara/trash', [BeritaController::class, 'trash'])->name('trashBeritaAcara');
    Route::get('beritaAcara/trash/{id}/restore', [BeritaController::class, 'restore'])->name('restoreBeritaAcara');
    Route::get('beritaAcara/trash/restore', [BeritaController::class, 'restoreAll'])->name('restoreAllBeritaAcara');
    Route::get(
        'beritaAcara/trash/{id}/deletePermanent',
        [BeritaController::class, 'deletePermanent']
    )->name('deletePermanentBeritaAcara');
    Route::get(
        'beritaAcara/trash/deletePermanent',
        [BeritaController::class, 'deletePermanentAll']
    )->name('deletePermanenAlltBeritaAcara');
    Route::resource('beritaAcara', BeritaController::class);

    //route manage user
    Route::resource('manageUser', ManageUserController::class);
});

Route::middleware('checkRole:2')->group(function () {
    Route::get('/dashboardPengajar', [DashboardController::class, 'index'])->name('dashboardPengajar');
});
