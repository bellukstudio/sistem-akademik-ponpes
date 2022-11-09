@include('components.head_table')
@extends('template.template')
@section('content-header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Data Pengajar</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    {{ Breadcrumbs::render('kelolaPengajar') }}
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
                <a class="btn btn-primary" href="{{ route('kelolaPengajar.create') }}">
                    <i class="fa fa-plus mr-2"></i> Tambah Data Baru
                </a>
                <a href="{{ route('trashProgram') }}" class="btn btn-secondary">
                    <i class="fa fa-trash mr-2"></i>Trash
                    Bin</a>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table id="example" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Lengkap</th>
                            <th>Email</th>
                            <th>Foto</th>
                            <th>Jenis Kelamin</th>
                            <th>No Telepon</th>
                            <th>Provinsi</th>
                            <th>Kota</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pengajar as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->email }}</td>
                                <td>
                                    @if ($item->photo == 'http://localhost:8000/storage/')
                                        <i class="badge badge-info">Null</i>
                                    @else
                                        <img src="{{ $item->photo }}" alt="" width="100" height="130"
                                            class="photo">
                                    @endif
                                </td>
                                <td>{{ $item->gender }}</td>
                                <td>{{ $item->no_tlp }}</td>
                                <td>{{ $item->province->province_name }}</td>
                                <td>{{ $item->city->city_name }}</td>
                                <td>
                                    {{-- {Edit} --}}
                                    <a href="{{ route('kelolaPengajar.edit', $item->id) }}" class="btn btn-sm">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    {{-- {Hapus} --}}
                                    <button type="button" class="btn btn-sm" data-toggle="modal"
                                        data-target="#modal-Delete{{ $item->id }}">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                    {{-- show --}}
                                    <a href="{{ route('kelolaPengajar.show', $item->id) }}" class="btn btn-sm">
                                        <i class="fa fa-eye"></i>
                                    </a>
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
                                                    <h4>{{ $item->name }}</h4> <br>
                                                    <p>Yakin ingin menghapus data tersebut? </p>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="modal-footer justify-content-between">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">
                                                Close</button>
                                            <form action="{{ route('kelolaPengajar.destroy', $item->id) }}" method="post">
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
                                <td colspan="9" align="center"> Data Tidak Tersedia</td>
                            </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>No</th>
                            <th>Nama Lengkap</th>
                            <th>Email</th>
                            <th>Foto</th>
                            <th>Jenis Kelamin</th>
                            <th>No Telepon</th>
                            <th>Provinsi</th>
                            <th>Kota</th>
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
    <script>
        $(document).ready(function() {
            var table = $('#example').DataTable({
                responsive: true
            });

            new $.fn.dataTable.FixedHeader(table);
        });
    </script>
@endpush
