@include('components.head_table')
@extends('template.template')
@section('content-header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Data Perizinan </h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    {{ Breadcrumbs::render('perizinan') }}
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
        <div class="card" style="overflow: auto;">
            <div class="card-header">
                @can('admin')
                    <a href="{{ route('perizinan.create') }}" class="btn btn-primary">
                        <i class="fa fa-plus mr-2"></i>Buat Perizinan
                        Baru</a>
                    {{-- <a href="{{ route('trashPermit') }}" class="btn btn-secondary">
                        <i class="fa fa-trash mr-2"></i>Trash
                        Bin</a> --}}
                @endcan
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Keterangan</th>
                            <th>Tanggal Izin</th>
                            <th>Judul Izin</th>
                            <th>Program</th>
                            <th>Tahun Akademik</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($perizinan as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $item->student->name }}</td>
                                <td>{{ $item->description }}</td>
                                <td>{{ $item->permit_date }}</td>
                                <td>{{ $item->permit_type }}</td>
                                <td>{{ $item->program->program_name ?? 'Null' }}</td>
                                <td>{{ $item->period->code ?? 'Null' }}</td>
                                <td>
                                    @if (is_null($item->status))
                                        <span class="badge badge-info">Menunggu persetujuan</span>
                                    @elseif ($item->status == 1)
                                        <span class="badge badge-success">Di setujui</span>
                                    @elseif ($item->status == 0)
                                        <span class="badge badge-danger">Tidak disetujui</span>
                                    @endif
                                </td>
                                <td>
                                    {{-- {Edit} --}}
                                    <button type="button" class="btn btn-default" data-toggle="modal"
                                        data-target="#modal-Edit{{ $item->id }}">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                    @can('admin')
                                        {{-- {Hapus} --}}
                                        <button type="button" class="btn btn-danger" data-toggle="modal"
                                            data-target="#modal-Delete{{ $item->id }}">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                        <a href="{{ route('perizinan.edit', $item->id) }}" class="btn btn-warning">Edit</a>
                                    @endcan

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
                                                    <h1>{{ $item->student->name }}</h1> <br>
                                                    <p>{{ $item->description }}</p>
                                                    <p>Yakin ingin menghapus data tersebut? </p>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="modal-footer justify-content-between">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">
                                                Close</button>
                                            <form action="{{ route('perizinan.destroy', $item->id) }}" method="post">
                                                @csrf
                                                @method('delete')
                                                <button type="submit" class="btn btn-sm btn-danger"><i
                                                        class="fa fa-trash"></i>
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
                                            <h4 class="modal-title">Edit Data {{ $item->student->name }} </h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form action="{{ route('perizinan.update', $item->id) }}" method="post">
                                            @csrf
                                            @method('put')
                                            <div class="modal-body">
                                                <p>{{ $item->description }}</p>
                                                <br>
                                                <label for="">Status</label>
                                                <select name="status" id=""
                                                    class="custom-select form-control-border">
                                                    <option value="">Pilih Status</option>
                                                    <option value="1">Di Setujui</option>
                                                    <option value="0">Tidak Di Setujui</option>
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
                                    <td colspan="8" align="center"> Data Tidak Tersedia</td>
                                </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Keterangan</th>
                            <th>Tanggal Izin</th>
                            <th>Judul Izin</th>
                            <th>Program</th>
                            <th>Tahun Akademik</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <!-- /.card-body -->
        </div>

        {{-- </div> --}}
    </div>
@endsection
@include('components.footer_table')
