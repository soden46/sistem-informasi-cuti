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
                            <input type="text" name="npp" class="form-control" value="{{ $cuti->npp }}" readonly>
                        </div>

                        <div class="form-group">
                            <label for="id_jenis_cuti" class="required">Jenis Cuti</label>
                            <select name="id_jenis_cuti" id="id_jenis_cuti" class="form-control" required onchange="calculateEndDate()">
                                @foreach ($jenisCuti as $jenis)
                                    <option value="{{ $jenis->id_jenis_cuti }}" data-lama-cuti="{{ $jenis->lama_cuti }}" {{ $cuti->id_jenis_cuti == $jenis->id_jenis_cuti ? 'selected' : '' }}>{{ $jenis->nama_cuti }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="tgl_awal" class="required">Tanggal Awal</label>
                            <input type="date" name="tgl_awal" id="tgl_awal" class="form-control" value="{{ $cuti->tgl_awal }}" required onchange="calculateEndDate()">
                        </div>

                        <div class="form-group">
                            <label for="tgl_akhir" class="required">Tanggal Akhir</label>
                            <input type="date" name="tgl_akhir" id="tgl_akhir" class="form-control" value="{{ $cuti->tgl_akhir }}" readonly>
                        </div>

                        <div class="form-group">
                            <label for="durasi" class="required">Durasi Cuti (hari)</label>
                            <input type="number" name="durasi" id="durasi" class="form-control" value="{{ $cuti->durasi }}" required>
                        </div>

                        <div class="form-group">
                            <label for="bukti_cuti">Surat Keterangan Dokter</label>
                            <input type="file" name="bukti_cuti" class="form-control">
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
    function calculateEndDate() {
        const idJenisCuti = document.getElementById('id_jenis_cuti').value;
        const tglAwal = new Date(document.getElementById('tgl_awal').value);
        const lamaCuti = parseInt(document.querySelector(`#id_jenis_cuti option[value="${idJenisCuti}"]`).getAttribute('data-lama-cuti'));

        if (!isNaN(tglAwal) && !isNaN(lamaCuti)) {
            tglAwal.setDate(tglAwal.getDate() + lamaCuti);
            document.getElementById('tgl_akhir').value = tglAwal.toISOString().split('T')[0];
            document.getElementById('durasi').value = lamaCuti;
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        calculateEndDate();
    });
</script>

@endsection
