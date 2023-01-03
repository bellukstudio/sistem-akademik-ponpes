<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Jadwal Pelajaran</title>
    <style>
        table {
            border-spacing: 0;
            width: 100%;
            border: 1px solid #ddd;
        }

        th,
        td {
            text-align: left;
            padding: 8px;
        }

        tr:nth-child(1) {
            background-color: #c9c9c9;
        }
    </style>
</head>

<body>
    <center>
        <h2>JADWAL
            @if ($category === 'mapel')
                MATA PELAJARAN {{ $course }}
            @endif
            @if ($category === 'waktu')
                WAKTU {{ $time }}
            @endif
            @if ($category === 'kelas')
                KELAS {{ $class }}
            @endif
            @if ($category === 'hari')
                HARI {{ $day }}
            @endif
            @if ($category === 'program')
                {{ $courseCategory }} PROGRAM {{ $program }}
            @endif
        </h2>
    </center>
    <div style="overflow-x:auto;">
        @if ($category === 'program')
            <table border="1">
                <tr>
                    <th>Kelas</th>
                    <th>Waktu</th>
                    <th>Ahad</th>
                    <th>Senin</th>
                    <th>Selasa</th>
                    <th>Rabu</th>
                    <th>Kamis</th>
                    <th>Jumat</th>
                    <th>Sabtu</th>
                </tr>
                @foreach ($class as $index => $data)
                    <tr>
                        <th rowspan="4">{{ $data->class_name }}</th>
                        <th>-</th>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                    </tr>
                @endforeach
            </table>
        @else
            <table border="1">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Pengajar</th>
                        <th>Mata Pelajaran</th>
                        <th>Kelas</th>
                        <th>Hari</th>
                        <th>Waktu</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($schedule as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $item->teacher_name }}</td>
                            <td>{{ $item->course_name }}</td>
                            <td>{{ $item->class_name }}</td>
                            <td>{{ $item->day }}</td>
                            <td>{{ $item->times }}</td>
                        </tr>

                    @empty
                        <tr>
                            <td colspan="6" align="center"> Data Tidak Tersedia</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        @endif
    </div>
</body>

</html>
