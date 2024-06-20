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
                    <form action="{{ route('karyawan.cuti.update', $cuti->no_cuti) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="npp" class="required">NPP</label>
                            <input type="text" name="npp" class="form-control" value="{{ $cuti->npp }}" readonly required>
                        </div>
                        <div class="form-group">
                            <label for="id_jenis_cuti" class="required">Jenis Cuti</label>
                            <select name="id_jenis_cuti" id="id_jenis_cuti" class="form-control" required>
                                @foreach ($jenisCuti as $jenis)
                                <option value="{{ $jenis->id_jenis_cuti }}" {{ $cuti->id_jenis_cuti == $jenis->id_jenis_cuti ? 'selected' : '' }}>
                                    {{ $jenis->nama_cuti }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="tgl_awal" class="required">Tanggal Awal</label>
                            <input type="date" name="tgl_awal" id="tgl_awal" class="form-control" value="{{ $cuti->tgl_awal }}" required>
                        </div>
                        <div class="form-group">
                            <label for="tgl_akhir" class="required">Tanggal Akhir</label>
                            <input type="date" name="tgl_akhir" id="tgl_akhir" class="form-control" value="{{ $cuti->tgl_akhir }}" required readonly>
                        </div>
                        <div class="form-group">
                            <label for="durasi" class="required">Durasi Cuti</label>
                            <input type="number" name="durasi" id="durasi" class="form-control" value="{{ $cuti->durasi }}" required>
                        </div>
                        <div class="form-group">
                            <label for="bukti_cuti">Surat Keterangan Dokter</label>
                            <input type="file" name="bukti_cuti" class="form-control" placeholder="bukti_cuti">
                            <small class="form-text text-muted">Biarkan kosong jika tidak ingin mengganti file.</small>
                        </div>
                        <div class="form-group">
                            <label for="keterangan" class="required">Keterangan</label>
                            <textarea name="keterangan" class="form-control" required>{{ $cuti->keterangan }}</textarea>
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

        if (tglAwalInput.value && durasiInput.value) {
            calculateEndDate();
        }
    });
</script>
@endsection
