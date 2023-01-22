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
        <h2>JADWAL PIKET PER-
            @if ($category === 'class')
                KELAS
            @endif
            @if ($category === 'room')
                RUANG
            @endif
        </h2>
    </center>
    <div style="overflow-x:auto;">
        <table border="1">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Kategori</th>
                    <th>Lokasi</th>
                    <th>Waktu</th>
                </tr>
            </thead>
            @forelse ($schedule as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{!! $item->student_name ?? '<span class="badge badge-danger">Error</span>' !!}</td>
                    <td>{!! $item->category_name ?? '<span class="badge badge-danger">Error</span>' !!}</td>
                    <td>{!! $item->room ?? '<span class="badge badge-danger">Error</span>' !!}</td>
                    <td>{{ $item->time }}</td>

                </tr>

            @empty
                <tr>
                    <td colspan="5" align="center"> Data Tidak Tersedia</td>
                </tr>
            @endforelse
        </table>
    </div>
</body>

</html>
