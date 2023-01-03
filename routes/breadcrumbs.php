<?php

use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

/**
 * berita acara
 */

Breadcrumbs::for('beritaAcara', function (BreadcrumbTrail $trail) {
    $trail->push('Data Berita Acara', route('beritaAcara.index'));
});
Breadcrumbs::for('beritaAcara.create', function (BreadcrumbTrail $trail) {
    $trail->parent('beritaAcara');
    $trail->push('Tambah Data', route('beritaAcara.create'));
});
Breadcrumbs::for('beritaAcara.edit', function (BreadcrumbTrail $trail, $berita) {
    $trail->parent('beritaAcara');
    $trail->push('Edit Data', route('beritaAcara.edit', $berita->id));
});
Breadcrumbs::for('beritaAcara.trash', function (BreadcrumbTrail $trail) {
    $trail->parent('beritaAcara');
    $trail->push('Trash Bin', route('trashBeritaAcara'));
});


/**
 * manage user
 */

Breadcrumbs::for('kelolaUser', function (BreadcrumbTrail $trail) {
    $trail->push('Data User', route('kelolaUser.index'));
});


/**
 * manage tahunn akademik
 */
Breadcrumbs::for('kelolaTahunAkademik', function (BreadcrumbTrail $trail) {
    $trail->push('Data Tahun Akademik', route('kelolaTahunAkademik.index'));
});
Breadcrumbs::for('kelolaTahunAkademik.trash', function (BreadcrumbTrail $trail) {
    $trail->parent('kelolaTahunAkademik');
    $trail->push('Trash Bin', route('trashTahunAkademik'));
});


/**
 * manage program
 */
Breadcrumbs::for('kelolaProgramAkademik', function (BreadcrumbTrail $trail) {
    $trail->push('Data Program', route('kelolaProgramAkademik.index'));
});
Breadcrumbs::for('kelolaProgramAkademik.trash', function (BreadcrumbTrail $trail) {
    $trail->parent('kelolaProgramAkademik');
    $trail->push('Trash Bin', route('trashProgram'));
});


/**
 * manage kota
 */
Breadcrumbs::for('kelolaKota', function (BreadcrumbTrail $trail) {
    $trail->push('Data Kota', route('kelolaKota.index'));
});
Breadcrumbs::for('kelolaKota.create', function (BreadcrumbTrail $trail) {
    $trail->parent('kelolaKota');
    $trail->push('Tambah Data Baru', route('kelolaKota.create'));
});
Breadcrumbs::for('kelolaKota.edit', function (BreadcrumbTrail $trail, $city) {
    $trail->parent('kelolaKota');
    $trail->push('Edit Data', route('kelolaKota.edit', $city->id));
});
Breadcrumbs::for('kelolaKota.trash', function (BreadcrumbTrail $trail) {
    $trail->parent('kelolaKota');
    $trail->push('Trash Bin', route('trashCity'));
});

/**
 * manage provinsi
 */
Breadcrumbs::for('kelolaProvinsi', function (BreadcrumbTrail $trail) {
    $trail->push('Data Provinsi', route('kelolaProvinsi.index'));
});
Breadcrumbs::for('kelolaProvinsi.trash', function (BreadcrumbTrail $trail) {
    $trail->parent('kelolaProvinsi');
    $trail->push('Trash Bin', route('trashProvince'));
});
/**
 * manage kamar
 */
Breadcrumbs::for('kelolaKamar', function (BreadcrumbTrail $trail) {
    $trail->push('Data Kamar', route('kelolaKamar.index'));
});
Breadcrumbs::for('kelolaKamar.trash', function (BreadcrumbTrail $trail) {
    $trail->parent('kelolaKamar');
    $trail->push('Trash Bin', route('trashBedroom'));
});

/**
 * manage ruangan
 */
Breadcrumbs::for('kelolaRuangan', function (BreadcrumbTrail $trail) {
    $trail->push('Data Ruangan', route('kelolaRuangan.index'));
});
Breadcrumbs::for('kelolaRuangan.trash', function (BreadcrumbTrail $trail) {
    $trail->parent('kelolaRuangan');
    $trail->push('Trash Bin', route('trashRoom'));
});

/**
 * manage kelas
 */
