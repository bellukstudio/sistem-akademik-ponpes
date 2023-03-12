@include('components.head')
@extends('template.template')
@section('content-header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Edit Data Pembayaran</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    {{ Breadcrumbs::render('pembayaran.edit', $data->id) }}
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
                Form Pembayaran
            </div>
            <div class="card-body">
                <form action="{{ route('updateUserPayment', $data->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <div class="form-group">
                        <label for="">Cari Santri</label>
                        <input type="hidden" class="form-group" id="student_id" name="student_id"
                            value="{{ $data->id_student }}" readonly>
                        <select class="form-control select2" style="width: 100%;" name="santriList" id="santriList">
                            <option value="">Pilih Nama</option>
                            @foreach ($student as $item)
                                <option value="{{ $item->id . ':' . $item->email }}"
                                    {{ $data->id_user === $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Kategori Pembayaran</label>
                        <select class="form-control select2" style="width: 100%;" name="metode" id="metode">
                            <option value="">Pilih</option>
                            @foreach ($metode as $item)
                                <option value="{{ $item->id }}" {{ $data->id_payment === $item->id ? 'selected' : '' }}>
                                    {{ $item->payment_name }}( @currency($item->total) )
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Tanggal Pembayaran</label>
                        <input type="date" name="datePayment" id="" class="form-control"
                            value="{{ $data->date_payment }}">
                    </div>
                    <div class="form-group">
                        <label for="">Total Pembayaran</label>
                        <input type="number" name="total" id="" class="form-control"
                            value="{{ $data->total }}">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputFile">Bukti Pembayaran</label>
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="exampleInputFile" name="photo"
                                    value="{{ old('photo') }}" onchange="readURL(this);">
                                <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                            </div>
                        </div>
                        <h6 class="mt-5">Preview</h6>
                        @if ($data->photo === env('STORAGE_URL'))
                            <img src="https://via.placeholder.com/150x200" alt="" width="150" height="200"
                                id="photo" class="photo">
                        @else
                            <img src="{{ $data->photo }}" alt="" id="photo" class="photo" width="150"
                                height="200">
                        @endif

                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-warning">Update</button>
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
            $('#santriList').change(function() {
                var value = $(this).val();
                let splitData = value.split(':');
                let email = splitData[1];
                var url = '{{ route('getStudentByEmail') }}';
                $.ajax({
                    url: url,
                    type: 'GET',
                    data: {
                        'email': email
                    },
                    datatype: 'json',
                    success: function(response) {
                        console.log(response['data']);
                        var id = response['data'].id;
                        $('#student_id').val(id);
                    }
                });
            });
            $('.select2').select2();

        })
    </script>
@endpush
