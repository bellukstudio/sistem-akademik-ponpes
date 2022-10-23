<?php

use App\Http\Controllers\Master\ManageTahunAkademikController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Berita\BeritaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Master\ManageKamarController;
use App\Http\Controllers\Master\ManageKotaController;
use App\Http\Controllers\Master\ManageProgramController;
use App\Http\Controllers\Master\ManageProvinsiController;
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
        'beritaAcara/trash/{id}/delete',
        [BeritaController::class, 'deletePermanent']
    )->name('deletePermanentBeritaAcara');
    Route::get(
        'beritaAcara/trash/delete',
        [BeritaController::class, 'deletePermanentAll']
    )->name('deletePermanenAlltBeritaAcara');
    Route::resource('beritaAcara', BeritaController::class);

    //route manage user
    Route::resource('kelolaUser', ManageUserController::class);


    // route manage tahun ajar
    Route::get(
        'kelolaTahunAkademik/status/update',
        [ManageTahunAkademikController::class, 'updateStatus']
    )->name('updateStatusTahun');
    Route::get(
        'kelolaTahunAkademik/trash',
        [ManageTahunAkademikController::class, 'trash']
    )->name('trashTahunAkademik');
    Route::get(
        'kelolaTahunAkademik/trash/{id}/restore',
        [ManageTahunAkademikController::class, 'restore']
    )->name('restoreTahunAkademik');
    Route::get(
        'kelolaTahunAkademik/trash/{id}/delete',
        [ManageTahunAkademikController::class, 'deletePermanent']
    )->name('deletePermanentTahunAkademik');
    Route::get(
        'kelolaTahunAkademik/trash/delete',
        [ManageTahunAkademikController::class, 'deletePermanentAll']
    )->name('deletePermanentAllTahunAkademik');
    Route::get(
        'kelolaTahunAkademik/trash/restore',
        [ManageTahunAkademikController::class, 'restoreAll']
    )->name('restoreAllTahunAkademik');
    Route::resource('kelolaTahunAkademik', ManageTahunAkademikController::class);

    /**
     * route master program
     */
    Route::get('kelolaProgramAkademik/trash', [ManageProgramController::class, 'trash'])->name('trashProgram');
    Route::get(
        'kelolaProgramAkademik/trash/{id}/restore',
        [ManageProgramController::class, 'restore']
    )->name('restoreProgram');
    Route::get(
        'kelolaProgramAkademik/trash/{id}/delete',
        [ManageProgramController::class, 'deletePermanent']
    )->name('deletePermanentProgram');
    Route::get(
        'kelolaProgramAkademik/trash/restore',
        [ManageProgramController::class, 'restoreAll']
    )->name('restoreAllProgram');
    Route::get(
        'kelolaProgramAkademik/trash/delete',
        [ManageProgramController::class, 'deletePermanentAll']
    )->name('deletePermanentAllProgram');
    Route::resource('kelolaProgramAkademik', ManageProgramController::class);


    /**
     * manage kota
     */
    Route::get('kelolaKota/trash', [ManageKotaController::class, 'trash'])->name('trashCity');
    Route::get(
        'kelolaKota/trash/{id}/delete',
        [ManageKotaController::class, 'deletePermanent']
    )->name('deletePermanentCity');
    Route::get(
        'kelolaKota/trash/restore',
        [ManageKotaController::class, 'restoreAll']
    )->name('restoreAllCity');
    Route::get(
        'kelolaKota/trash/delete',
        [ManageKotaController::class, 'deletePermanentAll']
    )->name('deletePermanentAllCity');
    Route::get('kelolaKota/trash/{id}/restore', [ManageKotaController::class, 'restore'])->name('restoreCity');
    Route::resource('kelolaKota', ManageKotaController::class);


    /**
     * manage provinsi
     */
    Route::get('kelolaProvinsi/trash', [ManageProvinsiController::class, 'trash'])->name('trashProvince');
    Route::get(
        'kelolaProvinsi/trash/{id}/delete',
        [ManageProvinsiController::class, 'deletePermanent']
    )->name('deletePermanentProvince');
    Route::get(
        'kelolaProvinsi/trash/restore',
        [ManageProvinsiController::class, 'restoreAll']
    )->name('restoreAllProvince');
    Route::get(
        'kelolaProvinsi/trash/delete',
        [ManageProvinsiController::class, 'deletePermanentAll']
    )->name('deletePermanentAllProvince');
    Route::get(
        'kelolaProvinsi/trash/{id}/restore',
        [ManageProvinsiController::class, 'restore']
    )->name('restoreProvince');

    Route::resource('kelolaProvinsi', ManageProvinsiController::class);

    /**
     * manage kamar
     */
    Route::get('kelolaKamar/trash', [ManageKamarController::class, 'trash'])->name('trashBedroom');
    Route::get(
        'kelolaKamar/trash/{id}/delete',
        [ManageKamarController::class, 'deletePermanent']
    )->name('deletePermanentBedroom');
    Route::get(
        'kelolaKamar/trash/restore',
        [ManageKamarController::class, 'restoreAll']
    )->name('restoreAllBedroom');
    Route::get(
        'kelolaKamar/trash/delete',
        [ManageKamarController::class, 'deletePermanentAll']
    )->name('deletePermanentAllBedroom');
    Route::get(
        'kelolaKamar/trash/{id}/restore',
        [ManageKamarController::class, 'restore']
    )->name('restoreBedroom');

    Route::resource('kelolaKamar', ManageKamarController::class);
});

Route::middleware('checkRole:2')->group(function () {
    Route::get('/dashboardPengajar', [DashboardController::class, 'index'])->name('dashboardPengajar');
});
