@include('components.head')
@extends('template.template')
@section('content-header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Edit Jadwal Pelajaran</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    {{ Breadcrumbs::render('kelolaJadwal.edit', $data) }}
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
            <div class="card-header bg-gradient-warning">
                Edit Jadwal Pelajaran
            </div>
            <form action="{{ route('jadwalPelajaran.update', $data->id) }}" method="post">
                @csrf
                @method('put')
                <div class="card-body">
                    <div class="form-group">
                        <label for="">Pilih Program</label>
                        <select class="form-control select2" style="width: 100%;" name="program_select" id="program_select">
                            <option value="">Pilih Program</option>
                            @forelse ($program as $item)
                                <option value="{{ $item->id }}"
                                    @if ($data->course != null) {{ $data->course->program_id == $item->id ? 'selected' : '' }}
                                    @else '' @endif>
                                    {{ $item->program_name ?? 'Error' }}</option>
                            @empty
                                <option value=""></option>
                            @endforelse
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Pilih Pengajar</label>
                        <select name="teacher_select" id="" class="form-control select2" style="width: 100%;">
                            <option value="">Pilih Pengajar</option>
                            @forelse ($teacher as $t)
                                <option value="{{ $t->id }}" {{ $data->teacher_id == $t->id ? 'selected' : '' }}>
                                    {{ $t->name }}</option>
                            @empty
                                <option value=""></option>
                            @endforelse
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Pilih Kelas</label>
                        <select name="class_select" id="class_select" class="form-control select2" style="width: 100%;">
                            <option value="">Pilih Kelas</option>

                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Pilih Mata Pelajaran</label>
                        <select name="course_select" id="course_select" class="form-control select2" style="width: 100%;">
                            <option value="">Pilih Mata Pelajaran</option>

                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Hari</label>
                        <select name="day" id="" class="custom-select form-control-border">
                            <option value="">Pilih Hari</option>
                            <option value="Ahad" {{ $data->day === 'Ahad' ? 'selected' : '' }}>Ahad</option>
                            <option value="Senin" {{ $data->day === 'Senin' ? 'selected' : '' }}>Senin</option>
                            <option value="Selasa" {{ $data->day === 'Selasa' ? 'selected' : '' }}>Selasa</option>
                            <option value="Rabu" {{ $data->day === 'Rabu' ? 'selected' : '' }}>Rabu</option>
                            <option value="Kamis" {{ $data->day === 'Kamis' ? 'selected' : '' }}>Kamis</option>
                            <option value="Jumat" {{ $data->day === 'Jumat' ? 'selected' : '' }}>Jumat</option>
                            <option value="Sabtu" {{ $data->day === 'Sabtu' ? 'selected' : '' }}>Sabtu</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Waktu</label>
                        <select name="time" id="" class="custom-select form-control-border">
                            <option value="">Pilih Waktu</option>
                            <option value="Pagi" {{ $data->time === 'Pagi' ? 'selected' : '' }}>Pagi</option>
                            <option value="Siang" {{ $data->time === 'Siang' ? 'selected' : '' }}>Siang</option>
                            <option value="Sore" {{ $data->time === 'Sore' ? 'selected' : '' }}>Sore</option>
                            <option value="Malam" {{ $data->time === 'Malam' ? 'selected' : '' }}>Malam</option>
                        </select>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-warning">Update</button>
                </div>
            </form>
        </div>
    </div>
@endsection
@extends('components.footer')
@push('new-script')
    <!-- Select2 -->
    <script src="{{ asset('template/plugins/select2/js/select2.full.min.js') }}"></script>

    <script>
        $(function() {
            getClassByProgram();
            getClassByProgramSelect();
            getCourseByProgramSelect();
            getCourseByProgram();

            function getClassByProgram() {
                // on update
                let class_id = '{{ $data->class_id ?? '' }}';
                let program_id = '{{ $data->course->program_id ?? '' }}';

                // url class by program
                var classByProgramUrl = '{{ route('classByProgram', ':id') }}';
                classByProgramUrl = classByProgramUrl.replace(':id', program_id);
                $.ajax({
                    url: classByProgramUrl,
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        var len = 0;
                        if (response['data'] != null) {
                            len = response['data'].length;
                        }
                        if (len > 0) {
                            // Read data and create <option >
                            for (var i = 0; i < len; i++) {

                                var id = response['data'][i].id;
                                var name = response['data'][i].class_name;

                                var option = '';
                                if (class_id == id) {
                                    option = "<option value='" + id + "' selected>" + name +
                                        "</option>";
                                } else {
                                    option = "<option value='" + id + "'>" + name + "</option>";
                                }

                                $("#class_select").append(option);
                            }
                        }
                    }
                });
            }

            function getCourseByProgram() {
                let program_id = '{{ $data->course->program_id ?? '' }}';
                let course_id = '{{ $data->course_id ?? '' }}';
                $.ajax({
                    url: '{{ route('getAllCourseByProgram') }}',
                    type: 'GET',
                    dataType: 'json',
                    data: {
                        'program': program_id
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

                                if (course_id == id) {
                                    option = "<option value='" + id + "' selected>" + name +
                                        "</option>";

                                } else {
                                    option = "<option value='" + id + "'>" + name +
                                        "</option>";
                                }
                                $("#course_select").append(option);
                            }
                        }
                    }
                });
            }

            function getClassByProgramSelect() {
                //program dropdown
                $('#program_select').change(function() {
                    // get value dropdown
                    var idProgram = $(this).val();


                    // class dropdown
                    $('#class_select').find('option').not(':first').remove();
                    // url class by program
                    var classByProgramUrl = '{{ route('classByProgram', ':id') }}';
                    classByProgramUrl = classByProgramUrl.replace(':id', idProgram);
                    $.ajax({
                        url: classByProgramUrl,
                        type: 'GET',
                        dataType: 'json',
                        success: function(response) {
                            var len = 0;
                            if (response['data'] != null) {
                                len = response['data'].length;
                            }
                            if (len > 0) {
                                // Read data and create <option >
                                for (var i = 0; i < len; i++) {

                                    var id = response['data'][i].id;
                                    var name = response['data'][i].class_name;

                                    var option = "<option value='" + id + "'>" + name +
                                        "</option>";

                                    $("#class_select").append(option);
                                }
                            }
                        }
                    });

                });
            }

            function getCourseByProgramSelect() {
                $('#program_select').change(function() {
                    var value = $(this).val();
                    $('#course_select').find('option').not(':first').remove();
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

                                    $("#course_select").append(option);
                                }
                            }
                        }
                    });
                });
            }
            $('.select2').select2();
        });
    </script>
@endpush
