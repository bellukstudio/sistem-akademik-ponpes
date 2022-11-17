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
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-3">
                        <img src="{{ $data->photo != 'http://localhost:8000/storage/' ? $data->photo : 'https://via.placeholder.com/150x200?text=Nothing' }}"
                            alt="" width="150" height="200" id="photo" class="photo-show">
                    </div>
                    <div class="col-lg-6 mt-2">
                        <table width="100%">
                            <tr>
                                <td>
                                    <label for="">Nomor ID</label>

                                </td>
                                <td>
                                    <label for="" class="mr-2">:</label>
                                </td>
                                <td>
                                    <label style="font-weight: 100;">{{ $data->no_id }}</label>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="">Nama</label>

                                </td>
                                <td>
                                    <label for="" class="mr-2">:</label>
                                </td>
                                <td>
                                    <label style="font-weight: 100;">{{ $data->name }}</label>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="">Email</label>

                                </td>
                                <td>
                                    <label for="" class="mr-2">:</label>
                                </td>
                                <td>
                                    <label style="font-weight: 100;">{{ $data->email }}</label>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="">Jenis Kelamin</label>

                                </td>
                                <td>
                                    <label for="" class="mr-2">:</label>
                                </td>
                                <td>
                                    <label style="font-weight: 100;">{{ $data->gender }}</label>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="">Tanggal lahir</label>

                                </td>
                                <td>
                                    <label for="" class="mr-2">:</label>
                                </td>
                                <td>
                                    <label style="font-weight: 100;">{{ $data->date_birth }}</label>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="">Nomor Telepon</label>

                                </td>
                                <td>
                                    <label for="" class="mr-2">:</label>
                                </td>
                                <td>
                                    <label style="font-weight: 100;">{{ $data->no_tlp }}</label>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="">Alamat</label>

                                </td>
                                <td>
                                    <label for="" class="mr-2">:</label>
                                </td>
                                <td>
                                    <label style="font-weight: 100;">{{ $data->address }}</label>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="">Kota</label>

                                </td>
                                <td>
                                    <label for="" class="mr-2">:</label>
                                </td>
                                <td>
                                    <label style="font-weight: 100;">{{ $data->city->city_name }}</label>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="">Provinsi</label>

                                </td>
                                <td>
                                    <label for="" class="mr-2">:</label>
                                </td>
                                <td>
                                    <label style="font-weight: 100;">{{ $data->province->province_name }}</label>
                                </td>
                            </tr>
                        </table>

                    </div>

                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
@include('components.footer')
