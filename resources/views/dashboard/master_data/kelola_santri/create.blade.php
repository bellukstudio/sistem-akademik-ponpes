@include('components.head')
@extends('template.template')
@section('content-header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Tambah Data</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    {{ Breadcrumbs::render('kelolaSantri.create') }}
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
                Tambah Data Santri
            </div>
            <form action="{{ route('kelolaSantri.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    {{-- form --}}
                    <div class="form-group">
                        <label for="id_number">Nomor Induk</label>
                        <input type="number" name="id_number" id="id_number" class="form-control"
                            value="{{ old('id_number') }}" placeholder="Nomor Identitas">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}"
                            placeholder="Alamat Email">
                    </div>
                    <div class="form-group">
                        <label for="fullName">Nama Lengkap</label>
                        <input type="text" name="fullName" id="fullName" class="form-control" autocomplete="off"
                            value="{{ old('fullName') }}" placeholder="Nama Lengkap">
                    </div>
                    <div class="form-group">
                        <label for="dateBirth">Tanggal Lahir</label>
                        <input type="date" name="dateBirth" id="dateBirth" class="form-control" autocomplete="off"
                            value="{{ old('dateBirth') }}" placeholder="Tanggal Lahir">
                    </div>
                    <div class="form-group">
                        <label for="gender">Jenis Kelamin</label>
                        <select class="custom-select form-control-border" id="exampleSelectBorder" name="gender">
                            <option value="">Pilih Jenis Kelamin</option>
                            <option value="Laki-Laki">Laki-Laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="province">Program</label>
                        <select class="form-control select2" style="width: 100%;" name="program" id="program">
                            <option value="">Pilih Program</option>

                            @forelse ($program as $item)
                                <option value="{{ $item->id }}">
                                    {{ $item->program_name }}
                                </option>
                            @empty
                                <option value=""></option>
                            @endforelse
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="province">Tahun Akademik</label>
                        <select class="form-control select2" style="width: 100%;" name="period" id="period">
                            <option value="">Pilih tahun Akademik</option>

                            @forelse ($periode as $item)
                                <option value="{{ $item->id }}">
                                    {{ $item->code }}
                                </option>
                            @empty
                                <option value=""></option>
                            @endforelse
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="phone_number">Nomor Telepon <code>*Optional</code></label>
                        <input type="tel" name="phone_number" id="phone_number" class="form-control"
                            value="{{ old('phone_number') }}" placeholder="Nomor Telepon">
                    </div>
                    <div class="form-group">
                        <label for="studen_parent">Nama Orang Tua</label>
                        <input type="text" name="student_parent" id="studen_parent" class="form-control"
                            autocomplete="off" value="{{ old('student_parent') }}" placeholder="Nama Orang Tua">
                    </div>
                    <div class="form-group">
                        <label for="province">Provinsi</label>
                        <select class="form-control select2" style="width: 100%;" name="province" id="province">
                            <option value="">Pilih Provinsi</option>

                            @forelse ($province as $item)
                                <option value="{{ $item->id }}">
                                    {{ $item->province_name }}
                                </option>
                            @empty
                                <option value=""></option>
                            @endforelse
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="city">Kota</label>
                        <select class="form-control select2" style="width: 100%;" name="city" id="city">
                            <option value="">Pilih Kota</option>

                        </select>
                    </div>
                    <div class="form-group">
                        <label for="address">Alamat</label>
                        <textarea name="address" id="" cols="30" rows="10" class="form-control" placeholder="Alamat">{{ old('address') }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputFile">Foto <code>*optional</code></label>
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="exampleInputFile" name="photo"
                                    value="{{ old('photo') }}" onchange="readURL(this);">
                                <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                            </div>
                        </div>
                        <h6 class="mt-5">Preview</h6>
                        <img src="https://via.placeholder.com/150x200" alt="" width="150" height="200"
                            id="photo" class="photo">
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary" id="testing">Save</button>
                </div>
            </form>
        </div>
    </div>
@endsection
@extends('components.footer')
@push('new-script')
    <!-- Select2 -->
    <script src="{{ asset('template/plugins/select2/js/select2.full.min.js') }}"></script>
    <!-- bs-custom-file-input -->
    <script src="{{ asset('template/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#photo').attr('src', e.target.result);
                    $('#photo').attr('class', 'photo');
                };

                reader.readAsDataURL(input.files[0]);
            }
        }
        $(function() {
            //find city by id province
            $('#province').change(function() {
                var idProvince = $(this).val();

                // Empty the dropdown
                $('#city').find('option').not(':first').remove();
                var url = '{{ route('getCityByProvinceId', ':id') }}';
                url = url.replace(':id', idProvince);
                $.ajax({
                    url: url,
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        var len = 0;
                        if (response['data'] != null) {
                            len = response['data'].length;
                        }
                        if (len > 0) {
                            // Read data and create <option >
                            for (var i = 0; i < len; i++) {

                                var id = response['data'][i].id;
                                var name = response['data'][i].city_name;

                                var option = "<option value='" + id + "'>" + name + "</option>";

                                $("#city").append(option);
                            }
                        }
                    }
                });
            });

            $('.select2').select2();
            bsCustomFileInput.init();
        });
    </script>
@endpush
