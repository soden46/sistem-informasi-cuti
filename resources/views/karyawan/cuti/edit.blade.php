@extends('dashboard', [
'title' => 'Edit Data Cuti',
'pageTitle' => 'Edit Data Cuti',
])

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Edit Data Cuti</div>
                <div class="card-body">
                    <form action="{{ route('karyawan.cuti.update', $cuti->no_cuti) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="npp">NPP</label>
                            <input type="text" name="npp" class="form-control" value="{{ $cuti->npp }}" readonly required>
                        </div>
                        <div class="form-group">
                            <label for="id_jenis_cuti">Jenis Cuti</label>
                            <select name="id_jenis_cuti" class="form-control">
                                @foreach ($jenisCuti as $jenis)
                                <option value="{{ $jenis->id_jenis_cuti }}" {{ isset($cuti) && $cuti->id_jenis_cuti == $jenis->id_jenis_cuti ? 'selected' : '' }}>
                                    {{ $jenis->nama_cuti }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="tgl_pengajuan">Tanggal Pengajuan</label>
                            <input type="date" name="tgl_pengajuan" class="form-control" value="{{ $cuti->tgl_pengajuan }}" required>
                        </div>
                        <div class="form-group">
                            <label for="tgl_awal">Tanggal Awal</label>
                            <input type="date" name="tgl_awal" class="form-control" value="{{ $cuti->tgl_awal }}" required>
                        </div>
                        <div class="form-group">
                            <label for="tgl_akhir">Tanggal Akhir</label>
                            <input type="date" name="tgl_akhir" class="form-control" value="{{ $cuti->tgl_akhir }}" required>
                        </div>
                        <div class="form-group">
                            <label for="durasi">Durasi Cuti</label>
                            <input type="number" name="durasi" class="form-control" value="{{ $cuti->durasi }}" required>
                        </div>
                        <div class="form-group">
                            <label for="keterangan">Keterangan</label>
                            <textarea name="keterangan" class="form-control" required>{{ $cuti->keterangan }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
                        <a href="{{ route('karyawan.cuti') }}" class="btn btn-secondary">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection