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
            <div class="card-header">
                Form Penilaian
            </div>
            <div class="card-body">
                <form action="{{ route('penilaianAkhir.create') }}" method="GET">
                    @csrf
                    <div class="form-group">
                        <label for="">Kategori</label>
                        <select name="category" id="category" class="form-control select2">
                            <option value="">Pilih</option>
                            @foreach ($categoryAssessmentAll as $categoryAll)
                                <option value="{{ $categoryAll->id . '+' . $categoryAll->program_id }}">
                                    {{ $categoryAll->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Program</label>
                        <select name="program" id="program" class="form-control select2">
                            <option value="">Pilih</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Kelas</label>
                        <select name="class" id="class" class="form-control select2">
                            <option value="">Pilih</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Mata Pelajaran</label>
                        <select name="course" id="course" class="form-control select2">
                            <option value="">Pilih</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Lihat / Lakukan Penilaian</button>
                    </div>
                </form>
            </div>
        </div>

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
                                <td>
                                    @if ($item->id_score == null)
                                        <button type="button" class="btn btn-sm" data-toggle="modal"
                                            data-target="#modal-Edit{{ $item->student_id }}">
                                            <i class="fa fa-edit"></i>
                                        </button>
                                    @endif
                                    @if ($item->id_score != null)
                                        <button type="button" class="btn btn-danger" data-toggle="modal"
                                            data-target="#modal-Delete{{ $item->id_score }}">
                                            <i class="fa fa-trash"></i>
                                        </button>&nbsp;
                                    @endif
                                </td>
                            </tr>
                            @if ($item->id_score != null)
                                {{-- Modal Delete --}}
                                <div class="modal fade" id="modal-Delete{{ $item->id_score }}">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Konfirmasi hapus data</h4>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="card">
                                                    <div class="card-header bg-danger">
                                                        <h5>{!! $item->student_name ?? '<span class="badge badge-danger">Error</span>' !!}</h5>
                                                        <p>Yakin ingin menghapus nilai santri tersebut? </p>
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="modal-footer justify-content-between">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">
                                                    Close</button>
                                                <form action="{{ route('penilaianAkhir.destroy', $item->id_score) }}"
                                                    method="post">
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
                            @endif
                            @if ($item->id_score == null)
                                {{-- Modal new data --}}
                                <div class="modal fade" id="modal-Edit{{ $item->student_id }}" data-backdrop="static">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Penilaian</h4>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form action="{{ route('penilaianAkhir.store', $item->student_id) }}"
                                                method="post">
                                                @csrf
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label for="">Nilai</label>
                                                        <input type="number" name="score" id=""
                                                            class="form-control" value="{{ old('score') }}"
                                                            placeholder="80">
                                                        <input type="hidden" name="class"
                                                            value="{{ $item->class_id }}">
                                                        <input type="hidden" name="category"
                                                            value="{{ $idCategory }}">
                                                        <input type="hidden" name="course"
                                                            value="{{ $item->course_id }}">
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
                            @endif
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
@extends('components.footer_table')
@push('new-script')
    <script src="{{ asset('template/plugins/select2/js/select2.full.min.js') }}"></script>
    <script>
        $(function() {
            $('.select2').select2();
            getCategoryAssessmentByProgram();
            getClassByProgram();
            getCourseByProgram();

            function getCategoryAssessmentByProgram() {
                $('#category').change(function() {
                    var value = $(this).val();
                    let splitData = value.split('+');
                    var category = splitData[1];
                    $('#program').find('option').not(':first').remove();
                    $.ajax({
                        url: '{{ route('getCategoryAssessmentByProgramId') }}',
                        type: 'GET',
                        dataType: 'json',
                        data: {
                            'program': category
                        },
                        success: function(response) {
                            if (response['data'] != null) {
                                len = response['data'].length;
                            }
                            if (len > 0) {
                                // Read data and create <option >
                                for (var i = 0; i < len; i++) {

                                    var id = response['data'][i].id;
                                    var name = response['data'][i].program_name;
                                    // variable option
                                    var option = "";
                                    option = "<option value='" + id + "'>" + name +
                                        "</option>";

                                    $("#program").append(option);
                                }
                            }
                        }
                    });
                });
            }
        });

        function getClassByProgram() {
            $('#program').change(function() {
                var value = $(this).val();
                $('#class').find('option').not(':first').remove();
                var url = '{{ route('classByProgram', ':id') }}';
                url = url.replace(':id', value);
                $.ajax({
                    url: url,
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        if (response['data'] != null) {
                            len = response['data'].length;
                        }
                        if (len > 0) {
                            // Read data and create <option >
                            for (var i = 0; i < len; i++) {

                                var id = response['data'][i].id;
                                var name = response['data'][i].class_name;
                                // variable option
                                var option = "";
                                option = "<option value='" + id + "'>" + name +
                                    "</option>";

                                $("#class").append(option);
                            }
                        }
                    }
                });
            });
        }

        function getCourseByProgram() {
            $('#program').change(function() {
                var value = $(this).val();
                $('#course').find('option').not(':first').remove();
                $.ajax({
                    url: '{{ route('getAllCourseByProgram') }}',
                    type: 'GET',
                    dataType: 'json',
                    data: {
                        'program': value
                    },
                    success: function(response) {
                        if (response['data'] != null) {
                            len = response['data'].length;
                        }
                        if (len > 0) {
                            // Read data and create <option >
                            for (var i = 0; i < len; i++) {

                                var id = response['data'][i].id;
                                var name = response['data'][i].course_name + '  ' + '(' + response[
                                        'data'][i]
                                    .category.categorie_name + ')';
                                // variable option
                                var option = "";
                                option = "<option value='" + id + "'>" + name +
                                    "</option>";

                                $("#course").append(option);
                            }
                        }
                    }
                });
            });
        }
    </script>
@endpush
