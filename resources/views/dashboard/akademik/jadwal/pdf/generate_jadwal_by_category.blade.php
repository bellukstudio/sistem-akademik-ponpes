<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Jadwal Pelajaran</title>
    <style>
        @page {
            margin-top: 50px;
        }

        table {
            border-spacing: 0;
            width: 100%;
            font-size: 11px;
            border: 1px solid #ddd;
        }

        th,
        td {
            text-align: center;
            padding: 8px;
        }

        th {
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
            <table border="1" page-break-inside: auto;>
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
                @forelse ($schedule as $item)
                    <tr>
                        <td rowspan="4">{{ $item->class_name }}</td>
                        <td bgcolor="yellow">Pagi</td>
                        <td>
                            @foreach ($sundayMorning->where('class_id', $item->class_id) as $data)
                                {{ $data->course->course_name ?? '-' }}
                            @endforeach
                        </td>
                        <td>
                            @foreach ($mondayMorning->where('class_id', $item->class_id) as $data)
                                {{ $data->course->course_name ?? '-' }}
                            @endforeach
                        </td>
                        <td>
                            @foreach ($tuesdayMorning->where('class_id', $item->class_id) as $data)
                                {{ $data->course->course_name ?? '-' }}
                            @endforeach
                        </td>
                        <td>
                            @foreach ($wednesdayMorning->where('class_id', $item->class_id) as $data)
                                {{ $data->course->course_name ?? '-' }}
                            @endforeach
                        </td>
                        <td>
                            @foreach ($thursdayMorning->where('class_id', $item->class_id) as $data)
                                {{ $data->course->course_name ?? '-' }}
                            @endforeach
                        </td>
                        <td>
                            @foreach ($fridayMorning->where('class_id', $item->class_id) as $data)
                                {{ $data->course->course_name ?? '-' }}
                            @endforeach
                        </td>
                        <td>
                            @foreach ($saturdayMorning->where('class_id', $item->class_id) as $data)
                                {{ $data->course->course_name ?? '-' }}
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <td bgcolor="yellow">Siang</td>
                        <td>
                            @foreach ($sundayAfternoon->where('class_id', $item->class_id) as $data)
                                {{ $data->course->course_name ?? '-' }}
                            @endforeach
                        </td>
                        <td>
                            @foreach ($mondayAfternoon->where('class_id', $item->class_id) as $data)
                                {{ $data->course->course_name ?? '-' }}
                            @endforeach
                        </td>
                        <td>
                            @foreach ($tuesdayAfternoon->where('class_id', $item->class_id) as $data)
                                {{ $data->course->course_name ?? '-' }}
                            @endforeach
                        </td>
                        <td>
                            @foreach ($wednesdayAfternoon->where('class_id', $item->class_id) as $data)
                                {{ $data->course->course_name ?? '-' }}
                            @endforeach
                        </td>
                        <td>
                            @foreach ($thursdayAfternoon->where('class_id', $item->class_id) as $data)
                                {{ $data->course->course_name ?? '-' }}
                            @endforeach
                        </td>
                        <td>
                            @foreach ($fridayAfternoon->where('class_id', $item->class_id) as $data)
                                {{ $data->course->course_name ?? '-' }}
                            @endforeach
                        </td>
                        <td>
                            @foreach ($saturdayAfternoon->where('class_id', $item->class_id) as $data)
                                {{ $data->course->course_name ?? '-' }}
                            @endforeach
                        </td>

                    </tr>
                    <tr>
                        <td bgcolor="yellow">Sore</td>
                        <td>
                            @foreach ($sundayEvening->where('class_id', $item->class_id) as $data)
                                {{ $data->course->course_name ?? '-' }}
                            @endforeach
                        </td>
                        <td>
                            @foreach ($mondayEvening->where('class_id', $item->class_id) as $data)
                                {{ $data->course->course_name ?? '-' }}
                            @endforeach
                        </td>
                        <td>
                            @foreach ($tuesdayEvening->where('class_id', $item->class_id) as $data)
                                {{ $data->course->course_name ?? '-' }}
                            @endforeach
                        </td>
                        <td>
                            @foreach ($wednesdayEvening->where('class_id', $item->class_id) as $data)
                                {{ $data->course->course_name ?? '-' }}
                            @endforeach
                        </td>
                        <td>
                            @foreach ($thursdayEvening->where('class_id', $item->class_id) as $data)
                                {{ $data->course->course_name ?? '-' }}
                            @endforeach
                        </td>
                        <td>
                            @foreach ($fridayEvening->where('class_id', $item->class_id) as $data)
                                {{ $data->course->course_name ?? '-' }}
                            @endforeach
                        </td>
                        <td>
                            @foreach ($saturdayEvening->where('class_id', $item->class_id) as $data)
                                {{ $data->course->course_name ?? '-' }}
                            @endforeach
                        </td>

                    </tr>
                    <tr>
                        <td bgcolor="yellow">Malam</td>
                        <td>
                            @foreach ($sundayNight->where('class_id', $item->class_id) as $data)
                                {{ $data->course->course_name ?? '-' }}
                            @endforeach
                        </td>
                        <td>
                            @foreach ($mondayNight->where('class_id', $item->class_id) as $data)
                                {{ $data->course->course_name ?? '-' }}
                            @endforeach
                        </td>
                        <td>
                            @foreach ($tuesdayNight->where('class_id', $item->class_id) as $data)
                                {{ $data->course->course_name ?? '-' }}
                            @endforeach
                        </td>
                        <td>
                            @foreach ($wednesdayNight->where('class_id', $item->class_id) as $data)
                                {{ $data->course->course_name ?? '-' }}
                            @endforeach
                        </td>
                        <td>
                            @foreach ($thursdayNight->where('class_id', $item->class_id) as $data)
                                {{ $data->course->course_name ?? '-' }}
                            @endforeach
                        </td>
                        <td>
                            @foreach ($fridayNight->where('class_id', $item->class_id) as $data)
                                {{ $data->course->course_name ?? '-' }}
                            @endforeach
                        </td>
                        <td>
                            @foreach ($saturdayNight->where('class_id', $item->class_id) as $data)
                                {{ $data->course->course_name ?? '-' }}
                            @endforeach
                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="9">Tidak ada data</td>
                    </tr>
                @endforelse



            </table>
        @else
            <table border="1">
                <tr>
                    <th rowspan="2">No</th>
                    <th rowspan="2">Nama Pengajar</th>
                    <th rowspan="2">Mata Pelajaran</th>
                    <th rowspan="2">Kelas</th>
                    <th colspan="2">Jadwal</th>
                </tr>
                <tr>
                    <th>Hari</th>
                    <th>Waktu</th>
                </tr>
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
            </table>
        @endif
    </div>
</body>

</html>
