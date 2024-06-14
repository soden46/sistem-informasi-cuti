@extends('dashboard',[
'title' => 'Data Jenis Cuti',
'pageTitle' => 'Data Jenis Cuti'
])
@section('content')

@if ($message = Session::get('success'))
<div class="alert alert-success">
    <p>{{ $message }}</p>
</div>
@endif
<div class="d-flex justify-content-between mb-3">
    <div>
        <form action="{{ route('hrd.jeniscuti') }}" method="GET" class="d-flex">
            <input type="text" name="cari" class="form-control" placeholder="Cari Data" value="{{ request('cari') }}">
            <button type="submit" class="btn btn-md btn-primary ml-2">Search</button>
        </form>
    </div>
    <div>
        <a class="btn btn-md btn-primary" href="{{ route('hrd.jeniscuti.create') }}">Tambah Jenis Cuti</a>
        <!-- <a class="btn btn-md btn-success" href="{{ route('hrd.jeniscuti.cetak') }}" target="_blank"><i class="fa fa-print"></i> Cetak PDF</a> -->
    </div>
</div>
<table class="table table-bordered">
    <tr class="font-12">
        <th style="width: 150px">Id Jenis Cuti</th>
        <th style="width: 150px">Nama Cuti</th>
        <th style="width: 150px">Lama Cuti</th>
        <th style="width: 100px">Aksi</th>
    </tr>
    @foreach ($jenis as $data)
    <tr>
        <td style="width: 150px">{{$data->id_jenis_cuti }}</td>
        <td style="width: 150px">{{$data->nama_cuti ?? ''}}</td>
        <td style="width: 150px">{{$data->lama_cuti ?? ''}}</td>
        <td>
            <div class="btn-group" style="width:135px">
                <form action="{{ route('hrd.jeniscuti.destroy',$data->id_jenis_cuti) }}" method="Post">
                    <a class="btn btn-primary" href="{{ route('hrd.jeniscuti.edit',$data->id_jenis_cuti) }}">Edit</a>
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
    {!! $jenis->links() !!}
</div>

@endsection