<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.108.0">
    <title>SIPMM | Parent</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous">
    </script>
    <style>
        @media screen and (max-width: 600px) {

            table,
            thead,
            tbody,
            th,
            td,
            tr {
                display: block;
            }

            th {
                display: none;
            }

            tr {
                border-bottom: 2px solid #ddd;
            }

            td:before {
                content: attr(data-label);
                float: left;
                font-weight: bold;
            }
        }

        table {
            margin-top: 30px;
        }

        .table-nilai {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid black;
        }

        .table-nilai,
        th,
        td {
            border: 1px solid black;
            text-align: left;
            padding: 8px;
        }

        th {
            color: white;
            background-color: green;
        }

        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }

        .b-example-divider {
            height: 3rem;
            background-color: rgba(0, 0, 0, .1);
            border: solid rgba(0, 0, 0, .15);
            border-width: 1px 0;
            box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
        }

        .b-example-vr {
            flex-shrink: 0;
            width: 1.5rem;
            height: 100vh;
        }

        .bi {
            vertical-align: -.125em;
            fill: currentColor;
        }

        .nav-scroller {
            position: relative;
            z-index: 2;
            height: 2.75rem;
            overflow-y: hidden;
        }

        .nav-scroller .nav {
            display: flex;
            flex-wrap: nowrap;
            padding-bottom: 1rem;
            margin-top: -1px;
            overflow-x: auto;
            text-align: center;
            white-space: nowrap;
            -webkit-overflow-scrolling: touch;
        }

        .give-top {
            margin-top: 100px;
        }

        .give-bottom {
            margin-bottom: 100px;
        }
    </style>


    <!-- Custom styles for this template -->
    <link href="navbar-fixed.css" rel="stylesheet">
</head>
@php
    use App\Helpers\UtilHelper;
    
@endphp

<body>
    <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-success">
        <div class="container-fluid">

            <img src="{{ asset('template/img/logo.png') }}" alt=" Logo"
                class="brand-image img-circle elevation-3 d-inline-block align-text-top" height="40" width="40"
                style="opacity: 0.8" />
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse"
                aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <ul class="navbar-nav me-auto mb-2 mb-md-0">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="#">Beranda</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="container give-top give-bottom">
        <div class="bg-light p-5 rounded">
            <h3>Form Pencarian Santri</h3>
            @if ($errors->any())
                <div class="alert alert-warning alert-dismissible">
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    <p>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    </p>
                </div>
            @endif


            <form action="{{ route('filter-raport') }}" method="GET">
                @csrf
                <div class="form-group mt-2">
                    <label for="nomor_id">Nomor ID Santri:</label>
                    <input type="text" class="form-control" id="nomor_id" name="noId" placeholder="12345"
                        value="{{ old('noId') }}">
                </div>
                <div class="form-group mt-2">
                    <label for="tanggal_lahir">Tanggal Lahir Ibu/Ayah:</label>
                    <input type="text" class="form-control" id="tanggal_lahir" name="date_birth"
                        value="{{ old('date_birth') }}" placeholder="1999-05-01 (Tahun-Bulan-Tanggal)">
                </div>
                <div class="form-group mt-2">
                    <button type="submit" class="btn btn-primary">Cari Santri</button>
                </div>
            </form>
        </div>

        @if ($isShow == true)
            <div class="accordion mt-4" id="accordionRaport">
                @foreach ($period as $item)
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading{{ $item->code }}">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapse{{ $item->id }}" aria-expanded="false"
                                aria-controls="collapse{{ $item->id }}">
                                Tahun Ajar {{ $item->code }}
                            </button>
                        </h2>
                        <div id="collapse{{ $item->id }}" class="accordion-collapse collapse"
                            aria-labelledby="heading{{ $item->code }}" data-bs-parent="#accordionRaport">
                            <div class="accordion-body">
                                <table class="table-nilai">
                                    <thead>
                                        <tr>
                                            <th rowspan="2" style="text-align: center">No</th>
                                            <th rowspan="2" style="text-align: center">Nama</th>
                                            <th rowspan="2" style="text-align: center">Mata Pelajaran</th>
                                            <th colspan="{{ count($category) }}" style="text-align: center">Nilai</th>
                                            <th rowspan="2" style="text-align: center">Nilai Akhir</th>
                                        </tr>
                                        <tr>
                                            @foreach ($category as $subCategory)
                                                <th style="text-align: center">{{ $subCategory->name }}</th>
                                            @endforeach
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data->where('id_period', $item->id) as $index => $nilai)
                                            <tr>
                                                <td data-label="No">{{ $index + 1 }}</td>
                                                <td data-label="Nama">{{ $nilai->name ?? '-' }}</td>
                                                <td data-label="Mata Pelajaran">{{ $nilai->course_name }}</td>
                                                @foreach ($category as $subCategory)
                                                    <td data-label="{{ $subCategory->name }}"
                                                        style="text-align: center">
                                                        @if ($nilai->where('assessment_id', $subCategory->id)->where('course_id', $nilai->course_id)->first() != null)
                                                            @if (is_numeric(
                                                                    $nilai->where('assessment_id', $subCategory->id)->where('course_id', $nilai->course_id)->first()->score))
                                                                {{ $nilai->where('assessment_id', $subCategory->id)->where('course_id', $nilai->course_id)->first()->score }}
                                                            @else
                                                                {{ $nilai->where('assessment_id', $subCategory->id)->where('course_id', $nilai->course_id)->first()->score }}
                                                            @endif
                                                        @else
                                                            -
                                                        @endif

                                                    </td>
                                                @endforeach
                                                <td style="text-align: center">
                                                    @php
                                                        $totalWeightedScore = 0;
                                                    @endphp
                                                    @foreach ($category as $subCategory)
                                                        @if ($nilai->where('assessment_id', $subCategory->id)->where('course_id', $nilai->course_id)->first() != null)
                                                            @if (is_numeric(
                                                                    $nilai->where('assessment_id', $subCategory->id)->where('course_id', $nilai->course_id)->first()->score))
                                                                @php
                                                                    $total = $nilai
                                                                        ->where('assessment_id', $subCategory->id)
                                                                        ->where('course_id', $nilai->course_id)
                                                                        ->sum('score');
                                                                    $finalScore = $total * $subCategory->weight;
                                                                    $totalWeightedScore += $finalScore;
                                                                @endphp
                                                            @else
                                                                {{ $item->where('assessment_id', $subCategory->id)->where('course_id', $nilai->course_id)->first()->score }}
                                                            @endif
                                                        @else
                                                            -
                                                        @endif
                                                    @endforeach

                                                    @if ($nilai->where('assessment_id', $subCategory->id)->where('course_id', $nilai->course_id)->first() != null)
                                                        @if (is_numeric(
                                                                $nilai->where('assessment_id', $subCategory->id)->where('course_id', $nilai->course_id)->first()->score))
                                                            @php
                                                                $alphabetScore = UtilHelper::scoreRange(number_format($totalWeightedScore, 1));
                                                            @endphp
                                                            {{ number_format($totalWeightedScore, 1) }} |
                                                            {{ $alphabetScore }}
                                                        @endif
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </main>

</body>

</html>
