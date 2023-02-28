@include('components.head')
@extends('template.template')
@section('content-header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Tambah Jadwal Pelajaran</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    {{ Breadcrumbs::render('kelolaJadwal.create') }}
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
            <div class="card-header bg-gradient-blue">
                Tambah Jadwal Pelajaran
            </div>
            <form action="{{ route('jadwalPelajaran.store') }}" method="post">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="">Pilih Program</label>
                        <select class="form-control select2" style="width: 100%;" name="program_select" id="program_select">
                            <option value="">Pilih Program</option>
                            @forelse ($program as $item)
                                <option value="{{ $item->id }}">{{ $item->program_name }}</option>
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
                                <option value="{{ $t->id }}">{{ $t->name }}</option>
                            @empty
                                <option value=""></option>
                            @endforelse
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Pilih Kelas</label>
                        <select name="class_select[]" id="class_select" class="form-control select2" style="width: 100%;"
                            multiple="multiple" data-placeholder="Pilih Kelas">
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
                            <option value="Ahad">Ahad</option>
                            <option value="Senin">Senin</option>
                            <option value="Selasa">Selasa</option>
                            <option value="Rabu">Rabu</option>
                            <option value="Kamis">Kamis</option>
                            <option value="Jumat">Jumat</option>
                            <option value="Sabtu">Sabtu</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Waktu</label>
                        <select name="time" id="" class="custom-select form-control-border">
                            <option value="">Pilih Waktu</option>
                            <option value="Pagi">Pagi</option>
                            <option value="Siang">Siang</option>
                            <option value="Sore">Sore</option>
                            <option value="Malam">Malam</option>
                        </select>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Save</button>
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
            getCourseByProgram();

            function getClassByProgram() {
                $('#program_select').change(function() {
                    var idProgram = $(this).val();

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

            function getCourseByProgram() {
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
