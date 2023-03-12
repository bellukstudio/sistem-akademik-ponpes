@include('components.head')
@extends('template.template')
@section('content-header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Tambah Data Pembayaran</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    {{ Breadcrumbs::render('pembayaran.create') }}
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
                Form Pembayaran
            </div>
            <div class="card-body">
                <form action="{{ route('pembayaran.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="">Cari Santri</label>
                        <input type="hidden" class="form-group" id="student_id" name="student_id" readonly>
                        <select class="form-control select2" style="width: 100%;" name="santriList" id="santriList">
                            <option value="">Pilih Nama</option>
                            @foreach ($student as $item)
                                <option value="{{ $item->id . ':' . $item->email }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Kategori Pembayaran</label>
                        <select class="form-control select2" style="width: 100%;" name="metode" id="metode">
                            <option value="">Pilih</option>
                            @foreach ($metode as $item)
                                <option value="{{ $item->id }}">
                                    {{ $item->payment_name }}( @currency($item->total) )
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Tanggal Pembayaran</label>
                        <input type="date" name="datePayment" id="" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="">Total Pembayaran</label>
                        <input type="number" name="total" id="" class="form-control">
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
                        <img src="https://via.placeholder.com/150x200" alt="" width="150" height="200"
                            id="photo" class="photo">
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
