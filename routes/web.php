<?php

use App\Http\Controllers\Absen\ManagePresensiController;
use App\Http\Controllers\Akademik\ManageJadwalController;
use App\Http\Controllers\Akademik\ManageJadwalPiketController;
use App\Http\Controllers\Akademik\ManageKelompokKamar;
use App\Http\Controllers\Akademik\ManageKelompokKelas;
use App\Http\Controllers\Akademik\ManagePenilaianController;
use App\Http\Controllers\Akademik\ManagePenilaianHafalanController;
use App\Http\Controllers\Auth\ActivationController;
use App\Http\Controllers\Master\ManageTahunAkademikController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Berita\BeritaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\File\GoogleDriveController;
use App\Http\Controllers\File\ManageFileShareController;
use App\Http\Controllers\Master\ManageAbsenController;
use App\Http\Controllers\Master\ManageKamarController;
use App\Http\Controllers\Master\ManageKategoriMapelController;
use App\Http\Controllers\Master\ManageKategoriNilaiController;
use App\Http\Controllers\Master\ManageKelasController;
use App\Http\Controllers\Master\ManageKotaController;
use App\Http\Controllers\Master\ManageMapelController;
use App\Http\Controllers\Master\ManagePembayaranController;
use App\Http\Controllers\Master\ManagePengajarController;
use App\Http\Controllers\Master\ManagePengurusController;
use App\Http\Controllers\Master\ManagePiketController;
use App\Http\Controllers\Master\ManageProgramController;
use App\Http\Controllers\Master\ManageProvinsiController;
use App\Http\Controllers\Master\ManageRuanganController;
use App\Http\Controllers\Master\ManageSantriController;
use App\Http\Controllers\Master\ManageUserController;
use App\Http\Controllers\Pembayaran\ManageTrxPembayaranController;
use App\Http\Controllers\Perizinan\ManagePerizinanController;
use App\Http\Controllers\Report\LaporanNilaiAkhirController;
use App\Http\Controllers\Report\LaporanNilaiHafalanController;
use App\Http\Controllers\Report\LaporanPembayaranController;
use App\Http\Controllers\Report\LaporanPerizinanController;
use App\Http\Controllers\Report\LaporanPresensiController;

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
     * [ROUTE DATA WITH RESPONSE JSON]
     */
    Route::get(
        'kelolaPengajar/all',
        [ManagePengajarController::class, 'getAllTeachers']
    )->name('allTeachers');
    Route::get(
        'kelolaKelas/allClass',
        [ManageKelasController::class, 'getAllClass']
    )->name('allClass');
    Route::get(
        'kelolaProgramAkademik/all',
        [ManageProgramController::class, 'getAllProgram']
    )->name('getAllProgram');
    Route::get(
        'kategoriNilai/getByProgramId',
        [ManageKategoriNilaiController::class, 'getCategoryAssessmentByProgramId']
    )->name('getCategoryAssessmentByProgramId');
    Route::get(
        'kelolaKelas/byProgram/{id}',
        [ManageKelasController::class, 'getAllClassByProgram']
    )->name('classByProgram');
    Route::get(
        'kelolaMapel/getCourseByProgram',
        [ManageMapelController::class, 'getAllCourseByProgram']
    )->name('getAllCourseByProgram');
    Route::get('kelolaUser/userByRoles', [ManageUserController::class, 'getUserByRoles'])->name('getUserByRoles');
    Route::get(
        'kelolaSantri/{class_id}/getStudentByClass',
        [ManageSantriController::class, 'getStudentByClass']
    )->name('getStudentByClass');
    // Route::get('kelolaSantri/all', [ManageSantriController::class, 'getAllStudents'])->name('allStudents');
    ///
    /**
     * END ROUTE
     */
    /**
     * [ROUTE MANAGE NEWS / BERITA ACARA]
     */
    Route::get('beritaAcara/read', [BeritaController::class, 'readNews'])->name('readNews');
    Route::resource('beritaAcara', BeritaController::class);
    /**
     * [MIDDLEWARE ADMIN]
     * Master data
     */
    Route::middleware('isAdmin')->group(function () {
        /**
         * [ROUTE MANAGE NEWS / BERITA ACARA]
         */
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


        /**
         * [ROUTE MANAGE USER]
         */
        Route::resource('kelolaUser', ManageUserController::class)
            ->except(['show', 'create', 'store', 'edit']);


        /**
         * [ROUTE MANAGE PERIOD / TAHUN AKADEMIK]
         */
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
         * [ROUTE ACADEMIC PROGRAM / PROGRAM AKADEMIK]
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
         * [ROUTE MANAGE CITY / KOTA]
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
         * [ROUTE MANAGE PROVINCE / PROVINSI]
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
         * [ROUTE MANAGE BEDROOM / KAMAR]
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
         * [ROUTE MANAGE ROOM / RUANGAN]
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
         * [ROUTE MANAGE CLASS / KELAS]
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
         * [ROUTE MANAGE TEACHER / PENGAJAR]
         */
        Route::get(
            'kelolaPengajar/teacherCaretakers',
            [ManagePengajarController::class, 'getAllTeachersCaretakers']
        )->name('allTeachersCaretakers');
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
         * [ROUTE MANAGE STUDENT / SANTRI]
         */
        Route::get('kelolaSantri/userByEmail', [
            ManageSantriController::class,
            'getStudentByEmail'
        ])->name('getStudentByEmail');
        Route::get(
            'kelolaSantri/byProgramInClassGroup/{id}',
            [ManageSantriController::class, 'getAllStudentsByProgramClass']
        )->name('studentByProgramInClassGroup');
        Route::get(
            'kelolaSantri/byProgram/{id}',
            [ManageSantriController::class, 'getAllStudentsByProgram']
        )->name('studentByProgram');
        Route::get(
            'kelolaSantri/byProgram/{id}/room',
            [ManageSantriController::class, 'getAllStudentsByProgramRoom']
        )->name('studentByProgramRoom');
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
         * [ROUTE PENGURUS]
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
         * [ROUTE MANAGE PRESENCE / ATTENDANCE / ABSENSI]
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
         * [ROUTE MANAGE PAYMENTS]
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
         * [ROUTE MANAGE COURSE]
         */
        Route::get('kelolaMapel/allCourse', [ManageMapelController::class, 'getAllCourse'])->name('allCourse');
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

        /**
         * [ROUTE MANAGE CATEGORIES COURSE]
         */
        Route::get(
            'kategoriMapel/all',
            [ManageKategoriMapelController::class, 'getAllCategoryCourse']
        )->name('getAllCategoryCourse');
        Route::get(
            'kategoriMapel/trash',
            [ManageKategoriMapelController::class, 'trash']
        )->name('trashCategorieSchedule');
        Route::get(
            'kategoriMapel/trash/{id}/delete',
            [ManageKategoriMapelController::class, 'deletePermanent']
        )->name('deletePermanentCategorieSchedule');
        Route::get(
            'kategoriMapel/trash/restore',
            [ManageKategoriMapelController::class, 'restoreAll']
        )->name('restoreAllCategorieSchedule');
        Route::get(
            'kategoriMapel/trash/delete',
            [ManageKategoriMapelController::class, 'deletePermanentAll']
        )->name('deletePermanentAllCategorieSchedule');
        Route::get(
            'kategoriMapel/trash/{id}/restore',
            [ManageKategoriMapelController::class, 'restore']
        )->name('restoreCategorieSchedule');
        Route::resource('kategoriMapel', ManageKategoriMapelController::class)->except(['create', 'show', 'edit']);
        /**
         * [ROUTE MANAGE EBOOK FILE]
         */
        Route::get('ebook', [ManageFileShareController::class, 'indexEbook'])->name('ebook.index');
        Route::post('ebook', [ManageFileShareController::class, 'uploadFileToGdrive'])->name('ebook.store');
        Route::delete('ebook/{id}/delete', [ManageFileShareController::class, 'destroy'])->name('ebook.destroy');
        Route::put('ebook/{id}/update', [ManageFileShareController::class, 'update'])->name('ebook.update');
        /**
         * [ROUTE MANAGE VIDEO URL]
         */
        Route::get('video', [ManageFileShareController::class, 'indexVideo'])->name('video.index');
        Route::post('video', [ManageFileShareController::class, 'saveVideo'])->name('video.store');
        Route::put('video/{id}/update', [ManageFileShareController::class, 'updateVideo'])->name('video.update');
        Route::delete('video/{id}/delete', [ManageFileShareController::class, 'destroyVideo'])->name('video.destroy');

        /**
         * [ROUTE GOOGLE SIGN IN]
         */
        Route::get(
            'google/login',
            [GoogleDriveController::class, 'googleAuth']
        )->name('google.login');
        Route::get('google/checkToken', [GoogleDriveController::class, 'checkRefreshToken'])->name('google.check');

        /**
         * [ROUTE ACADEMIC]
         */
        /**
         * [ROUTE SCHEDULE]
         */
        Route::post(
            'jadwalPelajaran/filter',
            [
                ManageJadwalController::class, 'filterScheduleByCategories'
            ]
        )->name('getAllSchedule');
        Route::get(
            'jadwalPelajaran/filter',
            [
                ManageJadwalController::class, 'filterScheduleByCategories'
            ]
        )->name('getAllSchedule');
        Route::resource('jadwalPelajaran', ManageJadwalController::class)->except('show');
        /**
         * [ROUTE PICKET SCHEDULE]
         */
        Route::get(
            'jadwalPiket/filter',
            [
                ManageJadwalPiketController::class,
                'filterDataByCategory'
            ]
        )->name('filterDataPicket');
        Route::post(
            'jadwalPiket/filter',
            [
                ManageJadwalPiketController::class,
                'filterDataByCategory'
            ]
        )->name('filterDataPicket');
        Route::resource('jadwalPiket', ManageJadwalPiketController::class)->except('show');
        /**
         * [ROUTE CLASS GROUPS]
         */
        Route::resource('kelompokKelas', ManageKelompokKelas::class)->except('show');
        /**
         * [ROUTE ROOM GROUPS]
         */
        Route::resource('kelompokKamar', ManageKelompokKamar::class)->except('show');
        /**
         * [ROUTE CATEGORIES ASSESSMENT]
         */
        Route::resource('kategoriNilai', ManageKategoriNilaiController::class)->except(['show', 'edit', 'create']);
        /**
         * [ROUTE MASTER PICKETS]
         */
        Route::get('kategoriPiket/trash', [ManagePiketController::class, 'trash'])->name('trashPicketCategories');
        Route::get(
            'kategoriPiket/trash/{id}/delete',
            [ManagePiketController::class, 'deletePermanent']
        )->name('deletePermanentPicketCategories');
        Route::get(
            'kategoriPiket/trash/restore',
            [ManagePiketController::class, 'restoreAll']
        )->name('restoreAllPicketCategories');
        Route::get(
            'kategoriPiket/trash/delete',
            [ManagePiketController::class, 'deletePermanentAll']
        )->name('deletePermanentAllPicketCategories');
        Route::get(
            'kategoriPiket/trash/{id}/restore',
            [ManagePiketController::class, 'restore']
        )->name('restorePicketCategories');
        Route::resource('kategoriPiket', ManagePiketController::class)->except(['create', 'edit', 'show']);
        /**
         * [ROUTE PERMITS ADMIN]
         */
        // Route::get('perizinan/trash', [ManagePerizinanController::class, 'trash'])->name('trashPermit');
        // Route::get(
        //     'perizinan/trash/{id}/delete',
        //     [ManagePerizinanController::class, 'deletePermanent']
        // )->name('deletePermanentPermit');
        // Route::get(
        //     'perizinan/trash/restore',
        //     [ManagePerizinanController::class, 'restoreAll']
        // )->name('restoreAllPermit');
        // Route::get(
        //     'perizinan/trash/delete',
        //     [ManagePerizinanController::class, 'deletePermanentAll']
        // )->name('deletePermanentAllPermit');
        // Route::get(
        //     'perizinan/trash/{id}/restore',
        //     [ManagePerizinanController::class, 'restore']
        // )->name('restorePermit');
        ///
        Route::put('perizinan/{id}/change', [ManagePerizinanController::class, 'updatePermit'])
            ->name('updatePermit');
        /**
         * [ROUTE PAYMENT ADMIN]
         */
        Route::put(
            'pembayaran/{id}/updateUserPayment',
            [ManageTrxPembayaranController::class, 'updateUserPayment']
        )->name('updateUserPayment');
        /**
         * import file
         */
        Route::get('/import', [DashboardController::class, 'importRedirect']);
        Route::post('/import', [DashboardController::class, 'importFile'])->name('import');
        /**
         * [ROUTE REPORT / LAPORAN]
         */
        /// [ROUTE REPORT PRESENSI]
        Route::controller(LaporanPresensiController::class)->group(function () {
            Route::get('/laporan-presensi', 'index')->name('presensi-report.index');
            Route::post('/laporan-presensi/pdf', 'filter')->name('presensi-report.filter');
        });
        /// [ROUTE REPORT PERIZINAN / PERMIT]
        Route::controller(LaporanPerizinanController::class)->group(function () {
            Route::get('/laporan-perizinan', 'index')->name('perizinan-report.index');
            Route::post('/laporan-perizinan/pdf', 'filter')->name('perizinan-report.filter');
        });
        ///[ROUTE REPORT PEMBAYARAN / PAYMENT]
        Route::controller(LaporanPembayaranController::class)->group(function () {
            Route::get('/laporan-pembayaran', 'index')->name('pembayaran-report.index');
            Route::post('/laporan-pembayaran', 'filter')->name('pembayaran-report.filter');
        });
        ///[ROUTE REPORT NILAI HAFALAN / MEMORIZE SURAH]
        Route::controller(LaporanNilaiHafalanController::class)->group(function () {
            Route::get('laporan-nilai-hafalan', 'index')->name('nilai-hafalan-report.index');
            Route::post('laporan-nilai-hafalan/pdf', 'filter')->name('nilai-hafalan-report.filter');
        });
        ///[ROUTE REPORT FINAL ASSESSMENT / PENILAIAN AKHIR]
        Route::controller(LaporanNilaiAkhirController::class)->group(function () {
            Route::get('laporan-penilaian-akhir', 'index')->name('penilaian-akhir-report.index');
            Route::post('laporan-penilaian-akhir/pdf', 'filter')->name('penilaian-akhir-report.filter');
        });
    });
    /**
     * [ROUTE DASHBOARD]
     */
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    /**
     * [ROUTE PERMITS]
     */

    Route::resource('perizinan', ManagePerizinanController::class)->except(['show']);
    /**
     * [ROUTE ATTENNDANCES STUDENT]
     */
    Route::get(
        'presensi/action/saveAttendance',
        [ManagePresensiController::class, 'saveAttendance']
    )->name('saveAttendance');
    Route::resource('presensi', ManagePresensiController::class)
        ->except(['show', 'edit', 'create', 'store']);
    /**
     * [ROUTE PAYMENTS]
     */
    Route::resource('pembayaran', ManageTrxPembayaranController::class)
        ->except(['show']);

    /**
     * [ROUTE MEMORIZE SURAH]
     */
    Route::get('hafalanSurah', [ManagePenilaianHafalanController::class, 'index'])->name('hafalanSurah.index');
    Route::get('hafalanSurah/create', [ManagePenilaianHafalanController::class, 'create'])->name('hafalanSurah.create');
    Route::delete(
        'hafalanSurah/{id}/destroy',
        [ManagePenilaianHafalanController::class, 'destroy']
    )->name('hafalanSurah.destroy');
    Route::post(
        'hafalanSurah/create/{student}/{class}',
        [ManagePenilaianHafalanController::class, 'store']
    )->name('hafalanSurah.store');
    Route::get(
        'hafalanSurah/getVerseBySurah',
        [ManagePenilaianHafalanController::class, 'getVerseBySurahNamed']
    )->name('getVerseBySurahNamed');

    /**
     * [ROUTE ASSESSMENT / PENILAIAN AKHIR]
     */
    Route::get('penilaianAkhir', [ManagePenilaianController::class, 'index'])->name('penilaianAkhir.index');
    Route::get('penilaianAkhir/create', [ManagePenilaianController::class, 'create'])->name('penilaianAkhir.create');
    Route::delete(
        'penilaianAkhir/{id}/destroy',
        [ManagePenilaianController::class, 'destroy']
    )->name('penilaianAkhir.destroy');
    Route::post(
        'penilaianAkhir/create/{id}',
        [ManagePenilaianController::class, 'store']
    )->name('penilaianAkhir.store');
});
