@include('components.head_table')
{{--  --}}
@extends('template.template')
@section('content-section')
    @php
        use Carbon\Carbon;
    @endphp
    <section class="content">
        @if ($isAdmin == false)
            @can('pengajar')
                <div class="container">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card">
                                @if (is_null($user->photo))
                                    <img src="https://via.placeholder.com/150x200?text=Nothing" alt=""
                                        class="card-img-top">
                                @else
                                    <img src="@gdrive($user->photo)" alt="" class="card-img-top">
                                @endif
                                <div class="card-body">
                                    <h5 class="card-title">{{ $user->name }}</h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-header bg-gradient-blue">
                                    <h5 class="card-title">Biodata Pengajar</h5>
                                </div>
                                <div class="card-body">
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <th scope="row">Nomor ID</th>
                                                <td>{{ $user->noId }}</td>
                                            </tr>

                                            <tr>
                                                <th scope="row">Email</th>
                                                <td>{{ $user->email }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Jenis Kelamin</th>
                                                <td>{{ $user->gender }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Tanggal Lahir</th>
                                                <td>{{ $user->date_birth }}</td>
                                            </tr>

                                            <tr>
                                                <th scope="row">Nomor Telepon</th>
                                                <td>{{ $user->phone }}</td>
                                            </tr>

                                            <tr>
                                                <th scope="row">Alamat</th>
                                                <td>{{ $user->address }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Kota</th>
                                                <td>
                                                    {!! $user->city->city_name ?? '<span class="badge badge-danger">Error</span>' !!}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Provinsi</th>
                                                <td>
                                                    {!! $user->province->province_name ?? '<span class="badge badge-danger">Error</span>' !!}
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endcan
            @can('pengurus')
                <div class="container">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card">
                                @if (is_null($user->photo))
                                    <img src="https://via.placeholder.com/150x200?text=Nothing" alt=""
                                        class="card-img-top">
                                @else
                                    <img src="@gdrive($user->photo)" alt="" class="card-img-top">
                                @endif
                                <div class="card-body">
                                    <h5 class="card-title">{{ $user->name }}</h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-header bg-gradient-blue">
                                    <h5 class="card-title">Biodata Pengurus</h5>
                                </div>
                                <div class="card-body">
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <th scope="row">Nomor ID</th>
                                                <td>{{ $user->noId }}</td>
                                            </tr>

                                            <tr>
                                                <th scope="row">Email</th>
                                                <td>{{ $user->email }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Jenis Kelamin</th>
                                                <td>{{ $user->gender }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Tanggal Lahir</th>
                                                <td>{{ $user->date_birth }}</td>
                                            </tr>

                                            <tr>
                                                <th scope="row">Nomor Telepon</th>
                                                <td>{{ $user->phone }}</td>
                                            </tr>

                                            <tr>
                                                <th scope="row">Alamat</th>
                                                <td>{{ $user->address }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Kota</th>
                                                <td>
                                                    {!! $user->city->city_name ?? '<span class="badge badge-danger">Error</span>' !!}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Provinsi</th>
                                                <td>
                                                    {!! $user->province->province_name ?? '<span class="badge badge-danger">Error</span>' !!}
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endcan
        @endif
        <div class="container-fluid">
            @can('admin')
                <!-- Small boxes (Stat box) -->
                <div class="row">
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{ $dataUser }}</h3>

                                <p>User</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-person"></i>
                            </div>
                            <a href="{{ route('kelolaUser.index') }}" class="small-box-footer">More info <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ $dataSantri }}</h3>

                                <p>Santri</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-ios-people"></i>
                            </div>
                            <a href="{{ route('kelolaSantri.index') }}" class="small-box-footer">More info <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-warning">
                            <div class="inner">
                                <h3>{{ $dataPengurus }}</h3>

                                <p>Pengurus</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-ios-person"></i>
                            </div>
                            <a href="{{ route('kelolaPengurus.index') }}" class="small-box-footer">More info <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-danger">
                            <div class="inner">
                                <h3>{{ $dataPengajar }}</h3>

                                <p>Pengajar</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-person-stalker"></i>
                            </div>
                            <a href="{{ route('kelolaPengajar.index') }}" class="small-box-footer">More info <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <!-- Perizinan LIST -->
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Perizinan Terbaru</h3>

                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body p-0">
                                <ul class="products-list product-list-in-card pl-2 pr-2">
                                    @forelse ($perizinan as $index => $item)
                                        <li class="item">
                                            <div class="product-img">
                                                <h4 class="badge badge-success">{{ $index + 1 }}</h4>
                                            </div>
                                            <div class="product-info">
                                                <a href="javascript:void(0)" class="product-title">
                                                    {!! $item->student->name ?? '<span class="badge badge-danger">Error</span>' !!}
                                                    {!! $item->status == '1'
                                                        ? '<span class="badge badge-success float-right">Di Setujui</span>'
                                                        : '<span class="badge badge-info float-right">Menunggu persetujuan</span>' !!}
                                                </a>
                                                <span class="product-description">
                                                    {{ $item->description }}
                                                </span>
                                            </div>
                                        </li>
                                    @empty
                                    @endforelse
                                    <!-- /.item -->
                                </ul>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer text-center">
                                <a href="{{ route('perizinan.index') }}" class="uppercase">Lihat Semua</a>
                            </div>
                            <!-- /.card-footer -->
                        </div>
                    </div>
                    <div class="col-md-6">
                        <!-- Berita Acara LIST -->
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Berita Acara Terbaru</h3>

                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body p-0">
                                <ul class="products-list product-list-in-card pl-2 pr-2">

                                    @forelse ($beritaAcara as $index => $item)
                                        <li class="item">
                                            <div class="product-img">
                                                <h4 class="badge badge-success">{{ $index + 1 }}</h4>
                                            </div>
                                            <div class="product-info">
                                                <a href="javascript:void(0)" class="product-title">{{ $item->title }}
                                                    @if ($item->created_at >= Carbon::now()->subDays(1))
                                                        <span class="badge badge-primary float-right">new</span>
                                                    @else
                                                        <span class="badge badge-warning float-right">old</span>
                                                    @endif
                                                </a>
                                                <span class="product-description">
                                                    {!! $item->description !!}
                                                </span>
                                            </div>
                                        </li>
                                    @empty
                                        <li class="item">
                                            <div class="product-img">
                                                <h4>-</h4>
                                            </div>
                                            <div class="product-info">
                                                <span class="badge badge-danger float-right">empty</span></a>
                                                <p class="text-center">Tidak Ada Berita Acara</p>
                                            </div>
                                        </li>
                                    @endforelse
                                    <!-- /.item -->
                                </ul>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer text-center">
                                <a href="{{ route('beritaAcara.index') }}" class="uppercase">Lihat Semua</a>
                            </div>
                            <!-- /.card-footer -->
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <strong>
                            <h3 class="card-title">Import Data Excel</h3>
                        </strong><br>
                        <a href="https://drive.google.com/drive/folders/1XYRSVtaMJ0MtoQ_7r5cY-2t9qcBH4USn?usp=sharing"
                            target="blank">
                            Template import file</a>
                    </div>
                    @include('components.alert')
                    <div class="card-body">
                        <form action="{{ route('import') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="">Pilih tabel yang akan di import data</label>
                                <select name="tabel" id="" class="custom-select form-control-bordered">
                                    <option value="">Pilih</option>
                                    <option value="santri">Santri</option>
                                    <option value="pengajar">Pengajar</option>
                                    <option value="kelas">Kelas</option>
                                    <option value="ruangan">Ruangan</option>
                                    <option value="mapel">Mata Pelajaran</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="file">Choose Excel file to import:</label>
                                <input type="file" name="excel_file" id="file" class="form-control-file">
                            </div>
                            <button type="submit" class="btn btn-primary">Import</button>
                        </form>
                    </div>
                </div>
                <!-- TABLE: AKTIVITAS USER -->
                <div class="card p-2" style="overflow: auto;">
                    <div class="card-header border-transparent">
                        <h3 class="card-title">Aktivitas User</h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body p-0">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nama User</th>
                                    <th>IP</th>
                                    <th>Perangkat</th>
                                    <th>Aktivitas Terakhir</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($session as $index => $user)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $user->user->name }}</td>
                                        <td>{{ $user->ip_address }}</td>
                                        <td>{{ $user->user_agent }}</td>
                                        <td>{{ date('Y-m-d H:i:s', $user->last_activity) }}</td>
                                        <td>
                                            @if ($user->status === 'ON')
                                                <p class="badge badge-success">{{ $user->status }}</p>
                                            @else
                                                <p class="badge badge-danger">{{ $user->status }}</p>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6">Tidak ada data</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-footer -->
                </div>
            @endcan
        </div>
        <!-- /.row (main row) -->
        <!-- /.container-fluid -->
    </section>
@endsection

@extends('components.footer_table')
@push('new-script')
    <script></script>
@endpush
