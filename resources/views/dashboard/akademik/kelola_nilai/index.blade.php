@include('components.head_table')
@extends('template.template')
@section('content-header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Nilai Hafalan</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    {{ Breadcrumbs::render('nilaiHafalan') }}
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
                Filter
            </div>
            <div class="card-body">
                <form action="{{ route('nilai.filter') }}" method="GET">
                    @csrf
                    <div class="form-group">
                        <label for="">Program</label>
                        <select name="program" id="program" class="custom-select form-control">
                            <option value="">Pilih</option>
                            @foreach ($program as $c)
                                <option value="{{ $c->id }}">{{ $c->program_name }}</option>
                            @endforeach
                        </select>
                        <label for="">Kelas</label>
                        <select name="class" id="class" class="custom-select form-control">
                            <option value="">Pilih</option>
                            @foreach ($program as $c)
                                <option value="{{ $c->id }}">{{ $c->program_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Penilaian</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
@endsection
@extends('components.footer_table')
@push('new-script')
    <script>
        $(function() {
            // getAllCategory();


            function getAllCategory() {
                $('#program').change(function() {
                    var value = $(this).val();
                    $('#category').find('option').not(':first').remove();
                    $.ajax({
                        url: '{{ route('assessmentByProgram') }}',
                        type: 'GET',
                        dataType: 'json',
                        data: {
                            'category': value
                        },
                        success: function(response) {
                            if (response['data'] != null) {
                                len = response['data'].length;
                            }
                            if (len > 0) {
                                // Read data and create <option >
                                for (var i = 0; i < len; i++) {

                                    var id = response['data'][i].id;
                                    var name = response['data'][i].name;
                                    // variable option
                                    var option = "";
                                    option = "<option value='" + id + "'>" + name +
                                        "</option>";

                                    $("#category").append(option);
                                }
                            }
                        }
                    });
                });
            }
        });
    </script>
@endpush
