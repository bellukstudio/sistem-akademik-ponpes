@include('components.head')
@extends('template.template')
@section('content-header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Tambah Kota Baru</h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    {{ Breadcrumbs::render('kelolaKota.create') }}

                </ol>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>
@endsection
@section('content-section')
    <div class="container-fluid">
        {{-- alert --}}
        @include('components.alert')

        {{-- form search --}}
        <form class="form-inline" action="{{ route('kelolaKota.create') }}" method="GET">
            @csrf
            <div class="form-group mb-2">
                <input type="text" name="search" class="form-control ml-2" placeholder="Cari Provinsi"
                    value="{{ old('search') }}">
            </div>
            <button type="submit" class="btn btn-primary mb-2 ml-2"><i class="fa fa-search"></i> Cari</button>
        </form>

        {{-- form input city --}}
        <div class="card mt-2">
            <div class="card-header bg-blue">
                Tambah Data
            </div>
            <form action="{{ route('kelolaKota.store') }}" method="post">
                @csrf
                <div class="card-body">
                    <label for="">Asal Provinsi</label>
                    <input type="text" name="province_name" class="form-control" id="nama_provinsi" readonly
                        oninput="this.value = this.value.toUpperCase()">
                    <input type="hidden" name="province_id" class="form-control" id="id_provinsi" readonly>
                    <label for="">Nama Kota</label>
                    <input type="text" name="city_name" class="form-control"
                        oninput="this.value = this.value.toUpperCase()">
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">
                        <svg style="color: white" xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                            fill="currentColor" class="bi bi-send mr-2" viewBox="0 0 16 16">
                            <path
                                d="M15.854.146a.5.5 0 0 1 .11.54l-5.819 14.547a.75.75 0 0 1-1.329.124l-3.178-4.995L.643 7.184a.75.75 0 0 1 .124-1.33L15.314.037a.5.5 0 0 1 .54.11ZM6.636 10.07l2.761 4.338L14.13 2.576 6.636 10.07Zm6.787-8.201L1.591 6.602l4.339 2.76 7.494-7.493Z"
                                fill="white"></path>
                        </svg>
                        Simpan
                    </button>
                </div>
            </form>
        </div>

        {{-- table province --}}

        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Provinsi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($province as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $item->province_name }}</td>
                            <td>
                                <button class="btn btn-sm btn-outline-info btnPilih" data-id="{{ $item->id }}"
                                    data-name="{{ $item->province_name }}">Pilih</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2"></td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <nav aria-label="...">
                <ul class="pagination">
                    <li class="page-item {{ $province->currentPage() == 1 ? 'disabled' : '' }}">
                        <a class="page-link" href="{{ $province->previousPageUrl() }}" tabindex="-1">Previous</a>
                    </li>
                    @for ($i = 1; $i <= $province->lastPage(); $i++)
                        @if ($i == $province->currentPage())
                            <li class="page-item active">
                                <a class="page-link " href="#">{{ $i }}</a>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $province->url($i) }}">{{ $i }}</a>
                            </li>
                        @endif
                    @endfor

                    <li class="page-item">
                        <a class="page-link" href="{{ $province->nextPageUrl() }}">Next</a>
                    </li>
                </ul>
            </nav>
        </div>

    </div>
@endsection
@extends('components.footer')
@push('new-script')
    <script>
        $(function() {
            $(".btnPilih").each(function() {
                $(this).click(function() {
                    var id = $(this).data("id");
                    var name = $(this).data("name");
                    $('#nama_provinsi').val(name);
                    $('#id_provinsi').val(id);
                })
            });
        })
    </script>
@endpush
