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
                            <input type="date" name="tgl_akhir" id="tgl_akhir" class="form-control" required>
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
        const jenisCutiSelect = document.getElementById('id_jenis_cuti');

        function calculateEndDate() {
            const tglAwal = new Date(tglAwalInput.value);
            const durasi = parseInt(durasiInput.value);

            if (!isNaN(tglAwal) && !isNaN(durasi)) {
                // Ambil durasi cuti berdasarkan jenis cuti yang dipilih
                const selectedJenisCuti = jenisCutiSelect.options[jenisCutiSelect.selectedIndex].text;
                const durasiCuti = getDurasiCuti(selectedJenisCuti); // Fungsi untuk mendapatkan durasi cuti dari jenis cuti

                if (durasiCuti !== null) {
                    durasiInput.value = durasiCuti;
                    tglAwal.setDate(tglAwal.getDate() + durasiCuti);
                } else {
                    durasiInput.value = durasi;
                    tglAwal.setDate(tglAwal.getDate() + durasi);
                }

                tglAkhirInput.value = tglAwal.toISOString().split('T')[0];
            }
        }

        function getDurasiCuti(jenisCuti) {
            // Tambahkan logika untuk mendapatkan durasi cuti berdasarkan jenis cuti
            // Contoh sederhana, Anda bisa mengganti dengan logika sesuai dengan jenis cuti yang tersedia
            switch (jenisCuti) {
                case 'Cuti Tahunan':
                    return 14; // Contoh: Cuti Tahunan memiliki durasi 14 hari
                case 'Cuti Sakit':
                    return 7; // Contoh: Cuti Sakit memiliki durasi 7 hari
                default:
                    return null; // Jika jenis cuti tidak dikenali, kembalikan null atau durasi default
            }
        }

        // Event listener untuk perubahan tanggal awal dan durasi cuti
        tglAwalInput.addEventListener('input', calculateEndDate);
        durasiInput.addEventListener('input', calculateEndDate);

        // Event listener untuk perubahan jenis cuti
        jenisCutiSelect.addEventListener('change', function () {
            calculateEndDate(); // Panggil calculateEndDate() saat jenis cuti berubah
        });
    });
</script>
@endsection
