@extends('dashboard',[
'title' => 'Edit Jenis Cuti',
'pageTitle' => 'Edit Jenis Cuti'
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
            <h5 class="card-title">Edit Jenis Cuti</h5>
        </div>
        <div class="card-body">
            <form method="post" action="{{ route('hrd.jeniscuti.update', $jenis->id_jenis_cuti) }}" enctype="multipart/form-data">
                @csrf
                @method('POST') <!-- Tambahkan ini untuk mengirimkan metode PUT -->

                <div class="form-group">
                    <label for="nama_cuti">Nama Cuti</label>
                    <input type="text" class="form-control" id="nama_cuti" name="nama_cuti" value="{{ $jenis->nama_cuti }}">
                </div>

                <div class="form-group">
                    <label for="lama_cuti">Lama Cuti</label>
                    <input type="text" class="form-control" id="lama_cuti" name="lama_cuti" value="{{ $jenis->lama_cuti }}">
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('hrd.jeniscuti') }}" class="btn btn-secondary">Batal</a> <!-- Tambahkan tombol untuk membatalkan -->
            </form>
        </div>
    </div>
</div>

@endsection