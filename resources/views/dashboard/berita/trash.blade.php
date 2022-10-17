@include('components.head_table')
@extends('template.template')
@section('content-header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Trash Bin (Berita Acara)</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    {{ Breadcrumbs::render('trashberitaAcara') }}

                </ol>
            </div>
        </div>
        <!-- /.row -->
    </div>
@endsection
@section('content-section')
    <div class="container-fluid">
        @include('components.alert')
        <div class="card">
            <div class="card-header">
                <a href="{{ route('restoreAllBeritaAcara') }}" class="btn btn-outline-info"><i
                        class="fa fa-undo-alt mr-2"></i>Restore
                    All</a>
                <a href="{{ route('deletePermanenAlltBeritaAcara') }}" class="btn btn-outline-warning"><i
                        class="fa fa-trash-alt mr-2"></i>Delete Permanent
                    All</a>
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
                        @forelse ($trash as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $item->judul }}</td>
                                <td>{!! $item->keterangan !!}</td>
                                <td>
                                    {{-- {Edit} --}}
                                    <a href="{{ route('restoreBeritaAcara', $item->id) }}"
                                        class="btn btn-sm btn-outline-dark"><i class="fa fa-undo-alt mr-2"></i>Restore </a>
                                    <br><br>
                                    {{-- {Hapus} --}}
                                    <button type="button" class="btn btn-sm btn-outline-danger" data-toggle="modal"
                                        data-target="#modal-default{{ $item->id }}">
                                        <i class="fa fa-trash mr-2"> </i> Delete Permanent
                                    </button>

                                </td>
                            </tr>

                            {{-- Modal --}}
                            <div class="modal fade" id="modal-default{{ $item->id }}">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Konfirmasi hapus data permanent</h4>
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
                                            <a href="{{ route('deletePermanentBeritaAcara', $item->id) }}"
                                                class="btn btn-sm btn-danger"><i class="fa fa-trash"></i>
                                                Hapus</a>
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
