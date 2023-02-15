@include('components.head_table')
@extends('template.template')
@section('content-header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Berita Acara</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    {{ Breadcrumbs::render('beritaAcara') }}
                </ol>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>
@endsection
@section('content-section')
    @php
        use Carbon\Carbon;
    @endphp
    @can('admin')
        <div class="container-fluid">
            @include('components.alert')

            <div class="card" style="overflow: auto;">

                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6 col-sm-12 mb-3">
                            <a href="{{ route('beritaAcara.create') }}" class="btn btn-primary btn-block">
                                <i class="fa fa-plus mr-2"></i>Buat Berita Acara / Pengumuman Baru
                            </a>
                        </div>
                        <div class="col-md-3 col-sm-12 mb-3">
                            <a href="{{ route('trashBeritaAcara') }}" class="btn btn-secondary btn-block">
                                <i class="fa fa-trash mr-2"></i>Trash Bin
                            </a>
                        </div>
                        <div class="col-md-3 col-sm-12">
                            <button class="btn btn-info btn-block" id="showTimeLine" data-toggle="0">
                                <i class="fa fa-broadcast-tower mr-2"></i>Tampilkan Timeline
                            </button>
                        </div>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    {{-- TIME LINE --}}
                    <!-- Timelime example  -->
                    <div class="timeLineShow">
                        <div class="row">
                            <div class="col-md-12">
                                <!-- The time line -->
                                <div class="timeline">
                                    @foreach ($timeLine as $key => $value)
                                        <div class="time-label">
                                            <span class="bg-cyan">{{ $key }}</span>
                                        </div>
                                        @foreach ($value as $news)
                                            <div>
                                                @if ($news->created_at >= Carbon::now()->subDays(1))
                                                    <i class="fas fa-broadcast-tower bg-blue"></i>
                                                    <div class="timeline-item bg-primary bg-opacity-20">
                                                        <span class="time text-white"><i class="fas fa-clock"></i>
                                                            {{ Carbon::parse($news->created_at)->format('H:i:s') }}</span>
                                                        <h3 class="timeline-header text-white">{{ $news->title }}</h3>
                                                        <div class="timeline-body">
                                                            {{ $news->description }}
                                                        </div>
                                                        <div class="timeline-footer">
                                                        </div>
                                                    </div>
                                                @else
                                                    <i class="fas fa-broadcast-tower bg-warning"></i>
                                                    <div class="timeline-item">
                                                        <span class="time"><i class="fas fa-clock"></i>
                                                            {{ Carbon::parse($news->created_at)->format('H:i:s') }}</span>
                                                        <h3 class="timeline-header">{{ $news->title }}</h3>
                                                        <div class="timeline-body">
                                                            {{ $news->description }}
                                                        </div>
                                                        <div class="timeline-footer">
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        @endforeach
                                    @endforeach
                                    <div>
                                        <i class="fas fa-clock bg-gray"></i>
                                    </div>
                                </div>
                            </div>
                            <!-- /.col -->
                        </div>
                    </div>
                    {{-- TABLE NEWS --}}
                    <div class="tableContent">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Judul</th>
                                    <th>Keterangan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($berita as $index => $item)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $item->title }}</td>
                                        <td>{!! $item->description !!}</td>
                                        <td>
                                            {{-- {Edit} --}}
                                            <a href="{{ route('beritaAcara.edit', $item->id) }}" class="btn btn-sm"><i
                                                    class="fa fa-edit"></i></a>
                                            {{-- {Hapus} --}}
                                            <button type="button" class="btn btn-sm" data-toggle="modal"
                                                data-target="#modal-default{{ $item->id }}">
                                                <i class="fa fa-trash"></i>
                                            </button>

                                        </td>
                                    </tr>

                                    {{-- Modal --}}
                                    <div class="modal fade" id="modal-default{{ $item->id }}">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Konfirmasi hapus data</h4>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="card">
                                                        <div class="card-header bg-danger">
                                                            <h6>{{ $item->judul }}</h6> <br>
                                                        </div>
                                                        <div class="card-body">
                                                            <p>{!! $item->keterangan !!}</p>

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer justify-content-between">
                                                    <button type="button" class="btn btn-default"
                                                        data-dismiss="modal">Close</button>
                                                    <form action="{{ route('beritaAcara.destroy', $item->id) }}"
                                                        method="post">
                                                        @csrf
                                                        @method('delete')
                                                        <button type="submit" class="btn btn-sm btn-danger"><i
                                                                class="fa fa-trash"></i>
                                                            Hapus</button>
                                                    </form>
                                                </div>
                                            </div>
                                            <!-- /.modal-content -->
                                        </div>
                                        <!-- /.modal-dialog -->
                                    </div>
                                @empty
                                    <tr>
                                        <td colspan="4" align="center"> Data Tidak Tersedia</td>
                                    </tr>
                                @endforelse
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>No</th>
                                    <th>Judul</th>
                                    <th>Keterangan</th>
                                    <th>Aksi</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
    @endcan
    @can('pengurus')
        <div class="container-fluid p-3">
            <!-- Timelime example  -->
            <div class="row">
                <div class="col-md-12">
                    <!-- The time line -->
                    <div class="timeline">
                        @foreach ($timeLine as $key => $value)
                            <div class="time-label">
                                <span class="bg-cyan">{{ $key }}</span>
                            </div>
                            @foreach ($value as $news)
                                <div>
                                    @if ($news->created_at >= Carbon::now()->subDays(1))
                                        <i class="fas fa-broadcast-tower bg-blue"></i>
                                        <div class="timeline-item bg-primary bg-opacity-20">
                                            <span class="time text-white"><i class="fas fa-clock"></i>
                                                {{ Carbon::parse($news->created_at)->format('H:i:s') }}</span>
                                            <h3 class="timeline-header text-white">{{ $news->title }}</h3>
                                            <div class="timeline-body">
                                                {{ $news->description }}
                                            </div>
                                            <div class="timeline-footer">
                                            </div>
                                        </div>
                                    @else
                                        <i class="fas fa-broadcast-tower bg-warning"></i>
                                        <div class="timeline-item">
                                            <span class="time"><i class="fas fa-clock"></i>
                                                {{ Carbon::parse($news->created_at)->format('H:i:s') }}</span>
                                            <h3 class="timeline-header">{{ $news->title }}</h3>
                                            <div class="timeline-body">
                                                {{ $news->description }}
                                            </div>
                                            <div class="timeline-footer">
                                            </div>
                                        </div>
                                    @endif

                                </div>
                            @endforeach
                        @endforeach
                        <div>
                            <i class="fas fa-clock bg-gray"></i>
                        </div>
                    </div>
                </div>
                <!-- /.col -->
            </div>
        </div>
    @endcan
    @can('pengajar')
        <div class="container-fluid p-3">
            <!-- Timelime example  -->
            <div class="row">
                <div class="col-md-12">
                    <!-- The time line -->
                    <div class="timeline">
                        @foreach ($timeLine as $key => $value)
                            <div class="time-label">
                                <span class="bg-cyan">{{ $key }}</span>
                            </div>
                            @foreach ($value as $news)
                                <div>
                                    @if ($news->created_at >= Carbon::now()->subDays(1))
                                        <i class="fas fa-broadcast-tower bg-blue"></i>
                                        <div class="timeline-item bg-primary bg-opacity-20">
                                            <span class="time text-white"><i class="fas fa-clock"></i>
                                                {{ Carbon::parse($news->created_at)->format('H:i:s') }}</span>
                                            <h3 class="timeline-header text-white">{{ $news->title }}</h3>
                                            <div class="timeline-body">
                                                {{ $news->description }}
                                            </div>
                                            <div class="timeline-footer">
                                            </div>
                                        </div>
                                    @else
                                        <i class="fas fa-broadcast-tower bg-warning"></i>
                                        <div class="timeline-item">
                                            <span class="time"><i class="fas fa-clock"></i>
                                                {{ Carbon::parse($news->created_at)->format('H:i:s') }}</span>
                                            <h3 class="timeline-header">{{ $news->title }}</h3>
                                            <div class="timeline-body">
                                                {{ $news->description }}
                                            </div>
                                            <div class="timeline-footer">
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        @endforeach
                        <div>
                            <i class="fas fa-clock bg-gray"></i>
                        </div>
                    </div>
                </div>
                <!-- /.col -->
            </div>
        </div>
    @endcan
@endsection
@extends('components.footer_table')
@push('new-script')
    @can('admin')
        <script>
            $(function() {
                var showText = 'Tampilkan Timeline';
                var hideText = 'Sembunyikan Timeline';

                $('.timeLineShow').addClass('d-none');
                $('#showTimeLine').click(function() {
                    var toggle = $(this).data('toggle');
                    if (toggle == 0) {
                        $(this).data('toggle', 1);
                        $('.tableContent').addClass('d-none');
                        $('.timeLineShow').removeClass('d-none');
                        $(this).html('<i class="fa fa-broadcast-tower mr-2"></i>' + hideText);
                    } else {
                        $(this).data('toggle', 0);
                        $(this).html('<i class="fa fa-broadcast-tower mr-2"></i>' + showText);

                        $('.tableContent').removeClass('d-none');
                        $('.timeLineShow').addClass('d-none');
                    }
                    // console.log(toggle);
                });
            });
        </script>
    @endcan
@endpush
