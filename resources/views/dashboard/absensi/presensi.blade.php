@include('components.head_table')
@extends('template.template')
@section('content-header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Presensi</h1><br>

            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    {{-- {{ Breadcrumbs::render('beritaAcara') }} --}}
                </ol>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>
@endsection
@section('content-section')
    <div class="container-fluid">
        {{-- alert --}}
        @include('components.alert')

        <div class="card p-3">
            {{-- form search --}}
            <form action="{{ route('filterAttendances') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="">Tipe Absen</label>
                    <select name="type" id="type" class="custom-select form-control-border">
                        <option value="">Pilih Absen</option>
                        @forelse ($type as $item)
                            <option value="{{ $item->id }}+{{ $item->categories }}">{{ $item->name }}</option>
                        @empty
                            <option value=""></option>
                        @endforelse
                    </select>
                </div>
                <div class="form-group">
                    <label for="">Pilih</label>
                    <select name="optionSelect" id="optionSelect" class="custom-select form-control-border">
                        <option value="">Pilih</option>
                    </select>
                </div>
                <div class="form-group ">
                    <label for="">Tanggal</label>
                    <input type="date" name="date_presence" id="" class="form-control">
                </div>
                <button type="submit" class="btn btn-primary" name="showData">
                    <i class="fa fa-eye mr-2"></i> Lihat Absen </button>

            </form>
        </div>
        <div class="card">
            <div class="card-header bg-gradient-indigo">
                Tabel Absen
            </div>
            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Kelas</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($data as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{!! $item->student_name ?? '<span class="badge badge-danger">Error</span>' !!}</td>
                                <td>{!! $item->class_name ?? '<span class="badge badge-danger">Error</span>' !!}</td>
                                <td><select name="status" id="" class="custom-select form-control-border">
                                        <option value="Izin">Izin</option>
                                        <option value="Sakit">Sakit</option>
                                        <option value="Alfa">Alfa</option>
                                        <option value="Hadir">Hadir</option>
                                    </select></td>
                            </tr>
                        @empty
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@extends('components.footer_table')
@push('new-script')
    <script>
        $(function() {
            $('#type').change(function() {
                var value = $(this).val();
                let splitData = value.split('+');
                let category = splitData[1];
                $('#optionSelect').find('option').not(':first').remove();

                if (category === 'Pengajar') {
                    $.ajax({
                        url: '{{ route('allTeachers') }}',
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
                                    var name = response['data'][i].name;
                                    // variable option
                                    var option = "";
                                    option = "<option value='" + id + "'>" + name +
                                        "</option>";

                                    $("#optionSelect").append(option);
                                }
                            }
                        }
                    });
                } else if (category === 'Kelas') {
                    $.ajax({
                        url: '{{ route('allClass') }}',
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

                                    $("#optionSelect").append(option);
                                }
                            }
                        }
                    });
                } else if (category === 'Program') {
                    $.ajax({
                        url: '{{ route('getAllProgram') }}',
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
                                    var name = response['data'][i].program_name;
                                    // variable option
                                    var option = "";
                                    option = "<option value='" + id + "'>" + name +
                                        "</option>";

                                    $("#optionSelect").append(option);
                                }
                            }
                        }
                    });
                }
            });
        });
    </script>
@endpush
