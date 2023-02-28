<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="Content-Type: application/pdf">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>LAPORAN PRESENSI-{{ $student->name }}-{{ $student->class_name }}-{{ $student->program_name }}</title>
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
@php
    use Carbon\Carbon;
    setlocale(LC_TIME, 'id_ID.utf8');
@endphp

<body>


    @foreach ($masterAttendance as $master)
        @foreach ($presence->where('presence_type', $master->id)->groupBy('presence_type') as $attendances)
            <header>
                <div class="logo">

                    <img src="https://pmm.or.id/media_library/images/4dd7de52391ccd8aedc21ec83f269842.png"
                        alt="" />
                </div>
                <div class="school-name">
                    <h4>PESANTREN MADINAH MUNAWWARAH</h4>
                    <h5>Jl Durian Raya No. 27B, Pedalangan, Banyumanik, Semarang</h5>
                    <h5>Telp. 0896-7554-4441</h5>
                </div>
            </header>
            <section class="student-data">
                <table>
                    <tr>
                        <td>No ID</td>
                        <td>:</td>
                        <td>{{ $student->noId }}</td>
                        <td></td>
                        <td></td>
                        <td>Keterangan</td>
                        <td>:</td>
                        <td>Laporan Presensi</td>
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
                                <th>No</th>
                                <th>Nama Absen</th>
                                <th>Kategori Absen</th>
                                <th>Nama Kategori</th>
                                <th>Waktu Absen</th>
                                <th>Status</th>
                                <th>Tanggal Absen</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($attendances as $index => $item)
                                <tr>
                                    <td data-label="No">{{ $index + 1 }}</td>
                                    <td data-label="Nama Absen">{{ $item->name_attendance ?? '-' }}</td>
                                    <td data-label="Kategori Absen"> Per - {{ $item->categories_attendance ?? '-' }}
                                    </td>
                                    <td data-label="Nama Kategori">{{ $item->name_category ?? '-' }}</td>
                                    <td data-label="Kategori Lainnya">{{ $item->other_category ?? '-' }}</td>
                                    <td data-label="Status">{{ $item->status ?? '-' }}</td>
                                    <td data-label="Tanggal Absen">
                                        @php
                                            $tanggal = Carbon::parse($item->date_presence);
                                            $tanggal_teks = $tanggal->isoFormat('dddd, D MMMM Y');
                                            
                                            echo $tanggal_teks;
                                        @endphp
                                    </td>
                                </tr>
                            @endforeach
                            <tr>
                                <td colspan="4" style="text-align: right;">Total Hadir</td>
                                <td colspan="3">{{ $attendances->where('status', 'Hadir')->count() }}</td>
                            </tr>
                            <tr>
                                <td colspan="4" style="text-align: right;">Total Alfa</td>
                                <td colspan="3">{{ $attendances->where('status', 'Alfa')->count() }}</td>

                            </tr>
                            <tr>
                                <td colspan="4" style="text-align: right;">Total Izin</td>
                                <td colspan="3">{{ $attendances->where('status', 'Izin')->count() }}</td>

                            </tr>
                            <tr>
                                <td colspan="4" style="text-align: right;">Total Sakit</td>
                                <td colspan="3">{{ $attendances->where('status', 'Sakit')->count() }}</td>


                            </tr>
                        </tbody>
                    </table>
                </section>
            </main>
        @endforeach
        <div class="page-break">
            {{-- <section class="signature">
                        <div class="left-signature">

                        </div>
                        <div class="right-signature">
                            <strong>Pengasuh Pesantren</strong>
                            <div class="space-signature"></div>
                            <p>KH YAHYA AL - MUTAMAKKIN</p>
                        </div>
                    </section> --}}
        </div>
    @endforeach

    <script>
        window.print();
    </script>



</body>

</html>
