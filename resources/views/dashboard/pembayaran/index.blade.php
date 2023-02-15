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
                    {{ Breadcrumbs::render('pembayaran.index') }}
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
                            <label for="">Kategori Filter</label>
                            <select name="filter" id="filter" class="form-control select2">
                                <option value="">Pilih</option>
                                <option value="Kelas">Kelas</option>
                                <option value="Individu">Individu</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Kategori Pembayaran</label>
                            <select name="category" id="category" class="form-control select2">
                                <option value="">Pilih</option>
                                @forelse ($category as $item)
                                    <option value="{{ $item->id }}">{{ $item->payment_name }}</option>
                                @empty
                                    <option value="">Tidak ada data</option>
                                @endforelse
                            </select>
                        </div>
                        <div class="form-group" id="class-group">
                            <label for="">Kelas</label>
                            <select class="form-control select2" style="width: 100%;" name="class" id="class">
                                <option value="">Pilih</option>
                                @forelse ($class as $item)
                                    <option value="{{ $item->id }}">{{ $item->class_name }}</option>
                                @empty
                                    <option value="">Tidak ada data</option>
                                @endforelse
                            </select>
                        </div>
                        <div class="form-group" id="student-group">
                            <label for="">Santri</label>
                            <select class="form-control select2" style="width: 100%;" name="student" id="student">
                                <option value="">Pilih</option>
                                @foreach ($student as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
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
                @can('admin')
                    <a href="{{ route('pembayaran.create') }}" class="btn btn-primary">
                        <i class="fa fa-plus mr-2"></i>Buat Pembayaran
                        Baru</a>
                @endcan
                {{-- <strong>Data Pembayaran</strong> --}}
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
                                <td>
                                    @foreach ($sum as $data)
                                        @if ($data->id_student == $item->id_student && $data->id_payment == $item->id_payment)
                                            @currency($data->sum_total ?? '0')
                                        @break
                                    @endif
                                @endforeach
                            </td>
                            <td>
                                @foreach ($diff as $data)
                                    @if ($data->id_student == $item->id_student && $data->id_payment == $item->id_payment)
                                        @currency($data->difference ?? '0')
                                    @break
                                @endif
                            @endforeach
                        </td>
                        <td>{{ $item->date ?? '' }}</td>
                        <td>
                            @if (is_null($item->status))
                                <span class="badge badge-info">Sedang di tinjau</span>
                            @elseif ($item->status == 1)
                                <span class="badge badge-success">Di Terima</span>
                            @elseif ($item->status == 0)
                                <span class="badge badge-warning">Di Tolak</span>
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
                            <div class="d-flex justify-content-around mt-3">
                                {{-- {Edit} --}}
                                <button type="button" class="btn btn-default" data-toggle="modal"
                                    data-target="#modal-Edit{{ $item->id }}">
                                    <i class="fa fa-edit"></i>
                                </button> &nbsp;
                                @can('admin')
                                    {{-- {Hapus} --}}
                                    <button type="button" class="btn btn-danger" data-toggle="modal"
                                        data-target="#modal-Delete{{ $item->id }}">
                                        <i class="fa fa-trash"></i>
                                    </button>&nbsp;
                                    <a href="{{ route('pembayaran.edit', $item->id) }}" class="btn btn-warning"><i
                                            class="fa fa-user-edit"></i></a>
                                @endcan
                            </div>

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
                                    <form action="{{ route('pembayaran.destroy', $item->id) }}" method="post">
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
                                    <button type="button" class="close" data-dismiss="modal"
                                        aria-label="Close">
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
                                            <option value="1">Di Terima</option>
                                            <option value="0">Di Tolak</option>
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
@extends('components.footer_table')
@push('new-script')
<script src="{{ asset('template/plugins/select2/js/select2.full.min.js') }}"></script>

<script>
    $(function() {
        $('#class-group').addClass('d-none');
        $('#student-group').addClass('d-none');

        $('#filter').change(function() {
            var value = $(this).val();

            if (value === 'Kelas') {
                $('#class-group').removeClass('d-none');
                $('#student-group').addClass('d-none');
            }
            if (value === 'Individu') {
                $('#class-group').addClass('d-none');
                $('#student-group').removeClass('d-none');
            }
        })
        $('.select2').select2();

    });
</script>
@endpush
