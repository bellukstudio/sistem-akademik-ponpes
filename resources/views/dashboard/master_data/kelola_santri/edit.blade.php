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
                    {{ Breadcrumbs::render('kelolaSantri.edit', $santri) }}
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
                Edit Data Santri
            </div>
            <form action="{{ route('kelolaSantri.update', $santri->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('put')
                <div class="card-body">
                    {{-- form --}}
                    <div class="form-group">
                        <label for="id_number">Nomor Induk</label>
                        <input type="number" name="id_number" id="id_number" class="form-control"
                            value="{{ old('id_number') ?? $santri->noId }}" placeholder="Nomor Identitas">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" class="form-control"
                            value="{{ old('email') ?? $santri->email }}" placeholder="Alamat Email">
                    </div>
                    <div class="form-group">
                        <label for="fullName">Nama Lengkap</label>
                        <input type="text" name="fullName" id="fullName" class="form-control" autocomplete="off"
                            value="{{ old('fullName') ?? $santri->name }}" placeholder="Nama Lengkap">
                    </div>
                    <div class="form-group">
                        <label for="dateBirth">Tanggal Lahir</label>
                        <input type="date" name="dateBirth" id="dateBirth" class="form-control" autocomplete="off"
                            value="{{ old('dateBirth') ?? $santri->date_birth }}" placeholder="Tanggal Lahir">
                    </div>
                    <div class="form-group">
                        <label for="gender">Jenis Kelamin</label>
                        <select class="custom-select form-control-border" id="exampleSelectBorder" name="gender">
                            @if ($santri->gender == 'Laki-Laki')
                                <option value="Laki-Laki" selected>Laki-Laki</option>
                                <option value="Perempuan">Perempuan</option>
                            @else
                                <option value="Perempuan" selected>Perempuan</option>
                                <option value="Laki-Laki">Laki-Laki</option>
                            @endif
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="province">Program</label>
                        <select class="form-control select2" style="width: 100%;" name="program" id="program">
                            <option value="">Pilih Program</option>

                            @forelse ($program as $item)
                                <option value="{{ $item->id }}"
                                    {{ $santri->program_id == $item->id ? 'selected' : '' }}>
                                    {{ $item->program_name }}
                                </option>
                            @empty
                                <option value=""></option>
                            @endforelse
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="entry_year">Tahun Masuk</label>
                        <input type="text" name="entry_year" id="" class="form-control"
                            value="{{ old('entry_year') ?? $santri->entry_year }}" placeholder="2019 / 2019/2020">
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="phone_number">Nomor Telepon <code>*Optional</code></label>
                            <input type="tel" name="phone" id="phone" class="form-control"
                                value="{{ old('phone') ?? $santri->phone }}" placeholder="Nomor Telepon">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="phone_number">Nomor Telepon Orang Tua <code>*Optional</code></label>
                            <input type="tel" name="parent_phone" id="parent_phone" class="form-control"
                                value="{{ old('parent_phone') ?? $santri->parent_phone }}" placeholder="Nomor Telepon">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="student_parent">Nama Ayah</label>
                            <input type="text" name="father_name" id="father_name" class="form-control"
                                autocomplete="off" value="{{ old('father_name') ?? $santri->father_name }}"
                                placeholder="Nama Ayah">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="student_parent">Nama Ibu</label>
                            <input type="text" name="mother_name" id="mother_name" class="form-control"
                                autocomplete="off" value="{{ old('mother_name') ?? $santri->mother_name }}"
                                placeholder="Nama Ibu">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="date_birth_father">Tanggal Lahir Ayah</label>
                            <input type="date" name="date_birth_father" id="date_birth_father" class="form-control"
                                autocomplete="off" value="{{ old('date_birth_father') ?? $santri->date_birth_father }}"
                                placeholder="Tanggal Lahir">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="date_birth_mother">Tanggal Lahir Ibu</label>
                            <input type="date" name="date_birth_mother" id="date_birth_mother" class="form-control"
                                autocomplete="off" value="{{ old('date_birth_mother') ?? $santri->date_birth_mother }}"
                                placeholder="Tanggal Lahir">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="province">Provinsi</label>
                        <select class="form-control select2" style="width: 100%;" name="province" id="province">
                            <option value="">Pilih Provinsi</option>

                            @forelse ($province as $item)
                                <option value="{{ $item->id }}"
                                    {{ $santri->province_id == $item->id ? 'selected' : '' }}>
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
                        <textarea name="address" id="" cols="30" rows="10" class="form-control" placeholder="Alamat">{{ old('address') ?? $santri->address }}</textarea>
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
                        @if (is_null($santri->photo))
                            <img src='https://via.placeholder.com/150x200' alt="" width="150" height="200"
                                id="photo" class="photo">
                        @else
                            <img src="@gdrive($santri->photo)" alt="" id="photo" class="photo">
                        @endif
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-warning" id="testing">Update</button>
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
            let cityId = '{{ $santri->city_id }}';
            let provinceId = '{{ $santri->province_id }}';
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
                        console.log(response);
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
