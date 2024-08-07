@extends('dashboard', [
    'title' => 'Data Cuti',
    'pageTitle' => 'Data Cuti',
])
@section('content')
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
    @if ($message = Session::get('error'))
        <div class="alert alert-error">
            <p>{{ $message }}</p>
        </div>
    @endif
    <div class="d-flex justify-content-between mb-3">
        <div>
            <form action="{{ route('karyawan.cuti') }}" method="GET" class="d-flex">
                <input type="text" name="cari" class="form-control" placeholder="Cari Data" value="{{ request('cari') }}">
                <button type="submit" class="btn btn-md btn-primary ml-2">Search</button>
            </form>
        </div>
        <div>
            <a class="btn btn-md btn-primary" href="{{ route('karyawan.cuti.create') }}">Tambah Cuti</a>
            {{-- <a class="btn btn-md btn-success" href="{{ route('hrd.cuti.cetak') }}" target="_blank"><i
                    class="fa fa-print"></i> Cetak PDF</a> --}}
        </div>
    </div>
    <table class="table table-bordered table-responsive">
        <tr class="font-12">
            <th style="width: 150px">No Cuti</th>
            <th style="width: 150px">Npp</th>
            <th style="width: 150px">Jenis Cuti</th>
            <th style="width: 150px">Tanggal Pengajuan</th>
            <th style="width: 150px">Tanggal Awal</th>
            <th style="width: 150px">Tanggal Akhir</th>
            <th style="width: 150px">Durasi Cuti</th>
            <th style="width: 150px">Kuota Cuti</th>
            <th style="width: 150px">Keterangan</th>
            <th style="width: 150px">Bukti Cuti</th>
            <th style="width: 150px">Status Cuti</th>
            <th style="width: 150px">Keterangan Reject</th>
            <th style="width: 100px">Aksi</th>
        </tr>
        @foreach ($cuti as $data)
            <tr>
                <td style="width: 150px">{{ $data->no_cuti }}</td>
                <td style="width: 150px">{{ $data->npp }}</td>
                <td style="width: 150px">{{ $data->jenisCuti->nama_cuti ?? '' }}</td>
                <td style="width: 150px">{{ Date('d/m/Y', strtotime($data->tgl_pengajuan ?? '')) }}</td>
                <td style="width: 150px">{{ Date('d/m/Y', strtotime($data->tgl_awal ?? '')) }}</td>
                <td style="width: 150px">{{ Date('d/m/Y', strtotime($data->tgl_akhir ?? '')) }}</td>
                <td style="width: 150px">{{ $data->durasi ?? '' }}</td>
                <td style="width: 150px">{{ $data->kuota_cuti ?? '' }}</td>
                <td style="width: 150px">{{ $data->keterangan ?? '' }}</td>
                <td style="width: 150px">
                    @if ($data->bukti_cuti)
                        <a href="{{ asset('storage/' . $data->bukti_cuti) }}" data-lightbox="gallery" target="_blank">
                            <img src="{{ asset('storage/' . $data->bukti_cuti) }}"
                                style="max-width: 100px; max-height: 100px;" alt="Gambar Cuti">
                        </a>
                    @else
                        -
                    @endif
                </td>
                <td style="width: 150px">{{ $data->stt_cuti ?? '' }}</td>
                <td style="width: 150px">{{ $data->ket_reject ?? '' }}</td>
                <td>
                    <div class="btn-group" style="width:135px">
                        <form action="{{ route('karyawan.cuti.destroy', $data->no_cuti) }}" method="Post">
                            <a class="btn btn-primary" href="{{ route('karyawan.cuti.edit', $data->no_cuti) }}">Edit</a>
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </div>
                </td>
            </tr>
        @endforeach
    </table>
    <div class="row justify-content-center">
        <div class="col-md-12">
            {!! $cuti->links() !!}
        </div>
    </div>
@endsection
