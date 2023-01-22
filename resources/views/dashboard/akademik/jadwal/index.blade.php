@include('components.head_table')
@extends('template.template')
@section('content-header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Jadwal Pelajaran</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    {{ Breadcrumbs::render('kelolaJadwal') }}
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
                Filter Data
            </div>
            <div class="card-body">
                <form action="{{ route('getAllSchedule') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="">Kategori</label>
                        <select name="category" id="category" class="custom-select form-control-border">
                            <option value="">Pilih Kategori</option>
                            <option value="mapel">Per-Mata Pelajaran</option>
                            <option value="waktu">Per-Waktu</option>
                            <option value="kelas">Per-Kelas</option>
                            <option value="hari">Per-Hari</option>
                            <option value="program">Per-Program</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Pilih</label>
                        <select name="data" id="optionData" class="custom-select form-control-border">
                            <option value="">Pilih</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Kategori Mapel</label>
                        <select name="courseCategory" id="courseCategory" class="custom-select form-control-border">
                            <option value="">Pilih</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-info" id="showData" name="showButton"> <i
                                class="fa fa-eye mr-2"></i>
                            Lihat</button>
                        <button type="submit" class="btn btn-danger" name="exportPdf"><svg
                                xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-printer-fill" viewBox="0 0 16 16">
                                <path
                                    d="M5 1a2 2 0 0 0-2 2v1h10V3a2 2 0 0 0-2-2H5zm6 8H5a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1v-3a1 1 0 0 0-1-1z" />
                                <path
                                    d="M0 7a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2h-1v-2a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v2H2a2 2 0 0 1-2-2V7zm2.5 1a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z" />
                            </svg></i> Cetak PDF</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="card" style="overflow: auto;">
            <div class="card-header">
                <a href="{{ route('jadwalPelajaran.create') }}" class="btn btn-primary">
                    <i class="fa fa-plus mr-2"></i> Tambah Data Baru
                </a>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Pengajar</th>
                            <th>Mata Pelajaran</th>
                            <th>Kelas</th>
                            <th>Hari</th>
                            <th>Waktu</th>
                            <th>Kategori Mapel</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($jadwal as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{!! $item->teacher_name ?? '<span class="badge badge-danger">Error</span>' !!}</td>
                                <td>{!! $item->course_name ?? '<span class="badge badge-danger">Error</span>' !!}</td>
                                <td>{!! $item->class_name ?? '<span class="badge badge-danger">Error</span>' !!}</td>
                                <td>{{ $item->day }}</td>
                                <td>{{ $item->times }}</td>
                                <td>{{ $item->categorie_name }}</td>
                                <td>
                                    {{-- {Edit} --}}
                                    <a href="{{ route('jadwalPelajaran.edit', $item->id_schedules) }}" class="btn"><i
                                            class="fa fa-edit"></i></a>
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
                                                    <h4>Jadwal {!! $item->course_name ?? '<span class="badge badge-danger">Error</span>' !!}</h4>
                                                    <p>Pada {!! $item->class_name ?? '<span class="badge badge-danger">Error</span>' !!}</p> <br>
                                                    <p>Yakin ingin menghapus data tersebut? </p>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="modal-footer justify-content-between">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">
                                                Close</button>
                                            <form action="{{ route('jadwalPelajaran.destroy', $item->id_schedules) }}"
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
                        @empty
                            <tr>
                                <td colspan="8" align="center"> Data Tidak Tersedia</td>
                            </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>No</th>
                            <th>Nama Pengajar</th>
                            <th>Mata Pelajaran</th>
                            <th>Kelas</th>
                            <th>Hari</th>
                            <th>Waktu</th>
                            <th>Kategori Mapel</th>
                            <th>Aksi</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        @if ($filter == true)
            <div class="card" style="text-align: center;overflow: auto;">
                <div class="card-header">
                    <h1>Preview</h1>
                </div>
                <div class="card-body">
                    @if ($category === 'program')
                        <table class="table table-bordered table-striped" style="overflow: auto;">
                            <tr>
                                <th>Kelas</th>
                                <th>Waktu</th>
                                <th>Ahad</th>
                                <th>Senin</th>
                                <th>Selasa</th>
                                <th>Rabu</th>
                                <th>Kamis</th>
                                <th>Jumat</th>
                                <th>Sabtu</th>
                            </tr>
                            @forelse ($preview as $item)
                                <tr>
                                    <td rowspan="4">{{ $item->class_name }}</td>
                                    <td bgcolor="yellow">Pagi</td>
                                    <td>
                                        @foreach ($sundayMorning->where('class_id', $item->class_id) as $data)
                                            {{ $data->course->course_name ?? '-' }}
                                        @endforeach
                                    </td>
                                    <td>
                                        @foreach ($mondayMorning->where('class_id', $item->class_id) as $data)
                                            {{ $data->course->course_name ?? '-' }}
                                        @endforeach
                                    </td>
                                    <td>
                                        @foreach ($tuesdayMorning->where('class_id', $item->class_id) as $data)
                                            {{ $data->course->course_name ?? '-' }}
                                        @endforeach
                                    </td>
                                    <td>
                                        @foreach ($wednesdayMorning->where('class_id', $item->class_id) as $data)
                                            {{ $data->course->course_name ?? '-' }}
                                        @endforeach
                                    </td>
                                    <td>
                                        @foreach ($thursdayMorning->where('class_id', $item->class_id) as $data)
                                            {{ $data->course->course_name ?? '-' }}
                                        @endforeach
                                    </td>
                                    <td>
                                        @foreach ($fridayMorning->where('class_id', $item->class_id) as $data)
                                            {{ $data->course->course_name ?? '-' }}
                                        @endforeach
                                    </td>
                                    <td>
                                        @foreach ($saturdayMorning->where('class_id', $item->class_id) as $data)
                                            {{ $data->course->course_name ?? '-' }}
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <td bgcolor="yellow">Siang</td>
                                    <td>
                                        @foreach ($sundayAfternoon->where('class_id', $item->class_id) as $data)
                                            {{ $data->course->course_name ?? '-' }}
                                        @endforeach
                                    </td>
                                    <td>
                                        @foreach ($mondayAfternoon->where('class_id', $item->class_id) as $data)
                                            {{ $data->course->course_name ?? '-' }}
                                        @endforeach
                                    </td>
                                    <td>
                                        @foreach ($tuesdayAfternoon->where('class_id', $item->class_id) as $data)
                                            {{ $data->course->course_name ?? '-' }}
                                        @endforeach
                                    </td>
                                    <td>
                                        @foreach ($wednesdayAfternoon->where('class_id', $item->class_id) as $data)
                                            {{ $data->course->course_name ?? '-' }}
                                        @endforeach
                                    </td>
                                    <td>
                                        @foreach ($thursdayAfternoon->where('class_id', $item->class_id) as $data)
                                            {{ $data->course->course_name ?? '-' }}
                                        @endforeach
                                    </td>
                                    <td>
                                        @foreach ($fridayAfternoon->where('class_id', $item->class_id) as $data)
                                            {{ $data->course->course_name ?? '-' }}
                                        @endforeach
                                    </td>
                                    <td>
                                        @foreach ($saturdayAfternoon->where('class_id', $item->class_id) as $data)
                                            {{ $data->course->course_name ?? '-' }}
                                        @endforeach
                                    </td>

                                </tr>
                                <tr>
                                    <td bgcolor="yellow">Sore</td>
                                    <td>
                                        @foreach ($sundayEvening->where('class_id', $item->class_id) as $data)
                                            {{ $data->course->course_name ?? '-' }}
                                        @endforeach
                                    </td>
                                    <td>
                                        @foreach ($mondayEvening->where('class_id', $item->class_id) as $data)
                                            {{ $data->course->course_name ?? '-' }}
                                        @endforeach
                                    </td>
                                    <td>
                                        @foreach ($tuesdayEvening->where('class_id', $item->class_id) as $data)
                                            {{ $data->course->course_name ?? '-' }}
                                        @endforeach
                                    </td>
                                    <td>
                                        @foreach ($wednesdayEvening->where('class_id', $item->class_id) as $data)
                                            {{ $data->course->course_name ?? '-' }}
                                        @endforeach
                                    </td>
                                    <td>
                                        @foreach ($thursdayEvening->where('class_id', $item->class_id) as $data)
                                            {{ $data->course->course_name ?? '-' }}
                                        @endforeach
                                    </td>
                                    <td>
                                        @foreach ($fridayEvening->where('class_id', $item->class_id) as $data)
                                            {{ $data->course->course_name ?? '-' }}
                                        @endforeach
                                    </td>
                                    <td>
                                        @foreach ($saturdayEvening->where('class_id', $item->class_id) as $data)
                                            {{ $data->course->course_name ?? '-' }}
                                        @endforeach
                                    </td>

                                </tr>
                                <tr>
                                    <td bgcolor="yellow">Malam</td>
                                    <td>
                                        @foreach ($sundayNight->where('class_id', $item->class_id) as $data)
                                            {{ $data->course->course_name ?? '-' }}
                                        @endforeach
                                    </td>
                                    <td>
                                        @foreach ($mondayNight->where('class_id', $item->class_id) as $data)
                                            {{ $data->course->course_name ?? '-' }}
                                        @endforeach
                                    </td>
                                    <td>
                                        @foreach ($tuesdayNight->where('class_id', $item->class_id) as $data)
                                            {{ $data->course->course_name ?? '-' }}
                                        @endforeach
                                    </td>
                                    <td>
                                        @foreach ($wednesdayNight->where('class_id', $item->class_id) as $data)
                                            {{ $data->course->course_name ?? '-' }}
                                        @endforeach
                                    </td>
                                    <td>
                                        @foreach ($thursdayNight->where('class_id', $item->class_id) as $data)
                                            {{ $data->course->course_name ?? '-' }}
                                        @endforeach
                                    </td>
                                    <td>
                                        @foreach ($fridayNight->where('class_id', $item->class_id) as $data)
                                            {{ $data->course->course_name ?? '-' }}
                                        @endforeach
                                    </td>
                                    <td>
                                        @foreach ($saturdayNight->where('class_id', $item->class_id) as $data)
                                            {{ $data->course->course_name ?? '-' }}
                                        @endforeach
                                    </td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9">Tidak ada data</td>
                                </tr>
                            @endforelse
                        </table>
                    @else
                        <table class="table table-bordered table-striped">
                            <tr>
                                <th rowspan="2">Nama Pengajar</th>
                                <th rowspan="2">Mata Pelajaran</th>
                                <th rowspan="2">Kelas</th>
                                <th colspan="2">Jadwal</th>
                            </tr>
                            <tr>
                                <th>Hari</th>
                                <th>Waktu</th>
                            </tr>
                            @foreach ($jadwal as $item)
                                <tr>
                                    <td>{{ $item->teacher_name }}</td>
                                    <td>{{ $item->course_name }}</td>
                                    <td>{{ $item->class_name }}</td>
                                    <td>{{ $item->day }}</td>
                                    <td>{{ $item->times }}</td>
                                </tr>
                            @endforeach

                        </table>
                    @endif


                </div>
            </div>
        @else
            <div></div>
        @endif



    </div>
@endsection
@extends('components.footer_table')
@push('new-script')
    <!-- Select2 -->
    <script>
        $(function() {
            //get course category
            $('#courseCategory').find('option').not(':first').remove();
            $.ajax({
                url: '{{ route('getAllCategoryCourse') }}',
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
                            var name = response['data'][i].categorie_name;
                            // variable option
                            var option = "";
                            option = "<option value='" + id + "'>" + name +
                                "</option>";

                            $("#courseCategory").append(option);
                        }
                    }
                }
            });
            //
            $('#category').change(function() {
                var value = $(this).val();
                $('#optionData').find('option').not(':first').remove();
                console.log(value);
                if (value === 'mapel') {
                    $.ajax({
                        url: '{{ route('allCourse') }}',
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
                                    var name = response['data'][i].course_name;
                                    // variable option
                                    var option = "";
                                    option = "<option value='" + id + "'>" + name +
                                        "</option>";

                                    $("#optionData").append(option);
                                }
                            }
                        }
                    });
                } else if (value === 'waktu') {
                    let times = ["Pagi", "Siang", "Sore", "Malam"];
                    let tag = "";
                    for (let index = 0; index < times.length; index++) {
                        tag = "<option value=" + "'" + times[index] + "'" + ">" + times[index] +
                            "</option>";
                        $("#optionData").append(tag);
                    }
                } else if (value === 'kelas') {
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

                                    $("#optionData").append(option);
                                }
                            }
                        }
                    });
                } else if (value === 'hari') {
                    let day = ['Ahad', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
                    let tag = "";
                    for (let index = 0; index < day.length; index++) {
                        tag = "<option value=" + "'" + day[index] + "'" + ">" + day[index] +
                            "</option>";
                        $("#optionData").append(tag);
                    }
                } else if (value === 'program') {
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

                                    $("#optionData").append(option);
                                }
                            }
                        }
                    });
                }
            });
        });
    </script>
@endpush