Breadcrumbs::for('kelolaKelas', function (BreadcrumbTrail $trail) {
    $trail->push('Data Kelas', route('kelolaKelas.index'));
});
Breadcrumbs::for('kelolaKelas.trash', function (BreadcrumbTrail $trail) {
    $trail->parent('kelolaKelas');
    $trail->push('Trash Bin', route('trashClass'));
});

/**
 * manage pengajar
 */
Breadcrumbs::for('kelolaPengajar', function (BreadcrumbTrail $trail) {
    $trail->push('Data Pengajar', route('kelolaPengajar.index'));
});
Breadcrumbs::for('kelolaPengajar.create', function (BreadcrumbTrail $trail) {
    $trail->parent('kelolaPengajar');
    $trail->push('Tambah Data ', route('kelolaPengajar.create'));
});
Breadcrumbs::for('kelolaPengajar.edit', function (BreadcrumbTrail $trail, $teachers) {
    $trail->parent('kelolaPengajar');
    $trail->push('Edit Data ', route('kelolaPengajar.edit', $teachers->id));
});
Breadcrumbs::for('kelolaPengajar.show', function (BreadcrumbTrail $trail, $teachers) {
    $trail->parent('kelolaPengajar');
    $trail->push('Data ' . $teachers->name . '', route('kelolaPengajar.edit', $teachers->id));
});
Breadcrumbs::for('kelolaPengajar.trash', function (BreadcrumbTrail $trail) {
    $trail->parent('kelolaPengajar');
    $trail->push('Trash Bin', route('trashTeachers'));
});

/**
 * manage santri
 */
Breadcrumbs::for('kelolaSantri', function (BreadcrumbTrail $trail) {
    $trail->push('Data Santri', route('kelolaSantri.index'));
});
Breadcrumbs::for('kelolaSantri.create', function (BreadcrumbTrail $trail) {
    $trail->parent('kelolaSantri');
    $trail->push('Tambah Data ', route('kelolaSantri.create'));
});
Breadcrumbs::for('kelolaSantri.edit', function (BreadcrumbTrail $trail, $students) {
    $trail->parent('kelolaSantri');
    $trail->push('Edit Data ', route('kelolaSantri.edit', $students->id));
});
Breadcrumbs::for('kelolaSantri.show', function (BreadcrumbTrail $trail, $students) {
    $trail->parent('kelolaSantri');
    $trail->push('Data ' . $students->name . '', route('kelolaSantri.edit', $students->id));
});
Breadcrumbs::for('kelolaSantri.trash', function (BreadcrumbTrail $trail) {
    $trail->parent('kelolaSantri');
    $trail->push('Trash Bin', route('trashStudents'));
});

/**
 * manage pengurus
 */
Breadcrumbs::for('kelolaPengurus', function (BreadcrumbTrail $trail) {
    $trail->push('Data Pengurus', route('kelolaPengurus.index'));
});
Breadcrumbs::for('kelolaPengurus.create', function (BreadcrumbTrail $trail) {
    $trail->parent('kelolaPengurus');
    $trail->push('Tambah Data ', route('kelolaPengurus.create'));
});
Breadcrumbs::for('kelolaPengurus.edit', function (BreadcrumbTrail $trail, $data) {
    $trail->parent('kelolaPengurus');
    $trail->push('Edit Data ', route('kelolaPengurus.edit', $data->id));
});
Breadcrumbs::for('kelolaPengurus.trash', function (BreadcrumbTrail $trail) {
    $trail->parent('kelolaPengurus');
    $trail->push('Trash Bin ', route('trashCaretakers'));
});

/**
 * manage absen
 */
Breadcrumbs::for('kelolaAbsen', function (BreadcrumbTrail $trail) {
    $trail->push('Data Absen', route('kelolaAbsen.index'));
});
Breadcrumbs::for('kelolaAbsen.trash', function (BreadcrumbTrail $trail) {
    $trail->parent('kelolaAbsen');
    $trail->push('Trash Bin', route('trashAttendance'));
});
/**
 * manage pembayaran
 */
