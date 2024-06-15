@extends('dashboard', [
'title' => 'Tambah Karyawan',
'pageTitle' => 'Tambah Karyawan'
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
            <h5 class="card-title">Tambah Karyawan</h5>
        </div>
        <div class="card-body">
            <form method="post" action="{{ route('manajer.keryawan.save') }}" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label for="npp">NPP</label>
                    <input type="text" class="form-control" id="npp" name="npp">
                </div>

                <div class="form-group">
                    <label for="id_divisi">Divisi</label>
                    <select class="form-control" id="id_divisi" name="id_divisi">
                        @foreach($div as $data)
                        <option value="{{$data->id_divisi}}">{{$data->id_divisi}} | {{$data->nama_divisi}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="nama_emp">Nama Karyawan</label>
                    <input type="text" class="form-control" id="nama_emp" name="nama_emp">
                </div>

                <div class="form-group">
                    <label for="jk_emp">Jenis Kelamin</label>
                    <select class="form-control" id="jk_emp" name="jk_emp">
                        <option value="Laki-Laki">Laki-Laki</option>
                        <option value="Perempuan">Perempuan</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="jabatan">Jabatan</label>
                    <input type="text" class="form-control" id="jabatan" name="jabatan">
                </div>

                <div class="form-group">
                    <label for="alamat">Alamat</label>
                    <textarea class="form-control" id="alamat" name="alamat" rows="3"></textarea>
                </div>

                <div class="form-group">
                    <label for="hak_akses">Hak Akses</label>
                    <select class="form-control" id="hak_akses" name="hak_akses">
                        <option value="manajer">Manajer Divisi</option>
                        <option value="hrd">HRD</option>
                        <option value="karyawan">Karyawan</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" name="password">
                </div>

                <div class="form-group">
                    <label for="active">Aktif</label>
                    <select class="form-control" id="active" name="active">
                        <option value="Ya">Ya</option>
                        <option value="Tidak">Tidak</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="telp_emp">Telepon</label>
                    <input type="text" class="form-control" id="telp_emp" name="telp_emp">
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
                <button type="reset" class="btn btn-secondary">Reset</button>
            </form>
        </div>
    </div>
</div>
@endsection