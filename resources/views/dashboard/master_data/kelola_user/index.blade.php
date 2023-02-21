@include('components.head_table')
@extends('template.template')
@section('content-header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Kelola User</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    {{ Breadcrumbs::render('kelolaUser') }}
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
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($user as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->email }}</td>
                                <td>
                                    <span class="badge badge-info">{{ $item->roles->name }}</span></a>

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
                                                    <h1>{{ $item->name }}</h1> <br>
                                                    <h4>{{ $item->email }}</h4> <br>
                                                    <p>Yakin ingin menghapus data tersebut? </p>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="modal-footer justify-content-between">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">
                                                Close</button>
                                            <form action="{{ route('kelolaUser.destroy', $item->id) }}" method="post">
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
                                            <h4 class="modal-title">Edit Data</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form action="{{ route('kelolaUser.update', $item->id) }}" method="post">
                                            @csrf
                                            @method('put')
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label for="">Nama</label>
                                                    <input type="text" class="form-control" name="name"
                                                        value="{{ old('name') ?? $item->name }}" placeholder="Nama">
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Email</label>
                                                    <input type="email" class="form-control" name="email"
                                                        value="{{ old('email') ?? $item->email }}" placeholder="Email">
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Ubah Password <code>*optional</code></label>
                                                    <input type="password" class="form-control" name="password"
                                                        value="{{ old('password') }}" placeholder="Buat password baru..">
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
                                    <td colspan="5" align="center"> Data Tidak Tersedia</td>
                                </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>No</th>
                            <th>No Induk</th>
                            <th>Email</th>
                            <th>Role</th>
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
