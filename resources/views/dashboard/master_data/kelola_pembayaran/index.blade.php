@include('components.head_table')
@extends('template.template')
@section('content-header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Data Pembayaran</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    {{ Breadcrumbs::render('kelolaPembayaran') }}
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
        <div class="card" style="overflow: auto;">
            <div class="card-header">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-AddData">
                    <i class="fa fa-plus mr-2"></i> Tambah Data Baru
                </button>
                <a href="{{ route('trashPayment') }}" class="btn btn-secondary">
                    <i class="fa fa-trash mr-2"></i>Trash
                    Bin</a>

                {{-- Modal new data --}}
                <div class="modal fade" id="modal-AddData">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Tambah Data Baru</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="{{ route('kelolaPembayaran.store') }}" method="post">
                                @csrf
                                <div class="modal-body">
                                    <label for="">Nama Pembayaran</label>
                                    <input type="text" name="payment_name" id="" class="form-control"
                                        value="{{ old('payment_name') }}" placeholder="Nama Pembayaran"
                                        oninput="this.value = this.value.toUpperCase()">
                                    <br>
                                    <label for="">Tranfer Via</label>
                                    <select name="method_name" id="" class="custom-select form-control-border">
                                        <option value="">Pilih</option>
                                        <option value="DOMPET DIGITAL">Dompet Digital</option>
                                        <option value="TRANSFER BANK">Transfer Bank</option>
                                    </select>
                                    <br><br>
                                    <label for="">Nama Media Pembayaran</label>
                                    <input type="text" name="media_payment" id="" class="form-control"
                                        value="{{ old('media_payment') }}"
                                        placeholder="Media Pembayaran : BCA / A.N (Jhon Doe)"
                                        oninput="this.value = this.value.toUpperCase()">
                                    <br>
                                    <label for="">Total</label>
                                    <input type="number" name="total_payment" id="" class="form-control"
                                        value="{{ old('total_payment') }}" placeholder="Total Pembayaran">
                                    <br>
                                    <label for="">Nomor Pembayaran</label>
                                    <input type="number" name="payment_number" id="" class="form-control"
                                        value="{{ old('payment_number') }}" placeholder="Nomor Pembayaran">
                                </div>
                                <div class="modal-footer justify-content-between">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-sm btn-primary">
                                        <svg style="color: white" xmlns="http://www.w3.org/2000/svg" width="16"
                                            height="16" fill="currentColor" class="bi bi-send mr-2" viewBox="0 0 16 16">
                                            <path
                                                d="M15.854.146a.5.5 0 0 1 .11.54l-5.819 14.547a.75.75 0 0 1-1.329
                                                .124l-3.178-4.995L.643 7.184a.75.75 0 0 1
                                                 .124-1.33L15.314.037a.5.5 0 0 1 .54.11ZM6.636 10.07l2.761
                                                 4.338L14.13 2.576 6.636 10.07Zm6.787-8.201L1.591
                                                 6.602l4.339 2.76 7.494-7.493Z"
                                                fill="white"></path>
                                        </svg>
                                        Save</button>
                                </div>
                            </form>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Pembayaran</th>
                            <th>Metode Pembayaran</th>
                            <th>Media Pembayaran</th>
                            <th>Total</th>
                            <th>Nomor Pembayaran</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pembayaran as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $item->payment_name }}</td>
                                <td>{{ $item->method }}</td>
                                <td>{{ $item->media_payment }}</td>
                                <td>@currency($item->total)</td>
                                <td>{{ $item->payment_number }}</td>
                                <td>
                                    {{-- {Edit} --}}
                                    <button type="button" class="btn btn-sm" data-toggle="modal"
                                        data-target="#modal-Edit{{ $item->id }}">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                    {{-- {Hapus} --}}
                                    <button type="button" class="btn btn-sm" data-toggle="modal"
                                        data-target="#modal-Delete{{ $item->id }}">
                                        <i class="fa fa-trash"></i>
                                    </button>

                                </td>
                            </tr>

                            {{-- Modal Delete --}}
                            <div class="modal fade" id="modal-Delete{{ $item->id }}">
                                <div class="modal-dialog modal-dialog-centered">
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
                                                    <h4>{{ $item->payment_name }}</h4> <br>
                                                    <p>Yakin ingin menghapus data tersebut? </p>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="modal-footer justify-content-between">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">
                                                Close</button>
                                            <form action="{{ route('kelolaPembayaran.destroy', $item->id) }}"
                                                method="post">
                                                @csrf
                                                @method('delete')
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    <i class="fa fa-trash mr-2"></i>
                                                    Hapus</button>
                                            </form>
                                        </div>
                                    </div>
                                    <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                            </div>

                            {{-- Modal update data --}}
                            <div class="modal fade" id="modal-Edit{{ $item->id }}">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Edit Data</h4>
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form action="{{ route('kelolaPembayaran.update', $item->id) }}" method="post">
                                            @csrf
                                            @method('put')
                                            <div class="modal-body">
                                                <label for="">Nama Pembayaran</label>
                                                <input type="text" name="payment_name" id=""
                                                    class="form-control"
                                                    value="{{ old('payment_name') ?? $item->payment_name }}"
                                                    placeholder="Nama Pembayaran"
                                                    oninput="this.value = this.value.toUpperCase()">
                                                <br>
                                                <label for="">Tranfer Via</label>
                                                <select name="method_name" id=""
                                                    class="custom-select form-control-border">
                                                    <option value="">Pilih</option>
                                                    <option value="DOMPET DIGITAL"
                                                        {{ $item->method === 'DOMPET DIGITAL' ? 'selected' : '' }}>Dompet
                                                        Digital</option>
                                                    <option value="TRANSFER BANK"
                                                        {{ $item->method === 'TRANSFER BANK' ? 'selected' : '' }}>Transfer
                                                        Bank</option>
                                                </select>
                                                <br>
                                                <label for="">Nama Media Pembayaran</label>
                                                <input type="text" name="media_payment" id=""
                                                    class="form-control"
                                                    value="{{ old('media_payment') ?? $item->media_payment }}"
                                                    placeholder="Media Pembayaran BCA / A.N (Jhon Doe)"
                                                    oninput="this.value = this.value.toUpperCase()">
                                                <br>
                                                <label for="">Total</label>
                                                <input type="number" name="total_payment" id=""
                                                    class="form-control"
                                                    value="{{ old('total_payment') ?? $item->total }}"
                                                    placeholder="Total Pembayaran">
                                                <label for="">Nomor Pembayaran</label>
                                                <input type="number" name="payment_number" id=""
                                                    class="form-control"
                                                    value="{{ old('payment_number') ?? $item->payment_number }}"
                                                    placeholder="Nomor Pembayaran">

                                            </div>
                                            <div class="modal-footer justify-content-between">
                                                <button type="button" class="btn btn-default"
                                                    data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-sm btn-warning">
                                                    <svg style="color: white" xmlns="http://www.w3.org/2000/svg"
                                                        width="16" height="16" fill="currentColor"
                                                        class="bi bi-send mr-2" viewBox="0 0 16 16">
                                                        <path
                                                            d="M15.854.146a.5.5 0 0 1 .11.54l-5.819 14.547a.75.75 0 0 1-1.329
                                                .124l-3.178-4.995L.643 7.184a.75.75 0 0 1
                                                 .124-1.33L15.314.037a.5.5 0 0 1 .54.11ZM6.636 10.07l2.761
                                                 4.338L14.13 2.576 6.636 10.07Zm6.787-8.201L1.591
                                                 6.602l4.339 2.76 7.494-7.493Z"
                                                            fill="white"></path>
                                                    </svg>
                                                    Update</button>
                                            </div>
                                        </form>
                                    </div>
                                    <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                            </div>
                        @empty
                            <tr>
                                <td colspan="7" align="center"> Data Tidak Tersedia</td>
                            </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>No</th>
                            <th>Nama Pembayaran</th>
                            <th>Metode Pembayaran</th>
                            <th>Media Pembayaran</th>
                            <th>Total</th>
                            <th>Nomor Pembayaran</th>
                            <th>Aksi</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <!-- /.card-body -->
        </div>

    </div>
@endsection
@include('components.footer_table')
