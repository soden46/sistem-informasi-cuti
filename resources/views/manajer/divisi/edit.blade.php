@extends('dashboard',[
'title' => 'Edit Divisi',
'pageTitle' => 'Edit Divisi'
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
            <h5 class="card-title">Edit Divisi</h5>
        </div>
        <div class="card-body">
            <form method="post" action="{{ route('hrd.divisi.update', $divisi->id_divisi) }}" enctype="multipart/form-data">
                @csrf
                @method('POST') <!-- Tambahkan ini untuk mengirimkan metode PUT -->

                <div class="form-group">
                    <label for="nama_divisi">Nama Divisi</label>
                    <input type="text" class="form-control" id="nama_divisi" name="nama_divisi" value="{{ $divisi->nama_divisi }}">
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('hrd.divisi') }}" class="btn btn-secondary">Batal</a> <!-- Tambahkan tombol untuk membatalkan -->
            </form>
        </div>
    </div>
</div>

@endsection