<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="Content-Type: application/pdf">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>LAPORAN PENILAIAN AKHIR-{{ $student->name }}-{{ $student->class_name }}-{{ $student->program_name }}
    </title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <style>
        header {
            top: 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
            /* background-color: #f0f0f0; */
            width: 100%;
        }

        .title {
            text-align: center;
            font-weight: bold;
        }

        .logo img {
            height: 100px;
        }

        .school-name {
            font-size: 15px;
        }

        .student-data {
            margin-top: 20px;
        }

        .raport-table {
            margin-top: 20px;
        }

        .signature {
            margin-top: 100px;
            display: flex;
            justify-content: space-between;
        }

        .left-signature,
        .right-signature {
            width: 25%;
            text-align: center;
        }

        .space-signature {
            height: 70px;
        }

        table {
            margin-top: 30px;
        }

        .table-nilai {
            width: 100%;
            border-collapse: collapse;
        }

        .table-nilai,
        th,
        td {
            text-align: left;
            padding: 8px;
        }

        th {
            color: white;
            background-color: green;
        }

        /* tr:nth-child(even) {
            background-color: #f2f2f2;
        } */
        @media print {
            th {
                background-color: green !important;
            }
        }

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

        .page-break {
            page-break-after: always;
        }
    </style>
</head>


<body>
    <header>
        <div class="logo">

            <img src="https://pmm.or.id/media_library/images/4dd7de52391ccd8aedc21ec83f269842.png" alt="" />
        </div>
        <div class="school-name">
            <h4>PESANTREN MADINAH MUNAWWARAH</h4>
            <h5>Jl Durian Raya No. 27B, Pedalangan, Banyumanik, Semarang</h5>
            <h5>Telp. 0896-7554-4441</h5>
        </div>
    </header>
    <div class="title">
        <h2>KARTU HASIL BELAJAR</h2>
    </div>
    <section class="student-data">
        <table>
            <tr>
                <td>No ID</td>
                <td>:</td>
                <td>{{ $student->noId }}</td>
            </tr>
            <tr>
                <td>Nama Santri</td>
                <td>:</td>
                <td>{{ $student->name }}</td>
            </tr>
            <tr>
                <td>Kelas</td>
                <td>:</td>
                <td>{{ $student->class_name }}</td>
            </tr>
            <tr>
                <td>Program</td>
                <td>:</td>
                <td>{{ $student->program_name }}</td>
            </tr>
            <tr>
                <td>Tahun Ajaran</td>
                <td>:</td>
                <td>{{ $period->code }} - {{ $period->information }}</td>
            </tr>
        </table>
    </section>

    <main>
        <section class="raport-table">
            <table class="table-nilai" border="1">
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
                    @php
                        use App\Helpers\UtilHelper;
                        
                    @endphp
                    @foreach ($score as $index => $item)
                        <tr>
                            <td data-label="No">{{ $index + 1 }}</td>
                            <td data-label="Nama">{{ $item->name ?? '-' }}</td>
                            <td data-label="Mata Pelajaran">{{ $item->course_name }}</td>
                            @foreach ($category as $subCategory)
                                <td data-label="{{ $subCategory->name }}" style="text-align: center">
                                    @if ($item->where('assessment_id', $subCategory->id)->where('course_id', $item->course_id)->first() != null)
                                        @if (is_numeric(
                                                $item->where('assessment_id', $subCategory->id)->where('course_id', $item->course_id)->first()->score))
                                            {{ $item->where('assessment_id', $subCategory->id)->where('course_id', $item->course_id)->first()->score }}
                                        @else
                                            {{ $item->where('assessment_id', $subCategory->id)->where('course_id', $item->course_id)->first()->score }}
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
                                    @if ($item->where('assessment_id', $subCategory->id)->where('course_id', $item->course_id)->first() != null)
                                        @if (is_numeric(
                                                $item->where('assessment_id', $subCategory->id)->where('course_id', $item->course_id)->first()->score))
                                            @php
                                                $total = $item
                                                    ->where('assessment_id', $subCategory->id)
                                                    ->where('course_id', $item->course_id)
                                                    ->sum('score');
                                                $finalScore = $total * $subCategory->weight;
                                                $totalWeightedScore += $finalScore;
                                            @endphp
                                        @else
                                            {{ $item->where('assessment_id', $subCategory->id)->where('course_id', $item->course_id)->first()->score }}
                                        @endif
                                    @else
                                        -
                                    @endif
                                @endforeach

                                @if ($item->where('assessment_id', $subCategory->id)->where('course_id', $item->course_id)->first() != null)
                                    @if (is_numeric(
                                            $item->where('assessment_id', $subCategory->id)->where('course_id', $item->course_id)->first()->score))
                                        @php
                                            $alphabetScore = UtilHelper::scoreRange(number_format($totalWeightedScore, 1));
                                        @endphp
                                        {{ number_format($totalWeightedScore, 1) }} | {{ $alphabetScore }}
                                    @endif
                                @endif



                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </section>

    </main>
    <div class="page-break">

    </div>
    <script>
        window.print();
    </script>



</body>

</html>
