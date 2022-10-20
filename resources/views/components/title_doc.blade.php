@if (Request::is('dashboardAdmin'))
    Dashboard
@endif

@if (Request::is('beritaAcara*'))
    Berita Acara
@endif

{{-- @if (Route::is('trashBeritaAcara'))
    Trash Bin (Berita Acara)
@endif --}}

@if (Request::is('manageUser*'))
    Kelola User
@endif

@if (Request::is('manageTahunAkademik*'))
    Kelola Tahun Akademik
@endif

{{-- @if (Route::is('trashTahunAkademik'))
    Trash Bin (Tahun Akademik)
@endif --}}

@if (Request::is('manageProgram*'))
    Kelola Program
@endif
