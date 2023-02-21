@include('components.head')
@extends('template.template')
@section('content-header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Berita Acara</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    {{-- {{ Breadcrumbs::render('beritaAcara.show', $timeLine->announcement) }} --}}
                </ol>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>
@endsection
@php
    use Carbon\Carbon;
@endphp
@section('content-section')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h3>Time Line Interaksi User ( {{ $readNews }} )</h3>
            </div>
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
                                                <div class="timeline-item">
                                                    <span class="time text-white"><i class="fas fa-clock"></i>
                                                        {{ Carbon::parse($news->created_at)->format('H:i:s') }}</span>
                                                    <h3 class="timeline-header text-white bg-primary bg-opacity-20">
                                                        {{ $news->user->name }}</h3>
                                                    <div class="timeline-body">
                                                        {{ $news->announcement->title }}
                                                    </div>
                                                    <div class="timeline-footer">
                                                    </div>
                                                </div>
                                            @else
                                                <i class="fas fa-broadcast-tower bg-warning"></i>
                                                <div class="timeline-item">
                                                    <span class="time"><i class="fas fa-clock"></i>
                                                        {{ Carbon::parse($news->created_at)->format('H:i:s') }}</span>
                                                    <h3 class="timeline-header">
                                                        {{ $news->user->name }}</h3>
                                                    <div class="timeline-body">
                                                        {{ $news->announcement->title }}
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
            </div>
        </div>
    </div>
@endsection
@include('components.footer')
