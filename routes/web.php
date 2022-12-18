<?php

use App\Http\Controllers\Akademik\ManageJadwalController;
use App\Http\Controllers\Akademik\ManageJadwalPiketController;
use App\Http\Controllers\Auth\ActivationController;
use App\Http\Controllers\Master\ManageTahunAkademikController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Berita\BeritaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Master\ManageAbsenController;
use App\Http\Controllers\Master\ManageKamarController;
use App\Http\Controllers\Master\ManageKelasController;
use App\Http\Controllers\Master\ManageKotaController;
use App\Http\Controllers\Master\ManageMapelController;
use App\Http\Controllers\Master\ManagePembayaranController;
use App\Http\Controllers\Master\ManagePengajarController;
use App\Http\Controllers\Master\ManagePengurusController;
use App\Http\Controllers\Master\ManageProgramController;
use App\Http\Controllers\Master\ManageProvinsiController;
use App\Http\Controllers\Master\ManageRuanganController;
use App\Http\Controllers\Master\ManageSantriController;
use App\Http\Controllers\Master\ManageUserController;
use App\Http\Controllers\Perizinan\ManagePerizinanController;
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

//email activation
Route::get('/aktivasi', [ActivationController::class, 'activation'])->name('activate');
Route::post('/send-email', [ActivationController::class, 'sendEmail'])->name('sendEmail');
Route::get('aktivasi/{hash}', [ActivationController::class, 'redemCode'])->name('redemCode');
Route::middleware(['auth'])->group(function () {
    /**
     * Middleware Admin
     * Master data
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
        Route::get('kelolaPengajar/all', [ManagePengajarController::class, 'getAllTeachers'])->name('allTeachers');
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
        Route::get('kelolaSantri/all', [ManageSantriController::class, 'getAllStudents'])->name('allStudents');
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

        /**
         * manage pengurus
         */
        Route::get('kelolaPengurus/trash', [ManagePengurusController::class, 'trash'])->name('trashCaretakers');
        Route::get(
            'kelolaPengurus/trash/{id}/delete',
            [ManagePengurusController::class, 'deletePermanent']
        )->name('deletePermanentCaretakers');
        Route::get(
            'kelolaPengurus/trash/restore',
            [ManagePengurusController::class, 'restoreAll']
        )->name('restoreAllCaretakers');
        Route::get(
            'kelolaPengurus/trash/delete',
            [ManagePengurusController::class, 'deletePermanentAll']
        )->name('deletePermanentAllCaretakers');
        Route::get(
            'kelolaPengurus/trash/{id}/restore',
            [ManagePengurusController::class, 'restore']
        )->name('restoreCaretakers');
        Route::resource('kelolaPengurus', ManagePengurusController::class)->except('show');

        /**
         * manage absen
         */
        Route::get('kelolaAbsen/trash', [ManageAbsenController::class, 'trash'])->name('trashAttendance');
        Route::get(
            'kelolaAbsen/trash/{id}/delete',
            [ManageAbsenController::class, 'deletePermanent']
        )->name('deletePermanentAttendance');
        Route::get(
            'kelolaAbsen/trash/restore',
            [ManageAbsenController::class, 'restoreAll']
        )->name('restoreAllAttendance');
        Route::get(
            'kelolaAbsen/trash/delete',
            [ManageAbsenController::class, 'deletePermanentAll']
        )->name('deletePermanentAllAttendance');
        Route::get(
            'kelolaAbsen/trash/{id}/restore',
            [ManageAbsenController::class, 'restore']
        )->name('restoreAttendance');
        Route::resource('kelolaAbsen', ManageAbsenController::class)->except(['create', 'show', 'edit']);
        /**
         * manage pembayaran
         */
        Route::get('kelolaPembayaran/trash', [ManagePembayaranController::class, 'trash'])->name('trashPayment');
        Route::get(
            'kelolaPembayaran/trash/{id}/delete',
            [ManagePembayaranController::class, 'deletePermanent']
        )->name('deletePermanentPayment');
        Route::get(
            'kelolaPembayaran/trash/restore',
            [ManagePengurusCManagePembayaranControllerontroller::class, 'restoreAll']
        )->name('restoreAllPayments');
        Route::get(
            'kelolaPembayaran/trash/delete',
            [ManagePembayaranController::class, 'deletePermanentAll']
        )->name('deletePermanentAllPayment');
        Route::get(
            'kelolaPembayaran/trash/{id}/restore',
            [ManagePembayaranController::class, 'restore']
        )->name('restorePayment');
        Route::resource('kelolaPembayaran', ManagePembayaranController::class)->except(['create', 'show', 'edit']);

        /**
         * manage mapel
         */
        Route::get('kelolaMapel/trash', [ManageMapelController::class, 'trash'])->name('trashCourse');
        Route::get(
            'kelolaMapel/trash/{id}/delete',
            [ManageMapelController::class, 'deletePermanent']
        )->name('deletePermanentCourse');
        Route::get(
            'kelolaMapel/trash/restore',
            [ManageMapelController::class, 'restoreAll']
        )->name('restoreAllCourse');
        Route::get(
            'kelolaMapel/trash/delete',
            [ManageMapelController::class, 'deletePermanentAll']
        )->name('deletePermanentAllCourse');
        Route::get(
            'kelolaMapel/trash/{id}/restore',
            [ManageMapelController::class, 'restore']
        )->name('restoreCourse');
        Route::resource('kelolaMapel', ManageMapelController::class)->except(['create', 'show', 'edit']);
    });

    /**
     * route dashboard
     */
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    /**
     * route perzinan
     */
    Route::get('perizinan/trash', [ManagePerizinanController::class, 'trash'])->name('trashPermit');
    Route::get(
        'perizinan/trash/{id}/delete',
        [ManagePerizinanController::class, 'deletePermanent']
    )->name('deletePermanentPermit');
    Route::get(
        'perizinan/trash/restore',
        [ManagePerizinanController::class, 'restoreAll']
    )->name('restoreAllPermit');
    Route::get(
        'perizinan/trash/delete',
        [ManagePerizinanController::class, 'deletePermanentAll']
    )->name('deletePermanentAllPermit');
    Route::get(
        'perizinan/trash/{id}/restore',
        [ManagePerizinanController::class, 'restore']
    )->name('restorePermit');
    Route::resource('perizinan', ManagePerizinanController::class)->except(['create', 'show', 'edit', 'store']);

    /**
     * route akademik
     */
    /**
     * route jadwal pelajaran
     */
    Route::resource('jadwalPelajaran', ManageJadwalController::class)->except('show');
    /**
     * route jadwal piket
     */
    Route::resource('jadwalPiket', ManageJadwalPiketController::class)->except('show');
});
