@if (Request::is('dashboard'))
    Dashboard
@endif

@if (Request::is('beritaAcara*'))
    Berita Acara
@endif


@if (Request::is('kelolaUser*'))
    Master User
@endif

@if (Request::is('kelolaTahunAkademik*'))
    Master Tahun Akademik
@endif


@if (Request::is('kelolaProgramAkademik*'))
    Master Program
@endif

@if (Request::is('kelolaKota*'))
    Master Kota
@endif

@if (Request::is('kelolaProvinsi*'))
    Master Provinsi
@endif

@if (Request::is('kelolaKamar*'))
    Master Kamar
@endif

@if (Request::is('kelolaRuangan*'))
    Master Ruang
@endif

@if (Request::is('kelolaKelas*'))
    Master Kelas
@endif

@if (Request::is('kelolaPengajar*'))
    Master Pengajar
@endif

@if (Request::is('kelolaSantri*'))
    Master Santri
@endif
@if (Request::is('kelolaPengurus*'))
    Master Pengurus
@endif
@if (Request::is('kelolaAbsen*'))
    Master Absen
@endif
@if (Request::is('kelolaPembayaran*'))
    Master Pembayaran
@endif
@if (Request::is('kelolaMapel*'))
    Master Mata Pelajaran
@endif
@if (Request::is('kategoriMapel*'))
    Kategori Mapel
@endif
@if (Request::is('perizinan*'))
    Perizinan
@endif
@if (Request::is('jadwalPelajaran*'))
    Jadwal Pelajaran
@endif
@if (Request::is('jadwalPiket*'))
    Jadwal Piket
@endif
@if (Request::is('kelompokKelas*'))
    Kelompok Kelas
@endif
@if (Request::is('kelompokKamar*'))
    Kelompok Kamar
@endif
@if (Request::is('presensi*'))
    Presensi
@endif
@if (Request::is('pembayaran*'))
    Pembayaran
@endif
@if (Request::is('ebook*'))
    E-Book
@endif
@if (Request::is('video*'))
    Video
@endif
@if (Request::is('hafalanSurah*'))
    Nilai Hafalan
@endif
@if (Request::is('kategoriNilai*'))
    Kategori Nilai
@endif
@if (Request::is('penilaianAkhir*'))
    Penilaian Akhir
@endif
