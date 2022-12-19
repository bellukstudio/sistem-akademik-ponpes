@include('components.head')
@extends('template.template')
@section('content-header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Kelompok Kelas</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    {{ Breadcrumbs::render('kelompokKelas.edit', $data) }}
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
            <div class="card-header bg-gradient-yellow">
                Edit Data
            </div>
            <form action="{{ route('kelompokKelas.update', $data->id) }}" method="post">
                @csrf
                @method('put')
                <div class="card-body">
                    <div class="form-group">
                        <label for="">Pilih Santri</label>
                        <select name="student_select" id="" class="form-control select2" style="width: 100%;">
                            <option value="">Pilih Santri</option>
                            @forelse ($student as $s)
                                <option value="{{ $s->id }}" {{ $data->student_id == $s->id ? 'selected' : '' }}>
                                    {{ $s->name }}</option>
                            @empty
                                <option value=""></option>
                            @endforelse
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Pilih Kelas</label>
                        <select name="class_select" id="" class="form-control select2" style="width: 100%;">
                            <option value="">Pilih Kelas</option>
                            @forelse ($class as $r)
                                <option value="{{ $r->id }}" {{ $data->class_id == $r->id ? 'selected' : '' }}>
                                    {{ $r->class_name }}</option>
                            @empty
                                <option value=""></option>
                            @endforelse
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
