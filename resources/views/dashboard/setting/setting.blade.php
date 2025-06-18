@include('components.head')
@extends('template.template')
@section('content-header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Pengaturan</h1>
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
            @include('components.alert')

            <div class="card">
                <div class="card-header bg-gradient-lightblue">
                    <h3 class="card-title">Pengaturan Website</h3>
                </div>
                <form action="{{ route('settings.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="site_name">Nama Website</label>

                            <input type="text" name="site_name" id="site_name" class="form-control"
                                value="{{ old('site_name') ?? optional($settings)->site_name }}" placeholder="Nama Website">

                        </div>
                        <div class="form-group">
                            <label for="exampleInputFile">Logo</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="exampleInputFile" name="logo"
                                        value="{{ old('logo') }}">
                                    <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="pesantren_name">Nama Pesantren</label>
                            <input type="text" name="pesantren_name" id="pesantren_name" class="form-control"
                                value="{{ old('pesantren_name') ?? optional($settings)->pesantren_name }}"
                                placeholder="Nama Pesantren">
                        </div>
                        <div class="form-group">
                            <label for="pesantren_name">Alamat</label>
                            <textarea name="address" id="" cols="30" rows="10" class="form-control">{{ old('address') ?? optional($settings)->address }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="no_telp">Nomor Telepon</label>
                            <input type="text" name="no_telp" id="no_telp" class="form-control"
                                value="{{ old('no_telp') ?? optional($settings)->no_telp }}" placeholder="Nomor Telepon">
                        </div>

                    </div>

                    <div class="form-group">

                        <img src="https://drive.usercontent.google.com/download?id=1WGAsLMxQeM3sQRpvZ2X7Q8EHe3FEFPSj&export=view&authuser=0"
                            alt="" class="card-img-top">
                    </div>
                    <div class="card-footer">
                        <button class="btn btn-primary" type="submit">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
@extends('components.footer')
@push('new-script')
    <script src="{{ asset('template/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>

    <script>
        $(function() {
            bsCustomFileInput.init();
        });
    </script>
@endpush
