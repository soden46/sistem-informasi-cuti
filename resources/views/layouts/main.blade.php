<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Sistem Informasi Cuti Karyawan</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="/favicon.ico" rel="icon">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=EB+Garamond:ital,wght@1,600;1,700;1,800&family=Roboto:wght@400;500&display=swap" rel="stylesheet">

    <!-- CSS Libraries -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="{{asset('assets/lib/animate/animate.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/lib/owlcarousel/assets/owl.carousel.min.css')}}" rel="stylesheet">

    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/5fafd18292.js" crossorigin="anonymous"></script>
    <!-- Custom styles for this template-->
    <link href="{{ asset('assets/template/backend/sb-admin-2/css/sb-admin-2.min.css') }}" rel="stylesheet">
    <link href="{{asset('assets/css/style.css')}}" rel="stylesheet">
    <style>
    .required::after {
        content: "*";
        color: red;
        margin-left: 5px;
    }
</style>


</head>

<body>
    @yield('content')
    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="{{asset('assets/lib/easing/easing.min.js')}}"></script>
    <script src="{{asset('assets/lib/owlcarousel/owl.carousel.min.js')}}"></script>
    <script src="{{asset('assets/lib/isotope/isotope.pkgd.min.js')}}"></script>

    <!-- Template Javascript -->
    <script src="{{asset('assets/js/main.js')}}"></script>
    <!--SB Admin-->
    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('assets/template/backend/sb-admin-2/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/template/backend/sb-admin-2/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!--template-->

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('assets/template/backend/sb-admin-2/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('assets/template/backend/sb-admin-2/js/sb-admin-2.min.js') }}"></script>
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
</body>

</html>