@include('components.head_table')
@extends('template.template')
@section('content-header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Nilai Hafalan</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    {{ Breadcrumbs::render('nilaiHafalan') }}
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
                <form action="{{ route('hafalanSurah.create') }}" method="GET">
                    @csrf
                    <div class="form-group">
                        <label for="">Program</label>
                        <select name="program" id="program" class="custom-select form-control">
                            <option value="">Pilih</option>
                            @foreach ($program as $c)
                                <option value="{{ $c->id }}">{{ $c->program_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Kelas</label>
                        <select name="class" id="class" class="custom-select form-control">
                            <option value="">Pilih</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Nama Surah</label>
                        <select name="surah_name" id="surah" class="custom-select form-control-border">
                            <option value="">Pilih Surah</option>
                            @foreach ($apiQuran as $surah)
                                <option value="{{ $surah->nama_latin }}">{{ $surah->nama_latin }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group" id="verseText">
                        <label for="">Masukan Ayat Baru</label>
                        <input type="text" name="verseText" id="" class="form-control"
                            placeholder="Ayat 1 - 2 atau Ayat 2 dan 5" value="{{ old('verse') }}">
                    </div>
                    <div class="form-group">
                        <label for="">Pilih Ayat Yang Sudah Ada</label>
                        <select name="verseOption" id="verseOption" class="custom-select form-control-border">
                            <option value="">Pilih Ayat</option>
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
    <script>
        $(function() {
            getClassByProgramId();
            getVerseBySurah();


            function getClassByProgramId() {
                $('#program').change(function() {
                    var value = $(this).val();
                    $('#class').find('option').not(':first').remove();
                    var classByProgramUrl = '{{ route('classByProgram', ':id') }}';
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

            function getVerseBySurah() {
                $('#surah').change(function() {
                    var value = $(this).val();
                    console.log(value)
                    $('#verseOption').find('option').not(':first').remove();
                    $.ajax({
                        url: '{{ route('getVerseBySurahNamed') }}',
                        type: 'GET',
                        data: {
                            'surah': value
                        },
                        dataType: 'json',
                        success: function(response) {
                            console.log(response['data']);
                            if (response['data'] != null) {
                                len = response['data'].length;

                            }

                            if (len > 0) {
                                // Read data and create <option >
                                for (var i = 0; i < len; i++) {

                                    var name = response['data'][i].verse;
                                    // variable option
                                    var option = "";
                                    option = "<option value='" + name + "'>" + name +
                                        "</option>";

                                    $("#verseOption").append(option);
                                }
                            }
                        }
                    });
                });
            }
        });
    </script>
@endpush
