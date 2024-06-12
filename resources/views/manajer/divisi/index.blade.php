@extends('dashboard',[
'title' => 'Data Divisi',
'pageTitle' => 'Data Divisi'
])
@section('content')

@if ($message = Session::get('success'))
<div class="alert alert-success">
    <p>{{ $message }}</p>
</div>
@endif
<div class="d-flex justify-content-between mb-3">
    <div>
        <form action="{{ route('manajer.divisi') }}" method="GET" class="d-flex">
            <input type="text" name="cari" class="form-control" placeholder="Cari Data" value="{{ request('cari') }}">
            <button type="submit" class="btn btn-md btn-primary ml-2">Search</button>
        </form>
    </div>
    <div>
        <!-- <a class="btn btn-md btn-primary" href="{{ route('hrd.divisi.create') }}">Tambah Divisi</a> -->
        <a class="btn btn-md btn-success" href="{{ route('manajer.divisi.cetak') }}" target="_blank"><i class="fa fa-print"></i> Cetak PDF</a>
    </div>
</div>
<table class="table table-bordered">
    <tr class="font-12">
        <th style="width: 150px">Id Divisi</th>
        <th style="width: 150px">Nama Divisi</th>
        <th style="width: 100px">Aksi</th>
    </tr>
    @foreach ($divisi as $data)
    <tr>
        <td style="width: 150px">{{$data->id_divisi }}</td>
        <td style="width: 150px">{{$data->nama_divisi ?? ''}}</td>
        <td>
            <div class="btn-group" style="width:135px">
                <form action="{{ route('manajer.divisi.destroy',$data->id_divisi) }}" method="Post">
                    <a class="btn btn-primary" href="{{ route('manajer.divisi.edit',$data->id_divisi) }}">Edit</a>
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
    {!! $divisi->links() !!}
</div>

@endsection