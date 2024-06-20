    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="utf-8">
        <title>{{ $pageTitle ?? '' }}</title>
        <meta content="width=device-width, initial-scale=1.0" name="viewport">
        <meta content="Sistem Informasi Pengajuan Cuti Karyawan" name="keywords">
        <meta content="Sistem Informasi Pengajuan Cuti Karyawan" name="description">
        <!-- Favicon -->
        <link rel="shortcut icon" type="image/x-generic" href="{{asset('assets/img/favicon.ico')}}">
        <link rel="manifest" href="/site.webmanifest">

        <!-- Google Font -->
        <link href="https://fonts.googleapis.com/css2?family=EB+Garamond:ital,wght@1,600;1,700;1,800&family=Roboto:wght@400;500&display=swap" rel="stylesheet">

        <!-- CSS Libraries -->
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
        <link href="{{asset('assets/lib/animate/animate.min.css')}}" rel="stylesheet">
        <link href="{{asset('assets/lib/owlcarousel/assets/owl.carousel.min.css')}}" rel="stylesheet">
        <!--404 CSS-->
        <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet" />
        <!-- Template Stylesheet -->
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
        <!-- Nav Bar End -->
        <!-- Content Start-->
        <div class="container-fluid">
            @yield('content')
        </div>
        <!-- Content End -->
        </div>
        <!-- Footer End -->

        <a href="#" class="back-to-top"><i class="fa fa-chevron-up"></i></a>
        </div>

        <!-- JavaScript Libraries -->
        <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
        <script src="{{asset('assets/lib/easing/easing.min.js')}}"></script>
        <script src="{{asset('assets/lib/owlcarousel/owl.carousel.min.js')}}"></script>
        <script src="{{asset('assets/lib/isotope/isotope.pkgd.min.js')}}"></script>

        <!-- Template Javascript -->
        <script src="{{asset('assets/js/main.js')}}"></script>

        
</body>

</html>