@include('components.head_table')
@extends('template.template')
@section('content-header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Nilai Akhir </h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    {{ Breadcrumbs::render('penilaianAkhir.create') }}
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
            <div class="card-header bg-gradient-success">
                Form Penilaian
            </div>
            <div class="card-body">
                <ul>
                    <li>Mata Pelajaran : <strong>{{ $course }}</strong></li>
                    <li>Program : <strong>{{ $program }}</strong></li>
                    <li>Kelas : <strong>{{ $class }}</strong></li>
                    <li>Kategori : <strong>{{ $category }}</strong></li>
                </ul>
            </div>
        </div>
        <div class="card" style="overflow: auto;">
            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama </th>
                            <th>Kelas</th>
                            <th>Mapel</th>
                            <th>Nilai</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($student as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $item->student_name }}</td>
                                <td>{{ $item->class_name }}</td>
                                <td>{{ $item->course_name }}</td>
                                <td>{{ $item->score }}</td>
                                <td><button type="button" class="btn btn-sm" data-toggle="modal"
                                        data-target="#modal-Edit{{ $item->student_id }}">
                                        <i class="fa fa-edit"></i>
                                    </button></td>
                            </tr>
                            {{-- Modal new data --}}
                            <div class="modal fade" id="modal-Edit{{ $item->student_id }}" data-backdrop="static">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Penilaian</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form action="{{ route('penilaianAkhir.store', $item->student_id) }}"
                                            method="post">
                                            @csrf
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label for="">Nilai</label>
                                                    <input type="text" name="score" id="" class="form-control"
                                                        value="{{ old('score') }}" placeholder="80 / A">
                                                    <input type="hidden" name="class" value="{{ $item->class_id }}">
                                                    <input type="hidden" name="category" value="{{ $idCategory }}">
                                                    <input type="hidden" name="course" value="{{ $item->course_id }}">
                                                </div>

                                            </div>
                                            <div class="modal-footer justify-content-between">
                                                <button type="button" class="btn btn-default"
                                                    data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-sm btn-primary">
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
                                                    Save</button>
                                            </div>
                                        </form>
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

                </table>
            </div>
        </div>
    </div>
@endsection
@include('components.footer_table')