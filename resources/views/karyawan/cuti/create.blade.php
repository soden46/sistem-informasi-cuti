@extends('dashboard', [
'title' => 'Tambah Data Cuti',
'pageTitle' => 'Tambah Data Cuti',
])

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Tambah Data Cuti</div>
                <div class="card-body">
                    <form action="{{ route('karyawan.cuti.save') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="npp" class="required">NPP</label>
                            <input type="text" name="npp" class="form-control" placeholder="NPP" value="{{ $karyawan->npp }}" readonly required>
                        </div>
                        <div class="form-group">
                            <label for="id_jenis_cuti" class="required">Jenis Cuti</label>
                            <select name="id_jenis_cuti" id="id_jenis_cuti" class="form-control" required>
                                @foreach ($jenisCuti as $jenis)
                                <option value="{{ $jenis->id_jenis_cuti }}">{{ $jenis->nama_cuti }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="tgl_awal" class="required">Tanggal Awal</label>
                            <input type="date" name="tgl_awal" id="tgl_awal" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="tgl_akhir" class="required">Tanggal Akhir</label>
                            <input type="date" name="tgl_akhir" id="tgl_akhir" class="form-control" required readonly>
                        </div>
                        <div class="form-group">
                            <label for="durasi" class="required">Durasi Cuti</label>
                            <input type="number" name="durasi" id="durasi" class="form-control" placeholder="Durasi" required>
                        </div>
                        <div class="form-group">
                            <label for="bukti_cuti">Surat Keterangan Dokter</label>
                            <input type="file" name="bukti_cuti" class="form-control" placeholder="bukti_cuti" required>
                        </div>
                        <div class="form-group">
                            <label for="keterangan" class="required">Keterangan</label>
                            <textarea name="keterangan" class="form-control" placeholder="Keterangan" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="{{ route('karyawan.cuti') }}" class="btn btn-secondary">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const tglAwalInput = document.getElementById('tgl_awal');
        const durasiInput = document.getElementById('durasi');
        const tglAkhirInput = document.getElementById('tgl_akhir');

        function calculateEndDate() {
            const tglAwal = new Date(tglAwalInput.value);
            const durasi = parseInt(durasiInput.value);

            if (!isNaN(tglAwal) && !isNaN(durasi)) {
                tglAwal.setDate(tglAwal.getDate() + durasi);
                tglAkhirInput.value = tglAwal.toISOString().split('T')[0];
            }
        }

        tglAwalInput.addEventListener('input', calculateEndDate);
        durasiInput.addEventListener('input', calculateEndDate);
    });
</script>
@endsection
