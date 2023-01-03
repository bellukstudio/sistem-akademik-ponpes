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
                        <select name="class_select[]" id="" class="form-control select2" style="width: 100%;"
                            multiple="multiple" data-placeholder="Pilih Kelas">
                            @forelse ($class as $c)
                                <option value="{{ $c->id }}">{{ $c->class_name }}</option>
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
                                <option value="{{ $p->id }}">{{ $p->course_name }}</option>
                            @empty
                                <option value=""></option>
                            @endforelse
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
            $('.select2').select2();
        });
    </script>
@endpush
