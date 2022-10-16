@include('components.head_table')
@extends('template.template')
@section('content-header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Berita Acara</h1>
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
                <a href="{{ route('beritaAcara.create') }}" class="btn btn-primary">
                    <i class="fa fa-plus mr-2"></i>Buat Berita
                    Acara / Pengumuman
                    Baru</a>
                <a href="{{ route('trashBeritaAcara') }}" class="btn btn-secondary"><i class="fa fa-trash mr-2"></i>Trash
                    Bin</a>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Judul</th>
                            <th>Keterangan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($berita as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $item->judul }}</td>
                                <td>{!! $item->keterangan !!}</td>
                                <td>
                                    {{-- {Edit} --}}
                                    <a href="{{ route('beritaAcara.edit', $item->id) }}" class="btn btn-sm"><i
                                            class="fa fa-edit"></i></a>
                                    {{-- {Hapus} --}}
                                    <button type="button" class="btn btn-sm" data-toggle="modal"
                                        data-target="#modal-default{{ $item->id }}">
                                        <i class="fa fa-trash"></i>
                                    </button>

                                </td>
                            </tr>

                            {{-- Modal --}}
                            <div class="modal fade" id="modal-default{{ $item->id }}">
                                <div class="modal-dialog">
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
                                                    <h6>{{ $item->judul }}</h6> <br>
                                                </div>
                                                <div class="card-body">
                                                    <p>{!! $item->keterangan !!}</p>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer justify-content-between">
                                            <button type="button" class="btn btn-default"
                                                data-dismiss="modal">Close</button>
                                            <form action="{{ route('beritaAcara.destroy', $item->id) }}" method="post">
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
                        @empty
                            <tr>
                                <td colspan="4" align="center"> Data Tidak Tersedia</td>
                            </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>No</th>
                            <th>Judul</th>
                            <th>Keterangan</th>
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