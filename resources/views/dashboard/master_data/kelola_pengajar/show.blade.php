@include('components.head')
@extends('template.template')
@section('content-header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Data {{ $data->name }}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    {{ Breadcrumbs::render('kelolaPengajar.show', $data) }}
                </ol>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>
@endsection
@section('content-section')
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    @if (is_null($data->photo))
                        <img src="https://via.placeholder.com/150x200?text=Nothing" alt="" class="card-img-top">
                    @else
                        <img src="@gdrive($data->photo)" alt="" class="card-img-top">
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $data->name }}</h5>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-gradient-blue">
                        <h5 class="card-title">Biodata Pengajar</h5>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <th scope="row">Nomor ID</th>
                                    <td>{{ $data->noId }}</td>
                                </tr>

                                <tr>
                                    <th scope="row">Email</th>
                                    <td>{{ $data->email }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Jenis Kelamin</th>
                                    <td>{{ $data->gender }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Tanggal Lahir</th>
                                    <td>{{ $data->date_birth }}</td>
                                </tr>

                                <tr>
                                    <th scope="row">Nomor Telepon</th>
                                    <td>{{ $data->phone }}</td>
                                </tr>

                                <tr>
                                    <th scope="row">Alamat</th>
                                    <td>{{ $data->address }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Kota</th>
                                    <td>
                                        {!! $data->city->city_name ?? '<span class="badge badge-danger">Error</span>' !!}
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">Provinsi</th>
                                    <td>
                                        {!! $data->province->province_name ?? '<span class="badge badge-danger">Error</span>' !!}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@include('components.footer')
