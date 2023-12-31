@include('components.head_table')
@extends('template.template')
@section('content-header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Tahun Akademik</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    {{ Breadcrumbs::render('kelolaTahunAkademik') }}
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
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-AddData">
                    <i class="fa fa-plus mr-2"></i> Tambah Data Baru
                </button>
                <a href="{{ route('trashTahunAkademik') }}" class="btn btn-secondary">
                    <i class="fa fa-trash mr-2"></i>Trash
                    Bin</a>

                {{-- Modal new data --}}
                <div class="modal fade" id="modal-AddData">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Tambah Data Baru</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="{{ route('kelolaTahunAkademik.store') }}" method="post">
                                @csrf
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="">Kode</label>
                                        <input type="text" name="code" id="" class="form-control"
                                            value="{{ old('code') }}" placeholder="2019/2020">
                                    </div>

                                    <div class="form-group">
                                        <label for="">Keterangan </label>
                                        <input type="text" name="information" id="" class="form-control"
                                            value="{{ old('information') }}" placeholder="Semester Genap">
                                    </div>

                                </div>
                                <div class="modal-footer justify-content-between">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-sm btn-primary">
                                        <svg style="color: white" xmlns="http://www.w3.org/2000/svg" width="16"
                                            height="16" fill="currentColor" class="bi bi-send mr-2" viewBox="0 0 16 16">
                                            <path
                                                d="M15.854.146a.5.5 0 0 1 .11.54l-5.819 14.547a.75.75 0 0 1-1.329
                                                .124l-3.178-4.995L.643 7.184a.75.75 0 0 1
                                                 .124-1.33L15.314.037a.5.5 0 0 1 .54.11ZM6.636 10.07l2.761
                                                 4.338L14.13 2.576 6.636 10.07Zm6.787-8.201L1.591
                                                 6.602l4.339 2.76 7.494-7.493Z"
                                                fill="white"></path>
                                        </svg>
                                        Save</button>
                                </div>
                            </form>
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
                        @forelse ($tahunAkademik as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $item->code }}</td>
                                <td>{{ $item->information }}</td>
                                <td>
                                    <input type="checkbox" data-id="{{ $item->id }}" name="status" class="js-switch"
                                        {{ $item->status == 1 ? 'checked' : '' }}>
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
                                                    <h1>{{ $item->code }}</h1> <br>
                                                    <p>Yakin ingin menghapus data tersebut? </p>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="modal-footer justify-content-between">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">
                                                Close</button>
                                            <form action="{{ route('kelolaTahunAkademik.destroy', $item->id) }}"
                                                method="post">
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
                                            <h4 class="modal-title">Edit Data {{ $item->code }} </h4>
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form action="{{ route('kelolaTahunAkademik.update', $item->id) }}"
                                            method="post">
                                            @csrf
                                            @method('put')
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label for="">Kode</label>
                                                    <input type="text" name="code" id=""
                                                        class="form-control" value="{{ old('code') ?? $item->code }}"
                                                        placeholder="2019/2020">
                                                </div>

                                                <div class="form-group">
                                                    <label for="">Keterangan </label>
                                                    <input type="text" name="information" id=""
                                                        class="form-control"
                                                        value="{{ old('information') ?? $item->information }}"
                                                        placeholder="Semester Genap / etc">
                                                </div>

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
                                    <td colspan="6" align="center"> Data Tidak Tersedia</td>
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

        {{-- </div> --}}
    </div>
@endsection
@extends('components.footer_table')
@push('new-script')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        $(document).ready(function() {
            let switcheryArray = [];
            let elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
            elems.forEach(function(html) {
                let switchery = new Switchery(html, {
                    size: 'small',
                });
                switcheryArray.push(switchery);
            });
            $('.js-switch').change(function() {
                let switchElm = $(this);
                let status = switchElm.prop('checked') === true ? 1 : 0;
                let id = switchElm.data('id');
                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: '{{ route('updateStatusTahun') }}',
                    data: {
                        'status': status,
                        'id': id
                    },
                    success: function(data) {
                        toastr.options.closeButton = true;
                        toastr.options.closeMethod = 'fadeOut';
                        toastr.options.closeDuration = 100;
                        toastr.success(data.message);
                    },
                    error: function(data) {
                        toastr.options.closeButton = true;
                        toastr.options.closeMethod = 'fadeOut';
                        toastr.options.closeDuration = 100;
                        toastr.error('Tidak dapat mengubah status');
                        let index = elems.indexOf(switchElm[0]);
                        setTimeout(function() {
                            switcheryArray[index].setPosition(true);
                        }, 1000);
                    }
                });
            });
        });
    </script>
@endpush
