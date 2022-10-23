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