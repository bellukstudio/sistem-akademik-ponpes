@include('components.head_table')
@extends('template.template')
@section('content-header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Jadwal Piket</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    {{ Breadcrumbs::render('jadwalPiket') }}
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
            <div class="card-header">
                <h2>Filter</h2>
            </div>
            <div class="card-body">
                <form action="{{ route('filterDataPicket') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="">Pilih Kategori Piket</label>
                        <select name="category" id="category" class="form-control select2" style="width: 100%;">
                            <option value="">Pilih</option>
                            @forelse ($category as $s)
                                <option value="{{ $s->id }}">{{ $s->name }}</option>
                            @empty
                                <option value=""></option>
                            @endforelse
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Pilih Kategori Data</label>
                        <select name="data_category" id="data_category" class="form-control select2" style="width: 100%;">
                            <option value="">Pilih</option>
                            <option value="class">Per-Kelas</option>
                            <option value="room">Per-Ruang</option>
                        </select>
                    </div>
                    <div class="form-group" id="class_select">
                        <label for="">Pilih Kelas</label>
                        <select name="class" id="class" class="form-control select2" style="width: 100%;">
                            <option value="">Pilih</option>
                            @forelse ($class as $s)
                                <option value="{{ $s->id }}">{{ $s->class_name }}</option>
                            @empty
                                <option value=""></option>
                            @endforelse
                        </select>
                    </div>
                    <div class="form-group" id="room_select">
                        <label for="">Pilih Ruangan</label>
                        <select name="room_select" id="" class="form-control select2" style="width: 100%;">
                            <option value="">Pilih Ruang</option>
                            @forelse ($room as $r)
                                <option value="{{ $r->id }}">{{ $r->room_name }}</option>
                            @empty
                                <option value=""></option>
                            @endforelse
                        </select>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-info" id="showData" name="showButton"> <i
                                class="fa fa-eye mr-2"></i>
                            Lihat</button>
                        <button type="submit" class="btn btn-danger" name="exportPdf"><svg
                                xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-printer-fill" viewBox="0 0 16 16">
                                <path
                                    d="M5 1a2 2 0 0 0-2 2v1h10V3a2 2 0 0 0-2-2H5zm6 8H5a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1v-3a1 1 0 0 0-1-1z" />
                                <path
                                    d="M0 7a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2h-1v-2a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v2H2a2 2 0 0 1-2-2V7zm2.5 1a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z" />
                            </svg></i> Cetak PDF</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="card" style="overflow: auto;">
            <div class="card-header">
                <a href="{{ route('jadwalPiket.create') }}" class="btn btn-primary">
                    <i class="fa fa-plus mr-2"></i> Tambah Data Baru
                </a>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Kategori</th>
                            <th>Lokasi</th>
                            <th>Waktu</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($piket as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{!! $item->student_name ?? '<span class="badge badge-danger">Error</span>' !!}</td>
                                <td>{!! $item->category_name ?? '<span class="badge badge-danger">Error</span>' !!}</td>
                                <td>{!! $item->room ?? '<span class="badge badge-danger">Error</span>' !!}</td>
                                <td>{{ $item->time }}</td>
                                <td>
                                    {{-- {Edit} --}}
                                    <a href="{{ route('jadwalPiket.edit', $item->id) }}" class="btn"><i
                                            class="fa fa-edit"></i></a>
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
                                                    <h4>Lokasi {!! $item->room->room_name ?? '<span class="badge badge-danger">Error</span>' !!}</h4>
                                                    <p>Nama{!! $item->student->name ?? '<span class="badge badge-danger">Error</span>' !!}</p> <br>
                                                    <p>Yakin ingin menghapus data tersebut? </p>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="modal-footer justify-content-between">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">
                                                Close</button>
                                            <form action="{{ route('jadwalPiket.destroy', $item->id) }}" method="post">
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
                                <td colspan="6" align="center"> Data Tidak Tersedia</td>
                            </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Kategori</th>
                            <th>Lokasi</th>
                            <th>Waktu</th>
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
        $(function() {
            $('#class_select').addClass('d-none');
            $('#room_select').addClass('d-none');

            // //check category
            $('#data_category').change(function() {
                var value = $(this).val();
                if (value === 'class') {
                    $('#class_select').removeClass('d-none');
                    $('#room_select').addClass('d-none');
                } else if (value === 'room') {
                    $('#room_select').removeClass('d-none');
                    $('#class_select').addClass('d-none');
                }
            });
        })
    </script>
@endpush
