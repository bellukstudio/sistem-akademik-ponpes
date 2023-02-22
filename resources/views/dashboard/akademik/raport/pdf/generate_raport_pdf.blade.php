<!DOCTYPE html>
<html>

<head>
    <title>Halaman Raport</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="style.css" />

    <style>
        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
            background-color: #f0f0f0;
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
            margin-top: 50px;
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

        tr:nth-child(even) {
            background-color: #f2f2f2;
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
    <main>
        <section class="student-data">
            <table>
                <tr>
                    <td>Nama Siswa</td>
                    <td>:</td>
                    <td>John Doe</td>
                </tr>
                <tr>
                    <td>Kelas</td>
                    <td>:</td>
                    <td>XII A</td>
                </tr>
                <tr>
                    <td>NIS</td>
                    <td>:</td>
                    <td>1234567890</td>
                </tr>
            </table>
        </section>
        <section class="raport-table">
            <table class="table-nilai" border="1">
                <thead>
                    <tr>
                        <th>Mata Pelajaran</th>
                        <th>Nilai UTS</th>
                        <th>Nilai UAS</th>
                        <th>Nilai Akhir</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td data-label="Mata Pelajaran">Matematika</td>
                        <td data-label="Nilai UTS">85</td>
                        <td data-label="Nilai UAS">90</td>
                        <td data-label="Nilai Akhir">85</td>
                    </tr>

                </tbody>
            </table>
        </section>
        <section class="signature">
            {{-- <div class="left-signature">
                <strong>Pengasuh Pesantren</strong>
                <div class="space-signature"></div>
                <p>Nama Kepala Sekolah</p>
            </div> --}}
            <div class="right-signature">
                <strong>Pengasuh Pesantren</strong>
                <div class="space-signature"></div>
                <p>KH YAHYA AL - MUTAMAKKIN</p>
            </div>
        </section>
    </main>
</body>

</html>
