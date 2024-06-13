@extends('dashboard', [
'title' => 'Edit Manajer',
'pageTitle' => 'Edit Manajer',
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
            <h5 class="card-title">Edit Manajer</h5>
        </div>
        <div class="card-body">
            <form method="post" action="{{ route('hrd.manajer.update', $manajer->npp) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="npp">NPP</label>
                    <input type="text" class="form-control" id="npp" name="npp" value="{{ $manajer->npp }}">
                </div>

                <div class="form-group">
                    <label for="id_divisi">Divisi</label>
                    <select class="form-control" id="id_divisi" name="id_divisi">
                        @foreach ($div as $data)
                        <option value="{{ $data->id_divisi }}" {{ $manajer->id_divisi == $data->id_divisi ? 'selected' : '' }}>
                            {{ $data->id_divisi }} | {{ $data->nama_divisi }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="nama_emp">Nama manajer</label>
                    <input type="text" class="form-control" id="nama_emp" name="nama_emp" value="{{ $manajer->nama_emp }}">
                </div>

                <div class="form-group">
                    <label for="jk_emp">Jenis Kelamin</label>
                    <select class="form-control" id="jk_emp" name="jk_emp">
                        <option value="Laki-Laki" {{ $manajer->jk_emp == 'Laki-Laki' ? 'selected' : '' }}>Laki-Laki
                        </option>
                        <option value="Perempuan" {{ $manajer->jk_emp == 'Perempuan' ? 'selected' : '' }}>Perempuan
                        </option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="jabatan">Jabatan</label>
                    <input type="text" class="form-control" id="jabatan" name="jabatan" value="{{ $manajer->jabatan }}">
                </div>

                <div class="form-group">
                    <label for="alamat">Alamat</label>
                    <textarea class="form-control" id="alamat" name="alamat" rows="3">{{ $manajer->alamat }}</textarea>
                </div>

                <div class="form-group">
                    <label for="hak_akses">Hak Akses</label>
                    <select class="form-control" id="hak_akses" name="hak_akses">
                        <option value="manajer" {{ $manajer->hak_akses == 'manajer' ? 'selected' : '' }}>Manajer
                            Divisi</option>
                        <option value="hrd" {{ $manajer->hak_akses == 'hrd' ? 'selected' : '' }}>HRD</option>
                        <option value="manajer" {{ $manajer->hak_akses == 'manajer' ? 'selected' : '' }}>manajer
                        </option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="jml_cuti">Jumlah Cuti</label>
                    <input type="text" class="form-control" id="jml_cuti" name="jml_cuti" value="{{ $manajer->jml_cuti }}">
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" name="password">
                </div>

                <div class="form-group">
                    <label for="active">Aktif</label>
                    <select class="form-control" id="active" name="active">
                        <option value="Ya" {{ $manajer->active == 'Ya' ? 'selected' : '' }}>Ya</option>
                        <option value="Tidak" {{ $manajer->active == 'Tidak' ? 'selected' : '' }}>Tidak</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="telp_emp">Telepon</label>
                    <input type="text" class="form-control" id="telp_emp" name="telp_emp" value="{{ $manajer->telp_emp }}">
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('hrd.manajer') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
<script>
    document.getElementById("togglePassword").addEventListener("click", function() {
        var passwordInput = document.getElementById("password");
        var button = document.getElementById("togglePassword");

        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            button.textContent = "Hide";
        } else {
            passwordInput.type = "password";
            button.textContent = "Show";
        }
    });
</script>
@endsection