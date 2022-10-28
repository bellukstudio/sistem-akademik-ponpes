@if (Request::is('dashboardAdmin'))
    Dashboard
@endif

@if (Request::is('beritaAcara*'))
    Berita Acara
@endif


@if (Request::is('kelolaUser*'))
    Kelola User
@endif

@if (Request::is('kelolaTahunAkademik*'))
    Kelola Tahun Akademik
@endif


@if (Request::is('kelolaProgramAkademik*'))
    Kelola Program
@endif

@if (Request::is('kelolaKota*'))
    Kelola Kota
@endif

@if (Request::is('kelolaProvinsi*'))
    Kelola Provinsi
@endif

@if (Request::is('kelolaKamar*'))
    Kelola Kamar
@endif

@if (Request::is('kelolaRuangan*'))
    Kelola Ruang
@endif

@if (Request::is('kelolaKelas*'))
    Kelola Kelas
@endif
