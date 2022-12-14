@include('components.head')
{{--  --}}
@extends('template.template')
@section('content-section')
    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ $dataUser }}</h3>

                            <p>User</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person"></i>
                        </div>
                        <a href="{{ route('kelolaUser.index') }}" class="small-box-footer">More info <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ $dataSantri }}</h3>

                            <p>Santri</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-ios-people"></i>
                        </div>
                        <a href="{{ route('kelolaSantri.index') }}" class="small-box-footer">More info <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{ $dataPengurus }}</h3>

                            <p>Pengurus</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-ios-person"></i>
                        </div>
                        <a href="{{ route('kelolaPengurus.index') }}" class="small-box-footer">More info <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>{{ $dataPengajar }}</h3>

                            <p>Pengajar</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person-stalker"></i>
                        </div>
                        <a href="{{ route('kelolaPengajar.index') }}" class="small-box-footer">More info <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
            </div>
            <div class="row">
                <div class="col-md-6">
                    <!-- Perizinan LIST -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Perizinan Terbaru</h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body p-0">
                            <ul class="products-list product-list-in-card pl-2 pr-2">
                                <li class="item">
                                    <div class="product-img">
                                        <img src="dist/img/default-150x150.png" alt="Product Image" class="img-size-50" />
                                    </div>
                                    <div class="product-info">
                                        <a href="javascript:void(0)" class="product-title">Samsung TV
                                            <span class="badge badge-warning float-right">$1800</span></a>
                                        <span class="product-description">
                                            Samsung 32" 1080p 60Hz LED Smart HDTV.
                                        </span>
                                    </div>
                                </li>
                                <!-- /.item -->
                                <li class="item">
                                    <div class="product-img">
                                        <img src="dist/img/default-150x150.png" alt="Product Image" class="img-size-50" />
                                    </div>
                                    <div class="product-info">
                                        <a href="javascript:void(0)" class="product-title">Bicycle
                                            <span class="badge badge-info float-right">$700</span></a>
                                        <span class="product-description">
                                            26" Mongoose Dolomite Men's 7-speed, Navy Blue.
                                        </span>
                                    </div>
                                </li>
                                <!-- /.item -->
                                <li class="item">
                                    <div class="product-img">
                                        <img src="dist/img/default-150x150.png" alt="Product Image" class="img-size-50" />
                                    </div>
                                    <div class="product-info">
                                        <a href="javascript:void(0)" class="product-title">
                                            Xbox One
                                            <span class="badge badge-danger float-right">
                                                $350
                                            </span>
                                        </a>
                                        <span class="product-description">
                                            Xbox One Console Bundle with Halo Master Chief
                                            Collection.
                                        </span>
                                    </div>
                                </li>
                                <!-- /.item -->
                                <li class="item">
                                    <div class="product-img">
                                        <img src="dist/img/default-150x150.png" alt="Product Image" class="img-size-50" />
                                    </div>
                                    <div class="product-info">
                                        <a href="javascript:void(0)" class="product-title">PlayStation 4
                                            <span class="badge badge-success float-right">$399</span></a>
                                        <span class="product-description">
                                            PlayStation 4 500GB Console (PS4)
                                        </span>
                                    </div>
                                </li>
                                <li class="item">
                                    <div class="product-img">
                                        <img src="dist/img/default-150x150.png" alt="Product Image" class="img-size-50" />
                                    </div>
                                    <div class="product-info">
                                        <a href="javascript:void(0)" class="product-title">PlayStation 4
                                            <span class="badge badge-success float-right">$399</span></a>
                                        <span class="product-description">
                                            PlayStation 4 500GB Console (PS4)
                                        </span>
                                    </div>
                                </li>
                                <!-- /.item -->
                            </ul>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer text-center">
                            <a href="javascript:void(0)" class="uppercase">Lihat Semua</a>
                        </div>
                        <!-- /.card-footer -->
                    </div>
                </div>
                <div class="col-md-6">
                    <!-- Berita Acara LIST -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Berita Acara Terbaru</h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body p-0">
                            <ul class="products-list product-list-in-card pl-2 pr-2">
                                @forelse ($beritaAcara as $index => $item)
                                    <li class="item">
                                        <div class="product-img">
                                            <h4 class="badge badge-success">{{ $index + 1 }}</h4>
                                        </div>
                                        <div class="product-info">
                                            <a href="javascript:void(0)" class="product-title">{{ $item->title }}
                                                @if ($index == 0)
                                                    <span class="badge badge-primary float-right">new</span>
                                                @else
                                                    <span class="badge badge-warning float-right">latest</span>
                                                @endif
                                            </a>
                                            <span class="product-description">
                                                {!! $item->description !!}
                                            </span>
                                        </div>
                                    </li>
                                @empty
                                    <li class="item">
                                        <div class="product-img">
                                            <h4>-</h4>
                                        </div>
                                        <div class="product-info">
                                            <span class="badge badge-danger float-right">empty</span></a>
                                            <p class="text-center">Tidak Ada Berita Acara</p>
                                        </div>
                                    </li>
                                @endforelse
                                <!-- /.item -->
                            </ul>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer text-center">
                            <a href="{{ route('beritaAcara.index') }}" class="uppercase">Lihat Semua</a>
                        </div>
                        <!-- /.card-footer -->
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8">
                    <!-- TABLE: AKTIVITAS USER -->
                    <div class="card">
                        <div class="card-header border-transparent">
                            <h3 class="card-title">Aktivitas User</h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table m-0">
                                    <thead>
                                        <tr>
                                            <th>Order ID</th>
                                            <th>Item</th>
                                            <th>Status</th>
                                            <th>Popularity</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <a href="pages/examples/invoice.html">OR9842</a>
                                            </td>
                                            <td>Call of Duty IV</td>
                                            <td>
                                                <span class="badge badge-success">Shipped</span>
                                            </td>
                                            <td>
                                                <div class="sparkbar" data-color="#00a65a" data-height="20">
                                                    90,80,90,-70,61,-83,63
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <a href="pages/examples/invoice.html">OR1848</a>
                                            </td>
                                            <td>Samsung Smart TV</td>
                                            <td>
                                                <span class="badge badge-warning">Pending</span>
                                            </td>
                                            <td>
                                                <div class="sparkbar" data-color="#f39c12" data-height="20">
                                                    90,80,-90,70,61,-83,68
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <a href="pages/examples/invoice.html">OR7429</a>
                                            </td>
                                            <td>iPhone 6 Plus</td>
                                            <td>
                                                <span class="badge badge-danger">Delivered</span>
                                            </td>
                                            <td>
                                                <div class="sparkbar" data-color="#f56954" data-height="20">
                                                    90,-80,90,70,-61,83,63
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <a href="pages/examples/invoice.html">OR7429</a>
                                            </td>
                                            <td>Samsung Smart TV</td>
                                            <td>
                                                <span class="badge badge-info">Processing</span>
                                            </td>
                                            <td>
                                                <div class="sparkbar" data-color="#00c0ef" data-height="20">
                                                    90,80,-90,70,-61,83,63
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <a href="pages/examples/invoice.html">OR1848</a>
                                            </td>
                                            <td>Samsung Smart TV</td>
                                            <td>
                                                <span class="badge badge-warning">Pending</span>
                                            </td>
                                            <td>
                                                <div class="sparkbar" data-color="#f39c12" data-height="20">
                                                    90,80,-90,70,61,-83,68
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <a href="pages/examples/invoice.html">OR7429</a>
                                            </td>
                                            <td>iPhone 6 Plus</td>
                                            <td>
                                                <span class="badge badge-danger">Delivered</span>
                                            </td>
                                            <td>
                                                <div class="sparkbar" data-color="#f56954" data-height="20">
                                                    90,-80,90,70,-61,83,63
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <a href="pages/examples/invoice.html">OR9842</a>
                                            </td>
                                            <td>Call of Duty IV</td>
                                            <td>
                                                <span class="badge badge-success">Shipped</span>
                                            </td>
                                            <td>
                                                <div class="sparkbar" data-color="#00a65a" data-height="20">
                                                    90,80,90,-70,61,-83,63
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer clearfix">
                            <a href="javascript:void(0)" class="btn btn-sm btn-info float-left">Place New
                                Order</a>
                            <a href="javascript:void(0)" class="btn btn-sm btn-secondary float-right">View All
                                Orders</a>
                        </div>
                        <!-- /.card-footer -->
                    </div>
                </div>
            </div>
            <!-- /.row (main row) -->
        </div>
        <!-- /.container-fluid -->
    </section>
@endsection

@include('components.footer')
