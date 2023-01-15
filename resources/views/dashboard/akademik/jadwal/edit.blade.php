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
                        <select name="class_select" id="" class="form-control select2" style="width: 100%;">
                            <option value="">Pilih Kelas</option>
                            @forelse ($class as $c)
                                <option value="{{ $c->id }}" {{ $data->class_id == $c->id ? 'selected' : '' }}>
                                    {{ $c->class_name }}</option>
                            @empty
                                <option value=""></option>
                            @endforelse
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Pilih Mata Pelajaran</label>
                        <select name="course_select" id="" class="form-control select2" style="width: 100%;">
                            <option value="">Pilih Mata Pelajaran</option>
                            @forelse ($course as $p)
                                <option value="{{ $p->id }}" {{ $data->course_id == $p->id ? 'selected' : '' }}>
                                    {{ $p->course_name }}</option>
                            @empty
                                <option value=""></option>
                            @endforelse
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
            $('.select2').select2();
        });
    </script>
@endpush
