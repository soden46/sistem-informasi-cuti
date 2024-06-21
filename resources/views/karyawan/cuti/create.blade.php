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
                            <input type="text" name="npp" class="form-control" value="{{ $karyawan->npp }}" readonly required>
                        </div>

                        <div class="form-group">
                            <label for="id_jenis_cuti" class="required">Jenis Cuti</label>
                            <select name="id_jenis_cuti" id="id_jenis_cuti" class="form-control" required onchange="calculateDuration()">
                                @foreach ($jenisCuti as $jenis)
                                    <option value="{{ $jenis->id_jenis_cuti }}" data-lama-cuti="{{ $jenis->lama_cuti }}">{{ $jenis->nama_cuti }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="tgl_awal" class="required">Tanggal Awal</label>
                            <input type="date" name="tgl_awal" id="tgl_awal" class="form-control" required onchange="calculateDuration()">
                        </div>

                        <div class="form-group">
                            <label for="tgl_akhir" class="required">Tanggal Akhir</label>
                            <input type="date" name="tgl_akhir" id="tgl_akhir" class="form-control" required onchange="calculateDuration()">
                        </div>

                        <div class="form-group">
                            <label for="durasi" class="required">Durasi Cuti (hari)</label>
                            <input type="number" name="durasi" id="durasi" class="form-control" placeholder="Masukkan durasi cuti dalam hari" readonly required>
                        </div>

                        <div class="form-group">
                            <label for="bukti_cuti">Surat Keterangan Dokter</label>
                            <input type="file" name="bukti_cuti" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="keterangan" class="required">Keterangan</label>
                            <textarea name="keterangan" class="form-control" placeholder="Masukkan keterangan mengenai cuti" required></textarea>
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
    function calculateDuration() {
        const tglAwal = new Date(document.getElementById('tgl_awal').value);
        const tglAkhir = new Date(document.getElementById('tgl_akhir').value);
        
        if (tglAwal && tglAkhir && tglAkhir >= tglAwal) {
            const timeDiff = Math.abs(tglAkhir - tglAwal);
            const diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24)) + 1; // +1 to include the start day
            document.getElementById('durasi').value = diffDays;
        } else {
            document.getElementById('durasi').value = '';
        }
    }
</script>
@endsection
