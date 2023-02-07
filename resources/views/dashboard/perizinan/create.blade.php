@include('components.head')
@extends('template.template')
@section('content-header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Buat Perizinan Baru </h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    {{ Breadcrumbs::render('perizinan.create') }}
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
                Form Perizinan Baru
            </div>
            <div class="card-body">
                <form action="{{ route('perizinan.store') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="">Cari Santri</label>
                        <select class="form-control select2" style="width: 100%;" name="student" id="student">
                            <option value="">Pilih Nama</option>
                            @foreach ($student as $data)
                                <option value="{{ $data->id }}">{{ $data->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Tanggal Izin</label>
                        <input type="date" name="datePermit" id="" class="form-control"
                            value="{{ old('datePermit') }}">
                    </div>
                    <div class="form-group">
                        <label for="">Judul Izin</label>
                        <input type="text" name="titlePermit" id="" class="form-control"
                            value="{{ old('titlePermit') }}">
                    </div>
                    <div class="form-group">
                        <label for="">Keterangan</label>
                        <textarea name="desc" id="" cols="30" rows="10" class="form-control">{{ old('desc') }}</textarea>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@extends('components.footer')
@push('new-script')
    <script src="{{ asset('template/plugins/select2/js/select2.full.min.js') }}"></script>

    <script>
        $(function() {
            $('.select2').select2();
        })
    </script>
@endpush
