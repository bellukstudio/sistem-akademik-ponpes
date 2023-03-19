@include('components.head')
@extends('template.template')
@section('content-header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Buat Berita Acara</h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    {{ Breadcrumbs::render('beritaAcara.edit', $berita) }}

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
            <div class="card-header bg-yellow">
                Edit Data
            </div>
            <div class="card-body">
                <form action="{{ route('kelolaBeritaAcara.update', $berita->id) }}" method="post">
                    @csrf
                    @method('put')
                    <label for="">Judul Berita Acara / Pengumuman</label>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Perubahan Jadwal pengajian"
                            value="{{ old('judul') ?? $berita->title }}" name="judul">
                    </div>
                    <label for="">Keterangan</label>
                    <div class="card card-outline card-info">
                        <div class="card-body">
                            <textarea name="keterangan" cols="20" rows="15" class="form-control">
                                {{ old('keterangan') ?? $berita->description }}</textarea>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-warning">
                        <svg style="color: white" xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                            fill="currentColor" class="bi bi-send mr-2" viewBox="0 0 16 16">
                            <path
                                d="M15.854.146a.5.5 0 0 1 .11.54l-5.819 14.547a.75.75 0 0 1-1.329.124l-3.178-4.995L.643 7.184a.75.75 0 0 1 .124-1.33L15.314.037a.5.5 0 0 1 .54.11ZM6.636 10.07l2.761 4.338L14.13 2.576 6.636 10.07Zm6.787-8.201L1.591 6.602l4.339 2.76 7.494-7.493Z"
                                fill="white"></path>
                        </svg> Update</button>
                </form>
            </div>
        </div>
    </div>
@endsection
@extends('components.footer')
@push('new-script')
    <script>
        $(function() {
            // Summernote
            $("#summernote").summernote();
        });
    </script>
@endpush
