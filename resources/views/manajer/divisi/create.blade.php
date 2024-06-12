@extends('dashboard',[
'title' => 'Tambah Divisi',
'pageTitle' => 'Tambah Divisi'
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
            <h5 class="card-title">Tambah Divisi</h5>
        </div>
        <div class="card-body">
            <form method="post" action="{{ route('hrd.divisi.save') }}" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label for="nama_divisi">Nama Divisi</label>
                    <input type="text" class="form-control" id="nama_divisi" name="nama_divisi">
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
                <button type="reset" class="btn btn-secondary">Reset</button>
            </form>
        </div>
    </div>
</div>

@endsection