Breadcrumbs::for('kelolaPembayaran', function (BreadcrumbTrail $trail) {
    $trail->push('Data Pembayaran', route('kelolaPembayaran.index'));
});
Breadcrumbs::for('kelolaPembayaran.trash', function (BreadcrumbTrail $trail) {
    $trail->parent('kelolaPembayaran');
    $trail->push('Trash Bin', route('trashPayment'));
});

/**
 * data perizinan
 */
Breadcrumbs::for('perizinan', function (BreadcrumbTrail $trail) {
    $trail->push('Data Perizinan', route('perizinan.index'));
});
Breadcrumbs::for('perizinan.trash', function (BreadcrumbTrail $trail) {
    $trail->parent('perizinan');
    $trail->push('Trash Bin', route('trashPermit'));
});
/**
 * data mapel
 */
Breadcrumbs::for('kelolaMapel', function (BreadcrumbTrail $trail) {
    $trail->push('Data Mata Pelajaran', route('kelolaMapel.index'));
});
Breadcrumbs::for('kelolaMapel.trash', function (BreadcrumbTrail $trail) {
    $trail->parent('kelolaMapel');
    $trail->push('Trash Bin', route('trashCourse'));
});

/**
 * data jadwal pelajaran
 */
Breadcrumbs::for('kelolaJadwal', function (BreadcrumbTrail $trail) {
    $trail->push('Jadwal Pelajaran', route('jadwalPelajaran.index'));
});
Breadcrumbs::for('kelolaJadwal.create', function (BreadcrumbTrail $trail) {
    $trail->parent('kelolaJadwal');
    $trail->push('Tambah Data', route('jadwalPelajaran.create'));
});
Breadcrumbs::for('kelolaJadwal.edit', function (BreadcrumbTrail $trail, $schedule) {
    $trail->parent('kelolaJadwal');
    $trail->push('Edit Data', route('jadwalPelajaran.edit', $schedule->id));
});
/**
 * manage kategori mapel
 */
Breadcrumbs::for('kategoriMapel', function (BreadcrumbTrail $trail) {
    $trail->push('Data Kategori Mapel', route('kategoriMapel.index'));
});
Breadcrumbs::for('kategoriMapel.trash', function (BreadcrumbTrail $trail) {
    $trail->parent('kategoriMapel');
    $trail->push('Trash Bin', route('trashCategorieSchedule'));
});
/**
 * data jadwal piket
 */
Breadcrumbs::for('jadwalPiket', function (BreadcrumbTrail $trail) {
    $trail->push('Jadwal Piket', route('jadwalPiket.index'));
});
Breadcrumbs::for('jadwalPiket.create', function (BreadcrumbTrail $trail) {
    $trail->parent('jadwalPiket');
    $trail->push('Tambah Data', route('jadwalPiket.create'));
});
Breadcrumbs::for('jadwalPiket.edit', function (BreadcrumbTrail $trail, $schedule) {
    $trail->parent('jadwalPiket');
    $trail->push('Edit Data', route('jadwalPiket.edit', $schedule->id));
});
/**
 * data kelompok kelas
 */
Breadcrumbs::for('kelompokKelas', function (BreadcrumbTrail $trail) {
    $trail->push('Kelompok Kelas', route('kelompokKelas.index'));
});
Breadcrumbs::for('kelompokKelas.create', function (BreadcrumbTrail $trail) {
    $trail->parent('kelompokKelas');
    $trail->push('Tambah Data', route('kelompokKelas.create'));
});
Breadcrumbs::for('kelompokKelas.edit', function (BreadcrumbTrail $trail, $data) {
    $trail->parent('kelompokKelas');
    $trail->push('Edit Data', route('kelompokKelas.edit', $data->id));
});
/**
 * data kelompok kamar
 */
Breadcrumbs::for('kelompokKamar', function (BreadcrumbTrail $trail) {
    $trail->push('Kelompok Kamar', route('kelompokKamar.index'));
});
Breadcrumbs::for('kelompokKamar.create', function (BreadcrumbTrail $trail) {
    $trail->parent('kelompokKamar');
    $trail->push('Tambah Data', route('kelompokKamar.create'));
});
Breadcrumbs::for('kelompokKamar.edit', function (BreadcrumbTrail $trail, $data) {
    $trail->parent('kelompokKamar');
    $trail->push('Edit Data', route('kelompokKamar.edit', $data->id));
});
