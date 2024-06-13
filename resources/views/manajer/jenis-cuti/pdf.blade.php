<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
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

        #foto {
            float: left;
            width: 120px;
            height: 150px;
            background: transparent;
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
            <div class="header">
                <img src="{{ public_path('storage/asset/sleman.png') }}" id="foto" alt="Logo" height="75px" />
                <h1 class="text-center">PT</h1>
                <p class="text-center">Jalan </p>
                <p class="text-center">Telepon (0274) 797496</p>
                <p class="text-center">Laman: https://ambarketawang.sidesimanis.slemankab.go.id</p>
            </div>
            <div class="divider py-1 bg-dark mb-3 mt-2"></div>

            <table class="table table-bordered">
                <tr class="font-12">
                    <th style="width: 150px">Id Jenis Cuti</th>
                    <th style="width: 150px">Nama Cuti</th>
                    <th style="width: 150px">Lama Cuti</th>
                </tr>
                @foreach ($cuti as $data)
                    <tr class="font-12">
                        <td style="width: 150px">{{ $data->id_jenis_cuti }}</td>
                        <td style="width: 150px">{{ $data->nama_cuti ?? '' }}</td>
                        <td style="width: 150px">{{ $data->lama_cuti ?? '' }}</td>
                    </tr>
                @endforeach
            </table>
            <div class="tandatangan">

                <p style="padding-bottom:100px">
                    Kota, ......................... {{ date('Y') }}</br>
                    HRD PT</p>


                <p>Sumaryanto</p>
            </div>
        </div>
    </div>
</body>

</html>
