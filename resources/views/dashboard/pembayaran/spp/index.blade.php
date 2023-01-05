@include('components.head_table')
@extends('template.template')
@section('content-header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Data Pembayaran Bulanan</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    {{ Breadcrumbs::render('kelolaPembayaran') }}
                </ol>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>
@endsection
@section('content-section')
    <div class="container-fluid">
        @include('components.alert')
        <div class="card">
            <div class="card-header">Filter</div>
            <div class="card-body">
                <form action="{{ route('pembayaran.index') }}" method="get">
                    @csrf
                    <div class="form-group">
                        <label for="">Kategori</label>
                        <select name="category" id="category" class="custom-select form-control-border">
                            <option value="">Pilih</option>
                            @forelse ($category as $item)
                                <option value="{{ $item->id }}">{{ $item->payment_name }}</option>
                            @empty
                                <option value="">Tidak ada data</option>
                            @endforelse
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Kelas</label>
                        <select name="class" id="class" class="custom-select form-control-border">
                            <option value="">Pilih</option>
                            @forelse ($class as $item)
                                <option value="{{ $item->id }}">{{ $item->class_name }}</option>
                            @empty
                                <option value="">Tidak ada data</option>
                            @endforelse
                        </select>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary" name="search">Cari</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="card" style="overflow: auto;">
            <div class="card-header">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-AddData">
                    <i class="fa fa-plus mr-2"></i> Tambah Data Baru
                </button>
                <a href="{{ route('trashPayment') }}" class="btn btn-secondary">
                    <i class="fa fa-trash mr-2"></i>Trash
                    Bin</a>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Pengguna</th>
                            <th>Nama Pembayaran</th>
                            <th>Metode Pembayaran</th>
                            <th>Media Pembayaran</th>
                            <th>Total Pembayaran</th>
                            <th>Total Yang Di Bayar</th>
                            <th>Selisih</th>
                            <th>Tanggal Bayar</th>
                            <th>Status</th>
                            <th>Bukti</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($data as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{!! $item->name ?? '<span class="badge badge-danger">Error</span>' !!}</td>
                                <td>{!! $item->payment_name ?? '<span class="badge badge-danger">Error</span>' !!}</td>
                                <td>{!! $item->method ?? '<span class="badge badge-danger">Error</span>' !!}</td>
                                <td>{!! $item->media_payment ?? '<span class="badge badge-danger">Error</span>' !!}</td>
                                <td>@currency($item->total ?? '')</td>
                                <td>@currency($item->total_payment ?? '')</td>
                                <td>@currency($item->remaining ?? '')</td>
                                <td>{{ $item->date ?? '' }}</td>
                                <td>
                                    @if ($item->status == null)
                                        <span class="badge badge-info">Sedang ditinjau</span>
                                    @endif
                                    @if ($item->status === true)
                                        <span class="badge badge-success">Lunas</span>
                                    @endif
                                    @if ($item->status === false)
                                        <span class="badge badge-danger">Belum Lunas</span>
                                    @endif
                                </td>
                                <td> <img src="{{ $item->photo }}" alt="" width="100" height="130"
                                        class="photo"></td>
                                <td>
                                    {{-- {Edit} --}}
                                    <button type="button" class="btn btn-sm" data-toggle="modal"
                                        data-target="#modal-Edit{{ $item->id }}">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                    {{-- {Hapus} --}}
                                    <button type="button" class="btn btn-sm" data-toggle="modal"
                                        data-target="#modal-Delete{{ $item->id }}">
                                        <i class="fa fa-trash"></i>
                                    </button>

                                </td>
                            </tr>

                            {{-- Modal Delete --}}
                            <div class="modal fade" id="modal-Delete{{ $item->id }}">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Konfirmasi hapus data</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="card">
                                                <div class="card-header bg-danger">
                                                    <h4>{{ $item->payment_name }}</h4> <br>
                                                    <p>Yakin ingin menghapus data tersebut? </p>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="modal-footer justify-content-between">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">
                                                Close</button>
                                            <form action="{{ route('kelolaPembayaran.destroy', $item->id) }}"
                                                method="post">
                                                @csrf
                                                @method('delete')
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    <i class="fa fa-trash mr-2"></i>
                                                    Hapus</button>
                                            </form>
                                        </div>
                                    </div>
                                    <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                            </div>


                        @empty
                            <tr>
                                <td colspan="11" align="center"> Data Tidak Tersedia</td>
                            </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>No</th>
                            <th>Nama Pengguna</th>
                            <th>Nama Pembayaran</th>
                            <th>Metode Pembayaran</th>
                            <th>Media Pembayaran</th>
                            <th>Total Pembayaran</th>
                            <th>Total Yang Di Bayar</th>
                            <th>Selisih</th>
                            <th>Tanggal Bayar</th>
                            <th>Status</th>
                            <th>Bukti</th>
                            <th>Aksi</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <!-- /.card-body -->
        </div>

    </div>
@endsection
@include('components.footer_table')
