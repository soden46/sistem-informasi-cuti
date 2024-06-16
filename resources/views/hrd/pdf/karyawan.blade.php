<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Data Karayawan</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css"
        integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <style>
        body {
            font-size: 12px;
            font-family: Verdana, Tahoma, "DejaVu Sans", sans-serif;
        }

        .td,
        .th,
        thead {
            border: 1px solid black;
            text-align: center
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .text-success {
            color: green
        }

        .text-danger {
            color: red
        }

        .fw-bold {
            font-weight: bold
        }

        .tandatangan {
            text-align: center;
            margin-left: 400px;
        }

        .tandatangan p {
            margin: 0; /* Menghapus margin bawaan dari elemen <p> */
        }

        #foto {
            width: 100%;
            height: 100mm;
            text-align: center;
        }

        #foto img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }

        .header h1 {
            font-size: 18px;
            font-family: sans-serif;
            position: relative;
            margin: 0;
            padding: 0;
            top: 1px;
        }

        .header p {
            font-size: 13px;
            font-family: sans-serif;
            position: relative;
            margin: 0;
            padding: 0;
            top: 1px;
        }
    </style>
</head>

<body>
    <div class="card">
        <div class="card-body">
            <div class="justify-center align-content-center" >
                <img class="justify-center" src="{{ public_path('assets/img/logo.png') }}" alt="Logo" width="100%" height="150px"/>
            </div>
            <div class="divider py-1 bg-dark mb-3 mt-2"></div>
            <h1 class="text-center">Laporan Data Karyawan</h1>
            <table class="table table-bordered">
                <tr class="font-12">
                    <th style="width:  50px">Npp</th>
                    <th style="width:  45px">Nama Divisi</th>
                    <th style="width:  50px">Nama Karyawan</th>
                    <th style="width: 80px">Jenis Kelamin</th>
                    <th style="width: 80px">Jabatan</th>
                    <th style="width: 80px">Alamat</th>
                    <th style="width: 70px">Jumlah Cuti</th>
                    <th style="width: 100px">Nomor Telepon</th>
                </tr>
                @foreach ($karyawan as $data)
                    <tr class="font-12">
                        <td style="width:  50px">{{ $data->npp }}</td>
                        <td style="width:  45px">{{ $data->divisi->nama_divisi ?? 'Data Divisi Tidak Ditemukan' }}</td>
                        <td style="width:  50px">{{ $data->nama_emp }}</td>
                        <td style="width: 80px">{{ $data->jk_emp ?? '' }}</td>
                        <td style="width: 80px">{{ $data->jabatan ?? '' }}</td>
                        <td style="width: 80px">{{ $data->alamat ?? '' }}</td>
                        <td style="width: 70px">{{ $data->jml_cuti ?? '' }}</td>
                        <td style="width: 100px">{{ $data->telp_emp ?? '' }}</td>
                    </tr>
                @endforeach
            </table>
            <div class="tandatangan">

                <p style="padding-bottom:100px">
                    Jakarta, ......................... {{ date('d F Y') }}</br>
                    PT Gastro Gizi Sarana</p>


                <p class="fw-bold" style="text-decoration: underline;">Yulia DMS</p>
                <p style="margin-top: 0;">HR & GA Manager</p>
            </div>
        </div>
    </div>
</body>

</html>
