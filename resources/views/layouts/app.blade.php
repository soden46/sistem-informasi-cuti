<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Sistem Informasi Cuti Karyawan') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <style>
    .required::after {
        content: "*";
        color: red;
        margin-left: 5px;
    }
</style>

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Rekrutmen Ekstrakulikuler') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                        @if (Route::has('login'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                        @endif

                        @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                        @endif
                        @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->nama }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
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
    </div>
</body>

</html>