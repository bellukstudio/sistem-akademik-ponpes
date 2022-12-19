@include('components.head')
@extends('template.template')
@section('content-header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Edit Data</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    {{ Breadcrumbs::render('kelolaPengajar.edit', $pengajar) }}
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
                Edit Data Pengajar
            </div>
            <form action="{{ route('kelolaPengajar.update', $pengajar->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('put')
                <div class="card-body">
                    {{-- form --}}
                    <div class="form-group">
                        <label for="id_number">Nomor Induk</label>
                        <input type="number" name="id_number" id="id_number" class="form-control"
                            value="{{ old('id_number') ?? $pengajar->noId }}">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" class="form-control"
                            value="{{ old('email') ?? $pengajar->email }}">
                    </div>
                    <div class="form-group">
                        <label for="fullName">Nama Lengkap</label>
                        <input type="text" name="fullName" id="fullName" class="form-control" autocomplete="off"
                            value="{{ old('fullName') ?? $pengajar->name }}">
                    </div>
                    <div class="form-group">
                        <label for="dateBirth">Tanggal Lahir</label>
                        <input type="date" name="dateBirth" id="dateBirth" class="form-control" autocomplete="off"
                            value="{{ old('dateBirth') ?? $pengajar->date_birth }}">
                    </div>
                    <div class="form-group">
                        <label for="gender">Jenis Kelamin</label>
                        <select class="custom-select form-control-border" id="exampleSelectBorder" name="gender">
                            <option value="">Pilih Jenis Kelamin</option>
                            @if ($pengajar->gender == 'Laki-Laki')
                                <option value="Laki-Laki" selected>Laki-Laki</option>
                                <option value="Perempuan">Perempuan</option>
                            @else
                                <option value="Perempuan" selected>Perempuan</option>
                                <option value="Laki-Laki">Laki-Laki</option>
                            @endif
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="phone_number">Nomor Telepon <code>*Optional</code></label>
                        <input type="number" name="phone_number" id="phone_number" class="form-control"
                            value="{{ old('phone_number') ?? $pengajar->no_tlp }}">
                    </div>
                    <div class="form-group">
                        <label for="province">Provinsi</label>
                        <select class="form-control select2" style="width: 100%;" name="province" id="province">
                            <option value="">Pilih Provinsi</option>

                            @forelse ($province as $item)
                                <option value="{{ $item->id }}"
                                    {{ $pengajar->province_id == $item->id ? 'selected' : '' }}>
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
                        <textarea name="address" id="" cols="30" rows="10" class="form-control">{{ old('address') ?? $pengajar->address }}</textarea>
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
                        <img src="{{ $pengajar->photo != 'http://localhost:8000/storage/' ? $pengajar->photo : 'https://via.placeholder.com/150x200' }}"
                            alt="" width="150" height="200" id="photo" class="photo">
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-warning" id="testing"> <svg style="color: white"
                            xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-send mr-2" viewBox="0 0 16 16">
                            <path
                                d="M15.854.146a.5.5 0 0 1 .11.54l-5.819 14.547a.75.75 0 0 1-1.329
                                                .124l-3.178-4.995L.643 7.184a.75.75 0 0 1
                                                 .124-1.33L15.314.037a.5.5 0 0 1 .54.11ZM6.636 10.07l2.761
                                                 4.338L14.13 2.576 6.636 10.07Zm6.787-8.201L1.591
                                                 6.602l4.339 2.76 7.494-7.493Z"
                                fill="white"></path>
                        </svg>Update</button>
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
            let cityId = '{{ $pengajar->city_id }}';
            let provinceId = '{{ $pengajar->province_id }}';
            var url = '{{ route('getCityByProvinceId', ':id') }}';
            url = url.replace(':id', provinceId);
            // request find city by province when create page
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
                            var option = '';
                            if (cityId == id) {
                                option = "<option value='" + id + "' selected>" + name +
                                    "</option>";
                            } else {
                                option = "<option value='" + id + "'>" + name +
                                    "</option>";
                            }

                            $("#city").append(option);
                        }
                    }
                }
            });
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
                                var option = '';
                                if (cityId == id) {
                                    option = "<option value='" + id + "' selected>" + name +
                                        "</option>";
                                } else {
                                    option = "<option value='" + id + "'>" + name +
                                        "</option>";
                                }

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
