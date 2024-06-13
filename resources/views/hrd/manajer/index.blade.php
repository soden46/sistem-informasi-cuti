@extends('dashboard', [
'title' => 'Data Manajer',
'pageTitle' => 'Data Manajer',
])
@section('content')
@if ($message = Session::get('success'))
<div class="alert alert-success">
    <p>{{ $message }}</p>
</div>
@endif
<div class="d-flex justify-content-between mb-3">
    <div>
        <form action="{{ route('hrd.manajer') }}" method="GET" class="d-flex">
            <input type="text" name="cari" class="form-control" placeholder="Cari Data" value="{{ request('cari') }}">
            <button type="submit" class="btn btn-md btn-primary ml-2">Search</button>
        </form>
    </div>
    <div>
        <a class="btn btn-md btn-primary" href="{{ route('hrd.manajer.create') }}">Tambah Manajer</a>
        <a class="btn btn-md btn-success" href="{{ route('hrd.manajer.cetak') }}" target="_blank"><i class="fa fa-print"></i> Cetak PDF</a>
    </div>
</div>
<table class="table table-bordered table-responsive">
    <tr class="font-12">
        <th style="width: 150px">NPP</th>
        <th style="width: 150px">Divisi</th>
        <th style="width: 150px">Nama Karyawan</th>
        <th style="width: 100px">Jenis Kelamin</th>
        <th style="width: 150px">Jabatan</th>
        <th style="width: 150px">Alamat</th>
        <th style="width: 150px">Hak Akses</th>
        <th style="width: 100px">Aktif</th>
        <th style="width: 150px">Telepon</th>
        <th style="width: 100px">Aksi</th>
    </tr>
    @foreach ($manajer as $data)
    <tr>
        <td style="width: 150px">{{ $data->npp ?? '' }}</td>
        <td style="width: 150px">{{ $data->divisi->nama_divisi ?? '' }}</td>
        <td style="width: 150px">{{ $data->nama_emp ?? '' }}</td>
        <td style="width: 100px">{{ $data->jk_emp ?? '' }}</td>
        <td style="width: 150px">{{ $data->jabatan ?? '' }}</td>
        <td style="width: 150px">{{ $data->alamat ?? '' }}</td>
        <td style="width: 150px">{{ $data->hak_akses ?? '' }}</td>
        <td style="width: 100px">{{ $data->active ?? '' }}</td>
        <td style="width: 150px">{{ $data->telp_emp ?? '' }}</td>
        <td>
            <div class="btn-group" style="width:135px">
                <form action="{{ route('hrd.karyawan.destroy', $data->npp) }}" method="Post">
                    <a class="btn btn-primary" href="{{ route('hrd.karyawan.edit', $data->npp) }}">Edit</a>
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </td>
    </tr>
    @endforeach
</table>
<div class="row text-center">
    {!! $manajer->links() !!}
</div>
@endsection