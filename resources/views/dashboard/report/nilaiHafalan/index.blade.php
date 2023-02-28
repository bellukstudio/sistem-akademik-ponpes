@include('components.head')
@extends('template.template')
@section('content-header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Laporan Hafalan </h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    {{-- {{ Breadcrumbs::render('perizinan') }} --}}
                </ol>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>
@endsection
@section('content-section')
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header bg-gradient-lightblue">
                    <h3 class="card-title">Generate Laporan</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('nilai-hafalan-report.filter') }}" method="POST" target="_blank">
                        @csrf
                        <div class="form-group">
                            <label for="">Pilih Program</label>
                            <select class="form-control select2" style="width: 100%;" name="program_select"
                                id="program_select">
                                <option value="">Pilih Program</option>
                                @forelse ($program as $item)
                                    <option value="{{ $item->id }}">{{ $item->program_name }}</option>
                                @empty
                                    <option value=""></option>
                                @endforelse
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Cari Kelas</label>
                            <select name="searchClass" id="searchClass" class="form-control select2">
                                <option value="">Pilih</option>

                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Cari Santri</label>
                            <select name="studentData" id="studentData" class="form-control select2">
                                <option value="">Pilih</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Tahun Akademik</label>
                            <select name="periode_academic" id="periode_academic" class="form-control select2">
                                @foreach ($period as $item)
                                    <option value="{{ $item->id }}">{{ $item->code }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-download mr-2"> </i> Unduh Laporan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
@extends('components.footer')
@push('new-script')
    <!-- Select2 -->
    <script src="{{ asset('template/plugins/select2/js/select2.full.min.js') }}"></script>
    <script>
        $(function() {
            $('.select2').select2();
            getStudentByClass();
            getClassByProgram();


            function getClassByProgram() {
                $('#program_select').change(function() {
                    var idProgram = $(this).val();

                    $('#searchClass').find('option').not(':first').remove();
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

                                    $("#searchClass").append(option);
                                }
                            }
                        }
                    });
                });
            }

            function getStudentByClass() {
                $('#searchClass').change(function() {
                    var value = $(this).val();
                    $('#studentData').find('option').not(':first').remove();
                    var classByProgramUrl = '{{ route('getStudentByClass', ':id') }}';
                    classByProgramUrl = classByProgramUrl.replace(':id', value);
                    $.ajax({
                        url: classByProgramUrl,
                        type: 'GET',
                        dataType: 'json',
                        success: function(response) {
                            if (response['data'] != null) {
                                len = response['data'].length;
                            }
                            if (len > 0) {
                                // Read data and create <option >
                                for (var i = 0; i < len; i++) {

                                    var id = response['data'][i].id_student;
                                    var name = response['data'][i].student_name;
                                    // variable option
                                    var option = "";
                                    option = "<option value='" + id + "'>" + name +
                                        "</option>";

                                    $("#studentData").append(option);
                                }
                            }
                        }
                    });
                });
            }
        });
    </script>
@endpush
