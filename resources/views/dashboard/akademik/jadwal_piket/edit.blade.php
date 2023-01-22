@include('components.head')
@extends('template.template')
@section('content-header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Edit Jadwal Piket</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    {{ Breadcrumbs::render('jadwalPiket.edit', $picket) }}
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
                Edit Jadwal Piket
            </div>
            <form action="{{ route('jadwalPiket.update', $picket->id) }}" method="post">
                @csrf
                @method('put')
                <div class="card-body">
                    <div class="form-group">
                        <label for="">Pilih Kategori</label>
                        <select name="category" id="" class="form-control select2" style="width: 100%;">
                            <option value="">Pilih</option>
                            @forelse ($category as $s)
                                <option value="{{ $s->id }}" {{ $picket->id_category === $s->id ? 'selected' : '' }}>
                                    {{ $s->name }}</option>
                            @empty
                                <option value=""></option>
                            @endforelse
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Pilih Santri</label>
                        <select name="student_select" id="" class="form-control select2" style="width: 100%;">
                            <option value="">Pilih Santri</option>
                            @forelse ($student as $s)
                                <option value="{{ $s->id }}" {{ $picket->student_id == $s->id ? 'selected' : '' }}>
                                    {{ $s->name }}</option>
                            @empty
                                <option value=""></option>
                            @endforelse
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Pilih Ruangan</label>
                        <select name="room_select" id="" class="form-control select2" style="width: 100%;">
                            <option value="">Pilih Ruang</option>
                            @forelse ($room as $r)
                                <option value="{{ $r->id }}" {{ $picket->room_id == $r->id ? 'selected' : '' }}>
                                    {{ $r->room_name }}</option>
                            @empty
                                <option value=""></option>
                            @endforelse
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Waktu</label>
                        <input type="text" name="time" id="" class="form-control" placeholder="Jam"
                            value="{{ old('time') ?? $picket->time }}">
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
