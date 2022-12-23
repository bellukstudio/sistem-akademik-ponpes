@include('components.head')
@extends('template.template')
@section('content-header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Kelompok Kamar</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    {{ Breadcrumbs::render('kelompokKamar.edit', $data) }}
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
            <form action="{{ route('kelompokKamar.update', $data->id) }}" method="post">
                @csrf
                @method('put')
                <div class="card-body">
                    <div class="form-group">
                        <div class="form-group">
                            <label for="">Pilih Program</label>
                            <select class="form-control select2" style="width: 100%;" name="program_select"
                                id="program_select">
                                <option value="">Pilih Program</option>
                                @forelse ($program as $item)
                                    <option value="{{ $item->id }}"
                                        @if ($data->student != null) {{ $data->student->program_id == $item->id ? 'selected' : '' }}
                                        @else
                                        '' @endif>
                                        {{ $item->program_name ?? 'Error' }}</option>
                                @empty
                                    <option value=""></option>
                                @endforelse
                            </select>
                        </div>
                        <label for="">Pilih Santri</label>
                        <select name="student_select" id="student_select" class="form-control select2" style="width: 100%;">
                            <option value="">Pilih Santri</option>
                            <option value="{{ $data->student_id ?? '' }}" selected>{!! $data->student->name ?? '<span class="badge badge-danger">Error</span>' !!}</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Pilih Kamar</label>
                        <select name="room_select" id="" class="form-control select2" style="width: 100%;">
                            <option value="">Pilih Kamar</option>
                            @forelse ($room as $r)
                                <option value="{{ $r->id }}" {{ $data->room_id == $r->id ? 'selected' : '' }}>
                                    {{ $r->room_name }}</option>
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
            // dropdown on select program
            $('#program_select').change(function() {
                // get value dropdown
                var idProgram = $(this).val();
                // student dropdown
                $('#student_select').find('option').not(':first').remove();

                //url student by program
                var studentByProgramUrl = '{{ route('studentByProgramRoom', ':id') }}';
                studentByProgramUrl = studentByProgramUrl.replace(':id', idProgram);
                $.ajax({
                    url: studentByProgramUrl,
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        var len = 0;
                        console.log(response)
                        if (response['data'] != null) {
                            len = response['data'].length;
                        }
                        if (len > 0) {
                            // Read data and create <option >
                            for (var i = 0; i < len; i++) {

                                var id = response['data'][i].id;
                                var name = response['data'][i].name;

                                var option = "<option value='" + id + "'>" + name + "</option>";

                                $("#student_select").append(option);
                            }
                        }
                    }
                });
            });

            $('.select2').select2();
        });
    </script>
@endpush
