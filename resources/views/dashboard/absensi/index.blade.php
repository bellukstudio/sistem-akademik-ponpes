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
            <form action="{{ route('presensi.index') }}" method="GET">
                @csrf
                <div class="form-group">
                    <label for="">Tipe Absen</label>
                    <select name="type" id="type" class="form-control select2" required>
                        <option value="">Pilih Absen</option>
                        @forelse ($type as $item)
                            <option value="{{ $item->id }}+{{ $item->categories }}+{{ $item->name }}">
                                {{ $item->name }}</option>
                        @empty
                            <option value=""></option>
                        @endforelse
                    </select>
                </div>
                <div class="form-group" id="other">
                    <label for="">Pilih Kategori</label>
                    <select name="otherSelect" id="otherSelect" class="form-control select2" required>
                        <option value="">Pilih</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="">Pilih</label>
                    <select name="optionSelect" id="optionSelect" class="form-control select2" required>
                        <option value="">Pilih</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="">Pilih Tanggal</label>
                    <input type="date" name="date_select" id="" class="form-control"
                        value="{{ old('date_select') }}" required>
                </div>
                <button type="submit" class="btn btn-primary" name="showData">
                    <i class="fa fa-eye mr-2"></i> Lihat Absen </button>

            </form>
        </div>
        <div class="card" style="overflow: auto;">
            <div class="card-header bg-gradient-success">
                @if ($tableHide == false)
                    <strong>TABEL ABSEN {{ $nameAttendance . ' (' . $otherCategory . ')  ' . $dataCategory }}</strong>
                @else
                    <strong>TABEL ABSEN</strong>
                @endif
            </div>
            <div class="card-body">
                @if ($tableHide == false)
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Kelas</th>
                                <th>Program</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($data as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{!! $item->student_name ?? '<span class="badge badge-danger">Error</span>' !!}</td>
                                    <td>{!! $item->class_name ?? '<span class="badge badge-danger">Error</span>' !!}</td>
                                    <td>{!! $item->program_name ?? '<span class="badge badge-danger">Error</span>' !!}</td>
                                    <td> <select name="status" id="status_{{ $index }}"
                                            class="custom-select form-control-border" data-student="{{ $item->student_id }}"
                                            data-type="{{ $dataType }}" data-category="{{ $dataCategory }}"
                                            data-program="{{ $item->id_program }}" data-other="{{ $otherCategory }}"
                                            data-date="{{ $dateSelect }}" data-id="{{ $item->id_attendance }}">
                                            <option value="" {{ $item->status === null ? 'selected' : '' }}>
                                                Pilih
                                                Status
                                            </option>
                                            <option value="Hadir" {{ $item->status === 'Hadir' ? 'selected' : '' }}>
                                                Hadir
                                            </option>
                                            <option value="Izin" {{ $item->status === 'Izin' ? 'selected' : '' }}>
                                                Izin
                                            </option>
                                            <option value="Alfa" {{ $item->status === 'Alfa' ? 'selected' : '' }}>
                                                Alfa
                                            </option>
                                            <option value="Sakit" {{ $item->status === 'Sakit' ? 'selected' : '' }}>
                                                Sakit
                                            </option>
                                        </select>
                                    </td>
                                    <td>
                                        @if ($item->id_attendance != null)
                                            <button type="button" class="btn btn-danger" data-toggle="modal"
                                                data-target="#modal-Delete{{ $item->id_attendance }}">
                                                <i class="fa fa-trash"></i>
                                            </button>&nbsp;
                                        @endif

                                    </td>

                                </tr>

                                @if ($item->id_attendance != null)
                                    {{-- Modal Delete --}}
                                    <div class="modal fade" id="modal-Delete{{ $item->id_attendance }}">
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
                                                            <h5>{!! $item->class_name ?? '<span class="badge badge-danger">Error</span>' !!}</h5>
                                                            <h5>{!! $item->program_name ?? '<span class="badge badge-danger">Error</span>' !!}</h5>
                                                            <p>Yakin ingin menghapus absen santri tersebut? </p>
                                                        </div>

                                                    </div>
                                                </div>
                                                <div class="modal-footer justify-content-between">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">
                                                        Close</button>
                                                    <form action="{{ route('presensi.destroy', $item->id_attendance) }}"
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
                            @empty
                                <tr>
                                    <td colspan="8" align="center"> Data Tidak Tersedia</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                @endif
            </div>
        </div>

    </div>
@endsection
@extends('components.footer_table')
@push('new-script')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="{{ asset('template/plugins/select2/js/select2.full.min.js') }}"></script>
    <script>
        $(function() {
            $('.select2').select2();
            //add class d-none
            $('#other').addClass('d-none');
            getTypeAbsen();
            saveAttendance();

            function saveAttendance() {
                //save attendance
                //count row
                var rowCount = $('#example1 tbody tr').length;
                for (var i = 0; i < rowCount; i++) {
                    $('#status_' + i).change(function() {
                        let id = $(this).data('id');
                        let studentId = $(this).data('student');
                        let typeId = $(this).data('type');
                        let category = $(this).data('category');
                        let programId = $(this).data('program');
                        let otherCategory = $(this).data('other');
                        var data = $(this).val();
                        let dateSelect = $(this).data('date');

                        $.ajax({
                            type: 'GET',
                            dataType: 'json',
                            url: '{{ route('saveAttendance') }}',
                            data: {
                                'status': data,
                                'student': studentId,
                                'type': typeId,
                                'program': programId,
                                'category': category,
                                'other_category': otherCategory,
                                'dateSelect': dateSelect
                            },
                            success: function(res) {
                                toastr.options.closeButton = true;
                                toastr.options.closeMethod = 'fadeOut';
                                toastr.options.closeDuration = 100;
                                toastr.success(res.message);

                            },
                            error: function(xhr) {
                                toastr.options.closeButton = true;
                                toastr.options.closeMethod = 'fadeOut';
                                toastr.options.closeDuration = 100;
                                toastr.error(xhr.message);
                            }
                        });

                    });
                }


            }


            function getTypeAbsen() {

                $('#type').change(function() {
                    var value = $(this).val();
                    let splitData = value.split('+');
                    let category = splitData[1];
                    let category1 = splitData[2];
                    $('#optionSelect').find('option').not(':first').remove();

                    if (category === 'Pengajar') {
                        if (category1 === 'SETORAN') {
                            //remove class d-none
                            $('#other').removeClass('d-none');
                            $('#otherSelect').find('option').not(':first').remove();

                            let times = ["Pagi", "Siang", "Sore", "Malam"];
                            let tag = "";
                            for (let index = 0; index < times.length; index++) {
                                tag = "<option value=" + "'" + times[index] + "'" + ">" + times[index] +
                                    "</option>";
                                $("#otherSelect").append(tag);
                            }
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
                        } else {
                            //add class d-none
                            $('#other').removeClass('d-none');
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
                        }
                    } else if (category === 'Kelas') {
                        if (category1 === 'TAKLIM') {
                            //remove class d-none
                            $('#other').removeClass('d-none');
                            $('#otherSelect').find('option').not(':first').remove();

                            let times = ["Pagi", "Siang", "Sore", "Malam"];
                            let tag = "";
                            for (let index = 0; index < times.length; index++) {
                                tag = "<option value=" + "'" + times[index] + "'" + ">" + times[index] +
                                    "</option>";
                                $("#otherSelect").append(tag);
                            }

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
                        } else {
                            $('#other').addClass('d-none');
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
                        }

                    } else if (category === 'Program') {
                        //add class d-none
                        $('#other').addClass('d-none');
                        if (category1 === 'SHALAT') {
                            //REMOVE class d-none
                            $('#other').removeClass('d-none');
                            $('#otherSelect').find('option').not(':first').remove();

                            let shalat = ["Shubuh", "Dzhuhur", "Ashar", "Maghrib", 'Isya'];
                            let tag = "";
                            for (let index = 0; index < shalat.length; index++) {
                                tag = "<option value=" + "'" + shalat[index] + "'" + ">" + shalat[index] +
                                    "</option>";
                                $("#otherSelect").append(tag);
                            }
                        }
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
            }
        });
    </script>
@endpush
