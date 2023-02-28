@include('components.head_table')
@extends('template.template')
@section('content-header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Nilai Akhir</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    {{ Breadcrumbs::render('penilaianAkhir') }}
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
                            @foreach ($categoryAssessment as $category)
                                <option value="{{ $category->id . '+' . $category->program_id }}">
                                    {{ $category->name }}</option>
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
                                var name = response['data'][i].course_name;
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
