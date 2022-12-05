<?php

use App\Http\Controllers\Master\ManageTahunAkademikController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Berita\BeritaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Master\ManageKamarController;
use App\Http\Controllers\Master\ManageKelasController;
use App\Http\Controllers\Master\ManageKotaController;
use App\Http\Controllers\Master\ManagePengajarController;
use App\Http\Controllers\Master\ManageProgramController;
use App\Http\Controllers\Master\ManageProvinsiController;
use App\Http\Controllers\Master\ManageRuanganController;
use App\Http\Controllers\Master\ManageSantriController;
use App\Http\Controllers\Master\ManageUserController;
use PHPUnit\TextUI\XmlConfiguration\Group;

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
Route::get('/', [AuthController::class, 'index'])->name('login');

Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate'])->name('authenticate');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


Route::middleware('auth')->group(function () {
    /**
     * Middleware Admin
     */
    Route::middleware('isAdmin')->group(function () {
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
        Route::resource('beritaAcara', BeritaController::class)->except('show');

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
        Route::resource(
            'kelolaTahunAkademik',
            ManageTahunAkademikController::class
        )->except(['show', 'create', 'edit']);

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
        Route::resource('kelolaProgramAkademik', ManageProgramController::class)->except(['show', 'create', 'edit']);


        /**
         * manage kota
         */
        Route::get(
            'kelolaKota/cityByProvince/{id}',
            [ManageKotaController::class, 'getCityByProvinceId']
        )->name('getCityByProvinceId');
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
        Route::resource('kelolaKota', ManageKotaController::class)->except('show');


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

        Route::resource('kelolaProvinsi', ManageProvinsiController::class)->except(['create', 'show', 'edit']);

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

        Route::resource('kelolaKamar', ManageKamarController::class)->except(['create', 'show', 'edit']);


        /**
         * manage ruangan
         */
        Route::get('kelolaRuangan/trash', [ManageRuanganController::class, 'trash'])->name('trashRoom');
        Route::get(
            'kelolaRuangan/trash/{id}/delete',
            [ManageRuanganController::class, 'deletePermanent']
        )->name('deletePermanentRoom');
        Route::get(
            'kelolaRuangan/trash/restore',
            [ManageRuanganController::class, 'restoreAll']
        )->name('restoreAllRoom');
        Route::get(
            'kelolaRuangan/trash/delete',
            [ManageRuanganController::class, 'deletePermanentAll']
        )->name('deletePermanentAllRoom');
        Route::get(
            'kelolaRuangan/trash/{id}/restore',
            [ManageRuanganController::class, 'restore']
        )->name('restoreRoom');

        Route::resource('kelolaRuangan', ManageRuanganController::class)->except(['create', 'show', 'edit']);

        /**
         * manage kelas
         */
        Route::get('kelolaKelas/trash', [ManageKelasController::class, 'trash'])->name('trashClass');
        Route::get(
            'kelolaKelas/trash/{id}/delete',
            [ManageKelasController::class, 'deletePermanent']
        )->name('deletePermanentClass');
        Route::get(
            'kelolaKelas/trash/restore',
            [ManageKelasController::class, 'restoreAll']
        )->name('restoreAllClass');
        Route::get(
            'kelolaKelas/trash/delete',
            [ManageKelasController::class, 'deletePermanentAll']
        )->name('deletePermanentAllClass');
        Route::get(
            'kelolaKelas/trash/{id}/restore',
            [ManageKelasController::class, 'restore']
        )->name('restoreClass');

        Route::resource('kelolaKelas', ManageKelasController::class)->except(['create', 'show', 'edit']);

        /**
         * manage pengajar
         */
        Route::get('kelolaPengajar/trash', [ManagePengajarController::class, 'trash'])->name('trashTeachers');
        Route::get(
            'kelolaPengajar/trash/{id}/delete',
            [ManagePengajarController::class, 'deletePermanent']
        )->name('deletePermanentTeacher');
        Route::get(
            'kelolaPengajar/trash/restore',
            [ManagePengajarController::class, 'restoreAll']
        )->name('restoreAllTeachers');
        Route::get(
            'kelolaPengajar/trash/delete',
            [ManagePengajarController::class, 'deletePermanentAll']
        )->name('deletePermanentAllTeachers');
        Route::get(
            'kelolaPengajar/trash/{id}/restore',
            [ManagePengajarController::class, 'restore']
        )->name('restoreTeacher');

        Route::resource('kelolaPengajar', ManagePengajarController::class);

        /**
         * manage santri
         */
        Route::get('kelolaSantri/trash', [ManageSantriController::class, 'trash'])->name('trashStudents');
        Route::get(
            'kelolaSantri/trash/{id}/delete',
            [ManageSantriController::class, 'deletePermanent']
        )->name('deletePermanentStudent');
        Route::get(
            'kelolaSantri/trash/restore',
            [ManageSantriController::class, 'restoreAll']
        )->name('restoreAllStudents');
        Route::get(
            'kelolaSantri/trash/delete',
            [ManageSantriController::class, 'deletePermanentAll']
        )->name('deletePermanentAllStudents');
        Route::get(
            'kelolaSantri/trash/{id}/restore',
            [ManageSantriController::class, 'restore']
        )->name('restoreStudent');
        Route::resource('kelolaSantri', ManageSantriController::class);
    });

    /**
     * route dashboard
     */
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});
