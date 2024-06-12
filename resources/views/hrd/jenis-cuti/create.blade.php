@extends('dashboard',[
'title' => 'Tambah Jenis Cuti',
'pageTitle' => 'Tambah Jenis Cuti'
])
@section('content')
@if ($message = Session::get('success'))
<div class="alert alert-success">
    <p>{{ $message }}</p>
</div>
@endif

<div class="col-lg-8">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Tambah Jenis Cuti</h5>
        </div>
        <div class="card-body">
            <form method="post" action="{{ route('hrd.jeniscuti.save') }}" enctype="multipart/form-data">
                @csrf
                @method('POST')
                <div class="form-group">
                    <label for="nama_cuti">Nama Cuti</label>
                    <input type="text" class="form-control" id="nama_cuti" name="nama_cuti">
                </div>
                <div class="form-group">
                    <label for="lama_cuti">Lama Cuti</label>
                    <input type="text" class="form-control" id="lama_cuti" name="lama_cuti">
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
                <button type="reset" class="btn btn-secondary">Reset</button>
            </form>
        </div>
    </div>
</div>

@endsection