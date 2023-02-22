@include('components.head_table')
@extends('template.template')
@section('content-header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Trash Bin (Tahun Akademik)</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    {{ Breadcrumbs::render('kelolaTahunAkademik.trash') }}
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
                @if (count($trash) > 0)
                    <button type="button" class="btn btn-outline-info" data-toggle="modal" data-target="#modal-restoreAll">
                        <i class="fa fa-undo mr-2"></i> Restore All
                    </button>
                    <button type="button" class="btn btn-outline-danger" data-toggle="modal"
                        data-target="#modal-deletePermanent">
                        <i class="fa fa-undo mr-2"></i> Delete Permanent All
                    </button>
                @endif

                {{-- Modal Restore All --}}
                <div class="modal fade" id="modal-restoreAll">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Konfirmasi</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="card">
                                    <div class="card-header bg-info">
                                        <p>Anda yakin ingin melakukan (restore all data) /
                                            memulihkan semua data ?
                                            Tindakan ini mungkin dapat menyebabkan crash pada data</p><br>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-default" data-dismiss="modal">
                                    Close</button>

                                <a href="{{ route('restoreAllTahunAkademik') }}" class="btn btn-sm btn-danger">
                                    <i class="fa fa-undo mr-2"></i>
                                    Ya, Pulihkan</a>

                            </div>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
                {{-- Modal delete All --}}
                <div class="modal fade" id="modal-deletePermanent">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Konfirmasi</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="card">
                                    <div class="card-header bg-info">
                                        <p>Anda yakin ingin melakukan (delete permanent all data) /
                                            menghapus permanent semua data ?</p><br>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-default" data-dismiss="modal">
                                    Close</button>

                                <a href="{{ route('deletePermanentAllTahunAkademik') }}" class="btn btn-sm btn-danger">
                                    <i class="fa fa-trash mr-2"></i>
                                    Ya, Hapus</a>

                            </div>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode</th>
                            <th>Keterangan</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($trash as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $item->code }}</td>
                                <td>{{ $item->information }}</td>
                                <td>
                                    <input type="checkbox" data-id="{{ $item->id }}" name="status" class="js-switch"
                                        readonly {{ $item->status == 1 ? 'checked' : '' }}>
                                </td>
                                <td>
                                    {{-- {restore} --}}
                                    <button type="button" class="btn" data-toggle="modal"
                                        data-target="#modal-restore{{ $item->id }}">
                                        <i class="fa fa-undo mr-2"> </i>
                                    </button>
                                    {{-- {Hapus} --}}
                                    <button type="button" class="btn" data-toggle="modal"
                                        data-target="#modal-Delete{{ $item->id }}">
                                        <i class="fa fa-trash mr-2"> </i>
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
                                                <div class="card-header bg-info">
                                                    <h1>{{ $item->code }}</h1> <br>
                                                    <p>Yakin ingin menghapus permanen data tersebut? </p>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="modal-footer justify-content-between">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">
                                                Close</button>
                                            <a href="{{ route('deletePermanentTahunAkademik', $item->id) }}"
                                                class="btn btn-sm btn-danger"><i class="fa fa-trash mr-2"></i>
                                                Ya, Hapus</a>
                                        </div>
                                    </div>
                                    <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                            </div>
                            {{-- Modal restore --}}
                            <div class="modal fade" id="modal-restore{{ $item->id }}">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Konfirmasi restore data</h4>
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="card">
                                                <div class="card-header bg-info">
                                                    <h1>{{ $item->code }}</h1> <br>
                                                    <p>Yakin ingin memulihkan data tersebut? </p>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="modal-footer justify-content-between">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">
                                                Close</button>

                                            <a href="{{ route('restoreTahunAkademik', $item->id) }}"
                                                class="btn btn-sm btn-outline-dark">
                                                <i class="fa fa-undo-alt mr-2"></i>Ya, Pulihkan </a>

                                        </div>
                                    </div>
                                    <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                            </div>
                        @empty
                            <tr>
                                <td colspan="6" align="center">Data Tidak Tersedia</td>
                            </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>No</th>
                            <th>Kode</th>
                            <th>Keterangan</th>
                            <th>Status</th>
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.min.js"></script>
    <script>
        $(document).ready(function() {
            let elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
            elems.forEach(function(html) {
                let switchery = new Switchery(html, {
                    size: 'small',
                });
            });
        });
    </script>
@endpush
