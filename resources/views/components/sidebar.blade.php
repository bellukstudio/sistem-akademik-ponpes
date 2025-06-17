 <!-- Main Sidebar Container -->
 <aside class="main-sidebar sidebar-dark-primary elevation-4">
     <!-- Brand Logo -->
     <a href="{{ route('dashboard') }}" class="brand-link">
         <img src="{{ asset('template/img/logo.png') }}" alt=" Logo" class="brand-image img-circle elevation-3"
             style="opacity: 0.8" />
         <span class="brand-text font-weight-light">
             @if (Auth::user()->roles_id == 1)
                 Administrator
             @endif
             @if (Auth::user()->roles_id == 2)
                 Pengajar
             @endif
             @if (Auth::user()->roles_id == 3)
                 Pengurus
             @endif

         </span>
     </a>

     <!-- Sidebar -->
     <div class="sidebar">
         <div></div>

         <!-- Sidebar Menu -->
         <nav class="mt-2">
             <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                 data-accordion="false">
                 <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                 <li class="nav-item">
                     <a href="{{ route('dashboard') }}" class="nav-link {{ Request::is('dashboard') ? 'active' : '' }}">
                         <i class="nav-icon fas fa-tachometer-alt"></i>
                         <p>Dashboard</p>
                     </a>
                 </li>
                 @can('admin')
                     <li class="nav-header">KABAR BERITA</li>
                     <li class="nav-item">
                         <a href="{{ route('kelolaBeritaAcara.index') }}"
                             class="nav-link {{ Request::is('kelolaBeritaAcara*') ? 'active' : '' }}">
                             <i class="nav-icon fas fa-newspaper"></i>
                             <p>Berita Acara</p>
                         </a>
                     </li>
                     <li class="nav-header">MASTER</li>
                     <li
                         class="nav-item {{ Request::is([
                             'kelolaUser*',
                             'kelolaTahunAkademik*',
                             'kelolaProgramAkademik*',
                             'kelolaKota*',
                             'kelolaProvinsi*',
                             'kelolaKamar*',
                             'kelolaRuangan*',
                             'kelolaKelas*',
                             'kelolaPengajar*',
                             'kelolaSantri*',
                             'kelolaPengurus*',
                             'kelolaAbsen*',
                             'kelolaPembayaran*',
                             'kelolaMapel*',
                             'kategoriMapel*',
                             'kategoriNilai*',
                             'kategoriAbsen*',
                             'kategoriPiket*',
                         ])
                             ? 'menu-open'
                             : '' }}">
                         <a href="#"
                             class="nav-link {{ Request::is([
                                 'kelolaUser*',
                                 'kelolaTahunAkademik*',
                                 'kelolaProgramAkademik*',
                                 'kelolaKota*',
                                 'kelolaKamar*',
                                 'kelolaRuangan*',
                                 'kelolaKelas*',
                                 'kelolaPengajar*',
                                 'kelolaSantri*',
                                 'kelolaPengurus*',
                                 'kelolaAbsen*',
                                 'kelolaPembayaran*',
                                 'kelolaMapel*',
                                 'kategoriMapel*',
                                 'kategoriNilai*',
                                 'kategoriAbsen*',
                                 'kategoriPiket*',
                             ])
                                 ? 'active'
                                 : '' }}">
                             <i class="nav-icon fas fa-archive"></i>
                             <p>
                                 Master Data
                                 <i class="fas fa-angle-left right"></i>
                             </p>
                         </a>
                         <ul class="nav nav-treeview">
                             <li class="nav-header">Data Pengguna</li>
                             <li class="nav-item">
                                 <a href="{{ route('kelolaUser.index') }}"
                                     class="nav-link {{ Request::is('kelolaUser*') ? 'active' : '' }}">
                                     <i class="far fa-circle nav-icon"></i>
                                     <p>Users</p>
                                 </a>
                             </li>
                             <li class="nav-item">
                                 <a href="{{ route('kelolaSantri.index') }}"
                                     class="nav-link {{ Request::is('kelolaSantri*') ? 'active' : '' }}">
                                     <i class="far fa-circle nav-icon"></i>
                                     <p>Santri</p>
                                 </a>
                             </li>
                             <li class="nav-item">
                                 <a href="{{ route('kelolaPengurus.index') }}"
                                     class="nav-link {{ Request::is('kelolaPengurus*') ? 'active' : '' }}">
                                     <i class="far fa-circle nav-icon"></i>
                                     <p>Pengurus</p>
                                 </a>
                             </li>
                             <li class="nav-item">
                                 <a href="{{ route('kelolaPengajar.index') }}"
                                     class="nav-link {{ Request::is('kelolaPengajar*') ? 'active' : '' }}">
                                     <i class="far fa-circle nav-icon"></i>
                                     <p>Pengajar</p>
                                 </a>
                             </li>
                             <li class="nav-header">Data Ruang</li>

                             <li class="nav-item">
                                 <a href="{{ route('kelolaKelas.index') }}"
                                     class="nav-link {{ Request::is('kelolaKelas*') ? 'active' : '' }}">
                                     <i class="far fa-circle nav-icon"></i>
                                     <p>Kelas</p>
                                 </a>
                             </li>
                             <li class="nav-item">
                                 <a href="{{ route('kelolaRuangan.index') }}"
                                     class="nav-link  {{ Request::is('kelolaRuangan*') ? 'active' : '' }}">
                                     <i class="far fa-circle nav-icon"></i>
                                     <p>Ruangan</p>
                                 </a>
                             </li>
                             <li class="nav-item">
                                 <a href="{{ route('kelolaKamar.index') }}"
                                     class="nav-link {{ Request::is('kelolaKamar*') ? 'active' : '' }}">
                                     <i class="far fa-circle nav-icon"></i>
                                     <p>Kamar</p>
                                 </a>
                             </li>
                             <li class="nav-header">Data Wilayah</li>
                             <li class="nav-item">
                                 <a href="{{ route('kelolaProvinsi.index') }}"
                                     class="nav-link {{ Request::is('kelolaProvinsi*') ? 'active' : '' }}">
                                     <i class="far fa-circle nav-icon"></i>
                                     <p>Provinsi</p>
                                 </a>
                             </li>
                             <li class="nav-item">
                                 <a href="{{ route('kelolaKota.index') }}"
                                     class="nav-link {{ Request::is('kelolaKota*') ? 'active' : '' }}">
                                     <i class="far fa-circle nav-icon"></i>
                                     <p>Kota</p>
                                 </a>
                             </li>
                             <li class="nav-header">Data Akademik</li>
                             <li class="nav-item">
                                 <a href="{{ route('kelolaProgramAkademik.index') }}"
                                     class="nav-link {{ Request::is('kelolaProgramAkademik*') ? 'active' : '' }}">
                                     <i class="far fa-circle nav-icon"></i>
                                     <p>Program</p>
                                 </a>
                             </li>
                             <li class="nav-item">
                                 <a href="{{ route('kelolaTahunAkademik.index') }}"
                                     class="nav-link {{ Request::is('kelolaTahunAkademik*') ? 'active ' : '' }}">
                                     <i class="far fa-circle nav-icon"></i>
                                     <p>Tahun Akademik</p>
                                 </a>
                             </li>
                             <li class="nav-item">
                                 <a href="{{ route('kelolaMapel.index') }}"
                                     class="nav-link {{ Request::is('kelolaMapel*') ? 'active ' : '' }}">
                                     <i class="far fa-circle nav-icon"></i>
                                     <p>Mata Pelajaran</p>
                                 </a>
                             </li>
                             <li class="nav-header">Data Kategori</li>
                             <li class="nav-item">
                                 <a href="{{ route('kelolaPembayaran.index') }}"
                                     class="nav-link {{ Request::is('kelolaPembayaran*') ? 'active ' : '' }} ">
                                     <i class="far fa-circle nav-icon"></i>
                                     <p>Kategori Pembayaran</p>
                                 </a>
                             </li>
                             <li class="nav-item">
                                 <a href="{{ route('kelolaAbsen.index') }}"
                                     class="nav-link {{ Request::is('kelolaAbsen*') ? 'active ' : '' }}">
                                     <i class="far fa-circle nav-icon"></i>
                                     <p>Kategori Absen</p>
                                 </a>
                             </li>
                             <li class="nav-item">
                                 <a href="{{ route('kategoriMapel.index') }}"
                                     class="nav-link {{ Request::is('kategoriMapel*') ? 'active ' : '' }}">
                                     <i class="far fa-circle nav-icon"></i>
                                     <p>Kategori Mapel</p>
                                 </a>
                             </li>
                             <li class="nav-item">
                                 <a href="{{ route('kategoriNilai.index') }}"
                                     class="nav-link {{ Request::is('kategoriNilai*') ? 'active ' : '' }}">
                                     <i class="far fa-circle nav-icon"></i>
                                     <p>Kategori Penilaian</p>
                                 </a>
                             </li>
                             <li class="nav-item">
                                 <a href="{{ route('kategoriPiket.index') }}"
                                     class="nav-link {{ Request::is('kategoriPiket*') ? 'active ' : '' }}">
                                     <i class="far fa-circle nav-icon"></i>
                                     <p>Kategori Piket</p>
                                 </a>
                             </li>
                         </ul>
                     </li>
                     <li class="nav-header">PERIZINAN</li>
                     <li class="nav-item">
                         <a href="{{ route('perizinan.index') }}"
                             class="nav-link {{ Request::is('perizinan*') ? 'active ' : '' }}">
                             <i class="nav-icon fas fa-user-check"></i>
                             <p>Perizinan</p>
                         </a>
                     </li>
                     <li class="nav-header">ABSENSI</li>
                     <li class="nav-item">
                         <a href="{{ route('presensi.index') }}"
                             class="nav-link {{ Request::is('presensi*') ? 'active ' : '' }}">
                             <i class="nav-icon fas fa-tasks"></i>
                             <p>Absensi</p>
                         </a>
                     </li>
                     <li class="nav-header">PEMBAYARAN</li>
                     <li class="nav-item {{ Request::is(['pembayaran*']) ? 'menu-open' : '' }}">
                         <a href="#" class="nav-link {{ Request::is(['pembayaran*']) ? 'active' : '' }}">
                             <i class="nav-icon fas fa-money-check"></i>
                             <p>
                                 Pembayaran
                                 <i class="fas fa-angle-left right"></i>
                             </p>
                         </a>
                         <ul class="nav nav-treeview">
                             <li class="nav-item">
                                 <a href="{{ route('pembayaran.index') }}"
                                     class="nav-link {{ Request::is('pembayaran*') ? 'active' : '' }}">
                                     <i class="far fa-circle nav-icon"></i>
                                     <p>Data Pembayaran</p>
                                 </a>
                             </li>
                         </ul>
                     </li>

                     <li class="nav-header">AKADEMIK</li>
                     <li
                         class="nav-item {{ Request::is([
                             'jadwalPelajaran*',
                             'jadwalPiket*',
                             'kelompokKelas*',
                             'kelompokKamar*',
                             'hafalanSurah*',
                             'penilaianAkhir*',
                         ])
                             ? 'menu-open'
                             : '' }}">
                         <a href="#"
                             class="nav-link {{ Request::is([
                                 'jadwalPelajaran*',
                                 'jadwalPiket*',
                                 'kelompokKelas*',
                                 'kelompokKamar*',
                                 'hafalanSurah*',
                                 'penilaianAkhir*',
                             ])
                                 ? 'active'
                                 : '' }}">
                             <i class="nav-icon fas fa-archive"></i>
                             <p>
                                 Akademik
                                 <i class="fas fa-angle-left right"></i>
                             </p>
                         </a>
                         <ul class="nav nav-treeview">
                             <li class="nav-item">
                                 <a href="{{ route('jadwalPelajaran.index') }}"
                                     class="nav-link {{ Request::is('jadwalPelajaran*') ? 'active' : '' }}">
                                     <i class="far fa-circle nav-icon"></i>
                                     <p>Jadwal Pelajaran</p>
                                 </a>
                             </li>
                             <li class="nav-item">
                                 <a href="{{ route('jadwalPiket.index') }}"
                                     class="nav-link {{ Request::is('jadwalPiket*') ? 'active' : '' }}">
                                     <i class="far fa-circle nav-icon"></i>
                                     <p>Jadwal Piket</p>
                                 </a>
                             </li>
                             <li class="nav-item">
                                 <a href="{{ route('kelompokKelas.index') }}"
                                     class="nav-link {{ Request::is('kelompokKelas*') ? 'active' : '' }}">
                                     <i class="far fa-circle nav-icon"></i>
                                     <p>Kelompok Kelas</p>
                                 </a>
                             </li>
                             <li class="nav-item">
                                 <a href="{{ route('kelompokKamar.index') }}"
                                     class="nav-link {{ Request::is('kelompokKamar*') ? 'active' : '' }}">
                                     <i class="far fa-circle nav-icon"></i>
                                     <p>Kelompok Kamar</p>
                                 </a>
                             </li>
                             <li class="nav-item">
                                 <a href="{{ route('hafalanSurah.index') }}"
                                     class="nav-link {{ Request::is('hafalanSurah*') ? 'active' : '' }}">
                                     <i class="far fa-circle nav-icon"></i>
                                     <p>Penilaian Hafalan</p>
                                 </a>
                             </li>
                             <li class="nav-item">
                                 <a href="{{ route('penilaianAkhir.index') }}"
                                     class="nav-link {{ Request::is('penilaianAkhir*') ? 'active' : '' }}">
                                     <i class="far fa-circle nav-icon"></i>
                                     <p>Input Nilai Akhir</p>
                                 </a>
                             </li>
                         </ul>
                     </li>
                     <li class="nav-header">File Sharing</li>
                     <li class="nav-item">
                         <a href="{{ route('video.index') }}"
                             class="nav-link {{ Request::is('video*') ? 'active' : '' }}">
                             <i class="nav-icon fas fa-video"></i>
                             <p>Video</p>
                         </a>
                     </li>
                     <li class="nav-item">
                         <a href="{{ route('ebook.index') }}"
                             class="nav-link {{ Request::is('ebook*') ? 'active' : '' }}">
                             <i class="nav-icon fas fa-book"></i>
                             <p>E-Book</p>
                         </a>
                     </li>
                     <li class="nav-item">
                         <a href="{{ route('settings.index') }}"
                             class="nav-link {{ Request::is('settings*') ? 'active' : '' }}">
                             <i class="nav-icon fas fa-gear">
                                 <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                     fill="currentColor" class="bi bi-gear-fill" viewBox="0 0 16 16">
                                     <path
                                         d="M9.405 1.05c-.413-1.4-2.397-1.4-2.81 0l-.1.34a1.464 1.464 0 0 1-2.105.872l-.31-.17c-1.283-.698-2.686.705-1.987 1.987l.169.311c.446.82.023 1.841-.872 2.105l-.34.1c-1.4.413-1.4 2.397 0 2.81l.34.1a1.464 1.464 0 0 1 .872 2.105l-.17.31c-.698 1.283.705 2.686 1.987 1.987l.311-.169a1.464 1.464 0 0 1 2.105.872l.1.34c.413 1.4 2.397 1.4 2.81 0l.1-.34a1.464 1.464 0 0 1 2.105-.872l.31.17c1.283.698 2.686-.705 1.987-1.987l-.169-.311a1.464 1.464 0 0 1 .872-2.105l.34-.1c1.4-.413 1.4-2.397 0-2.81l-.34-.1a1.464 1.464 0 0 1-.872-2.105l.17-.31c.698-1.283-.705-2.686-1.987-1.987l-.311.169a1.464 1.464 0 0 1-2.105-.872zM8 10.93a2.929 2.929 0 1 1 0-5.86 2.929 2.929 0 0 1 0 5.858z" />
                                 </svg>
                             </i>
                             <p>Settings</p>
                         </a>
                     </li>
                     <li class="nav-header">Laporan</li>
                     <li
                         class="nav-item {{ Request::is([
                             'laporan-presensi*',
                             'laporan-perizinan*',
                             'laporan-pembayaran*',
                             'laporan-pembayaran*',
                             'laporan-nilai-hafalan*',
                             'laporan-penilaian-akhir*',
                         ])
                             ? 'menu-open'
                             : '' }}">
                         <a href="#"
                             class="nav-link
                         {{ Request::is([
                             'laporan-presensi*',
                             'laporan-perizinan*',
                             'laporan-pembayaran*',
                             'laporan-pembayaran*',
                             'laporan-nilai-hafalan*',
                             'laporan-penilaian-akhir*',
                         ])
                             ? 'active'
                             : '' }}">
                             <i class="nav-icon fas fa-archive"></i>
                             <p>
                                 Laporan
                                 <i class="fas fa-angle-left right"></i>
                             </p>
                         </a>
                         <ul class="nav nav-treeview">
                             <li class="nav-item">
                                 <a href="{{ route('presensi-report.index') }}"
                                     class="nav-link {{ Request::is('laporan-presensi*') ? 'active' : '' }}">
                                     <i class="far fa-circle nav-icon"></i>
                                     <p>Laporan Presensi</p>
                                 </a>
                             </li>
                             <li class="nav-item">
                                 <a href="{{ route('perizinan-report.index') }}"
                                     class="nav-link {{ Request::is('laporan-perizinan*') ? 'active' : '' }}">
                                     <i class="far fa-circle nav-icon"></i>
                                     <p>Laporan Perizinan</p>
                                 </a>
                             </li>
                             <li class="nav-item">
                                 <a href="{{ route('pembayaran-report.index') }}"
                                     class="nav-link {{ Request::is('laporan-pembayaran*') ? 'active' : '' }}">
                                     <i class="far fa-circle nav-icon"></i>
                                     <p>Laporan Pembayaran</p>
                                 </a>
                             </li>
                             <li class="nav-item">
                                 <a href="{{ route('nilai-hafalan-report.index') }}"
                                     class="nav-link {{ Request::is('laporan-nilai-hafalan*') ? 'active' : '' }}">
                                     <i class="far fa-circle nav-icon"></i>
                                     <p>Laporan Nilai Hafalan</p>
                                 </a>
                             </li>
                             <li class="nav-item">
                                 <a href="{{ route('penilaian-akhir-report.index') }}"
                                     class="nav-link {{ Request::is('laporan-penilaian-akhir*') ? 'active' : '' }}">
                                     <i class="far fa-circle nav-icon"></i>
                                     <p>Laporan Nilai Akhir</p>
                                 </a>
                             </li>
                         </ul>
                     </li>
                 @endcan
                 @can('pengurus')
                     <li class="nav-header">KABAR BERITA</li>
                     <li class="nav-item">
                         <a href="{{ route('beritaAcara.index') }}"
                             class="nav-link {{ Request::is('beritaAcara*') ? 'active' : '' }}">
                             <i class="nav-icon fas fa-newspaper"></i>
                             <p>Berita Acara</p>
                         </a>
                     </li>
                     <li class="nav-header">PERIZINAN</li>
                     <li class="nav-item">
                         <a href="{{ route('perizinan.index') }}"
                             class="nav-link {{ Request::is('perizinan*') ? 'active ' : '' }}">
                             <i class="nav-icon fas fa-user-check"></i>
                             <p>Perizinan</p>
                         </a>
                     </li>
                     <li class="nav-header">ABSENSI</li>
                     <li class="nav-item">
                         <a href="{{ route('presensi.index') }}"
                             class="nav-link {{ Request::is('presensi*') ? 'active ' : '' }}">
                             <i class="nav-icon fas fa-tasks"></i>
                             <p>Absensi</p>
                         </a>
                     </li>
                     <li class="nav-header">PEMBAYARAN</li>
                     <li class="nav-item {{ Request::is(['pembayaran*']) ? 'menu-open' : '' }}">
                         <a href="#" class="nav-link {{ Request::is(['pembayaran*']) ? 'active' : '' }}">
                             <i class="nav-icon fas fa-money-check"></i>
                             <p>
                                 Pembayaran
                                 <i class="fas fa-angle-left right"></i>
                             </p>
                         </a>
                         <ul class="nav nav-treeview">
                             <li class="nav-item">
                                 <a href="{{ route('pembayaran.index') }}"
                                     class="nav-link {{ Request::is('pembayaran*') ? 'active' : '' }}">
                                     <i class="far fa-circle nav-icon"></i>
                                     <p>Data Pembayaran</p>
                                 </a>
                             </li>
                         </ul>
                     </li>
                 @endcan
                 @can('pengajar')
                     <li class="nav-header">KABAR BERITA</li>
                     <li class="nav-item">
                         <a href="{{ route('beritaAcara.index') }}"
                             class="nav-link {{ Request::is('beritaAcara*') ? 'active' : '' }}">
                             <i class="nav-icon fas fa-newspaper"></i>
                             <p>Berita Acara</p>
                         </a>
                     </li>
                     <li class="nav-header">ABSENSI</li>
                     <li class="nav-item">
                         <a href="{{ route('presensi.index') }}"
                             class="nav-link {{ Request::is('presensi*') ? 'active ' : '' }}">
                             <i class="nav-icon fas fa-tasks"></i>
                             <p>Absensi</p>
                         </a>
                     </li>
                     <li class="nav-header">NILAI</li>
                     <li class="nav-item">
                         <a href="{{ route('hafalanSurah.index') }}"
                             class="nav-link {{ Request::is('hafalanSurah*') ? 'active' : '' }}">
                             <i class="nav-icon fas fa-list"></i>
                             <p>Penilaian Hafalan</p>
                         </a>
                     </li>
                     <li class="nav-item">
                         <a href="{{ route('penilaianAkhir.index') }}"
                             class="nav-link {{ Request::is('penilaianAkhir*') ? 'active' : '' }}">
                             <i class="nav-icon fas fa-list"></i>
                             <p>Input Nilai Akhir</p>
                         </a>
                     </li>
                 @endcan
             </ul>
             <div style="height: 100px;"></div>
         </nav>
         <!-- /.sidebar-menu -->
     </div>
     <!-- /.sidebar -->
 </aside>
