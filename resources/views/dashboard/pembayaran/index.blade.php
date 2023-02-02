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
        @can('admin')
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
        @endcan
        <div class="card" style="overflow: auto;">
            <div class="card-header">
                {{-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-AddData">
                    <i class="fa fa-plus mr-2"></i> Tambah Data Baru
                </button> --}}
                <strong>Data Pembayaran</strong>
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
                            <th>Total Yang Sudah Dibayar</th>
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
                                <td>@currency($item->sum_total ?? '')</td>
                                <td>@currency($item->remaining ?? '')</td>
                                <td>{{ $item->date ?? '' }}</td>
                                <td>
                                    @if (is_null($item->status))
                                        <span class="badge badge-info">Sedang di tinjau</span>
                                    @elseif ($item->status == 1)
                                        <span class="badge badge-success">Lunas</span>
                                    @elseif ($item->status == 0)
                                        <span class="badge badge-warning">Belum Lunas</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($item->photo === 'http://127.0.0.1:8000/storage/')
                                        <i class="badge badge-info">Null</i>
                                    @else
                                        <img src="{{ $item->photo }}" alt="" class="photo">
                                    @endif
                                </td>
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
                                                    {!! $item->name ?? '<span class="badge badge-danger">Error</span>' !!}
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

                            {{-- Modal update data --}}
                            <div class="modal fade" id="modal-Edit{{ $item->id }}">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Edit Data {!! $item->name ?? '<span class="badge badge-danger">Error</span>' !!} </h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form action="{{ route('pembayaran.update', $item->id) }}" method="post">
                                            @csrf
                                            @method('put')
                                            <div class="modal-body">
                                                <p>{{ $item->payment_name }}</p>
                                                <br>
                                                <label for="">Status</label>
                                                <select name="status" id=""
                                                    class="custom-select form-control-border">
                                                    <option value="">Pilih Status</option>
                                                    <option value="1">Lunas</option>
                                                    <option value="0">Belum Lunas</option>
                                                </select>

                                            </div>
                                            <div class="modal-footer justify-content-between">
                                                <button type="button" class="btn btn-default"
                                                    data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-sm btn-warning">
                                                    <svg style="color: white" xmlns="http://www.w3.org/2000/svg"
                                                        width="16" height="16" fill="currentColor"
                                                        class="bi bi-send mr-2" viewBox="0 0 16 16">
                                                        <path
                                                            d="M15.854.146a.5.5 0 0 1 .11.54l-5.819 14.547a.75.75 0 0 1-1.329
                                                .124l-3.178-4.995L.643 7.184a.75.75 0 0 1
                                                 .124-1.33L15.314.037a.5.5 0 0 1 .54.11ZM6.636 10.07l2.761
                                                 4.338L14.13 2.576 6.636 10.07Zm6.787-8.201L1.591
                                                 6.602l4.339 2.76 7.494-7.493Z"
                                                            fill="white"></path>
                                                    </svg>
                                                    Update</button>
                                            </div>
                                        </form>
                                        <!-- /.modal-content -->
                                    </div>
                                    <!-- /.modal-dialog -->
                                </div>

                            @empty
                                <tr>
                                    <td colspan="13" align="center"> Data Tidak Tersedia</td>
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
                            <th>Total Yang Sudah Dibayar</th>
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
