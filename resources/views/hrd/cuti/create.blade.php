@extends('dashboard',[
'title' => 'Tambah Data Cuti',
'pageTitle' => 'Tambah Data Cuti'
])

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Tambah Data Cuti</div>
                <div class="card-body">
                    <form action="{{ route('hrd.cuti.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="no_cuti">No Cuti</label>
                            <input type="text" name="no_cuti" class="form-control" placeholder="No Cuti" required>
                        </div>
                        <div class="form-group">
                            <label for="npp">NPP</label>
                            <input type="text" name="npp" class="form-control" placeholder="NPP" required>
                        </div>
                        <div class="form-group">
                            <label for="id_jenis_cuti">Jenis Cuti</label>
                            <select name="id_jenis_cuti" class="form-control" required>
                                @foreach ($jenisCuti as $jenis)
                                <option value="{{ $jenis->id }}">{{ $jenis->nama_cuti }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="tgl_pengajuan">Tanggal Pengajuan</label>
                            <input type="date" name="tgl_pengajuan" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="tgl_awal">Tanggal Awal</label>
                            <input type="date" name="tgl_awal" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="tgl_akhir">Tanggal Akhir</label>
                            <input type="date" name="tgl_akhir" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="durasi">Durasi Cuti</label>
                            <input type="number" name="durasi" class="form-control" placeholder="Durasi" required>
                        </div>
                        <div class="form-group">
                            <label for="keterangan">Keterangan</label>
                            <textarea name="keterangan" class="form-control" placeholder="Keterangan" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="stt_cuti">Status Cuti</label>
                            <select name="stt_cuti" class="form-control" required>
                                <option value="Pending">Pending</option>
                                <option value="Approved">Approved</option>
                                <option value="Rejected">Rejected</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="ket_reject">Keterangan Reject</label>
                            <textarea name="ket_reject" class="form-control" placeholder="Keterangan Reject"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="{{ route('hrd.cuti.index') }}" class="btn btn-secondary">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection