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
Breadcrumbs::for('trashberitaAcara', function (BreadcrumbTrail $trail) {
    $trail->parent('beritaAcara');
    $trail->push('Trash Bin', route('trashBeritaAcara'));
});


/**
 * manage user
 */

Breadcrumbs::for('manageUser', function (BreadcrumbTrail $trail) {
    $trail->push('Data User', route('manageUser.index'));
});


/**
 * manage tahunn akademik
 */
Breadcrumbs::for('manageTahunAkademik', function (BreadcrumbTrail $trail) {
    $trail->push('Data Tahun Akademik', route('manageTahunAkademik.index'));
});
Breadcrumbs::for('trashTahunAkademik', function (BreadcrumbTrail $trail) {
    $trail->parent('manageTahunAkademik');
    $trail->push('Trash Bin', route('trashTahunAkademik'));
});
