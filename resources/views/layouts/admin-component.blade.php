<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-pc-preset="preset-1" data-pc-direction="ltr" data-pc-theme="light">
<head>
    <!-- Basic Meta Tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- SEO Meta Tags -->
    <meta name="description" content="Admin Dashboard - Laravel Application">
    <meta name="keywords" content="Admin, Dashboard, Laravel, Management System">
    <meta name="author" content="Your Application">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config($tittle ?? 'FSY | Dashboard') }}</title>

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('all/assets/images/favicon.svg') }}">

    <!-- [Favicon] icon -->
    <link rel="icon" href="{{ asset('all/assets/images/remove.png')}}" type="image/x-icon"> <!-- [Google Font] Family -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap" id="main-font-link">
    <!-- [Tabler Icons] https://tablericons.com -->
    <link rel="stylesheet" href="{{ asset('all/assets/fonts/tabler-icons.min.css')}}" >
    <!-- [Feather Icons] https://feathericons.com -->
    <link rel="stylesheet" href="{{ asset('all/assets/fonts/feather.css')}}" >
    <!-- [Font Awesome Icons] https://fontawesome.com/icons -->
    <link rel="stylesheet" href="{{ asset('all/assets/fonts/fontawesome.css')}}" >
    <!-- [Material Icons] https://fonts.google.com/icons -->
    <link rel="stylesheet" href="{{ asset('all/assets/fonts/material.css')}}" >
    <!-- [Template CSS Files] -->
    <link rel="stylesheet" href="{{ asset('all/assets/css/style.css')}}" id="main-style-link" >
    <link rel="stylesheet" href="{{ asset('all/assets/css/style-preset.css')}}" >


    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Mobile Overlay for Sidebar -->
    <div class="mobile-overlay"></div>

    <!-- Custom Styles -->
    @stack('styles')
</head>

<body>
    <!-- Pre-loader -->
    <div class="loader-bg">
        <div class="loader-track">
            <div class="loader-fill"></div>
        </div>
    </div>

    <!-- Header -->
    <header class="pc-header">
        <div class="header-wrapper">
            <div class="me-auto pc-mob-drp">
              @include('admin.partials.header')
            </div>
        </div>
    </header>

    <!-- Sidebar Navigation -->
    <nav class="pc-sidebar">
        <div class="navbar-wrapper">
            <div class="m-header">
                <a href="{{ route('admin.dashboard') }}" class="b-brand text-primary">
                    <img src="{{ asset('all/assets/images/logo-dark.svg') }}" class="img-fluid logo-lg" alt="Logo">
                </a>
              
            </div>
            @include('admin.partials.sidebar')
        </div>
    </nav>

    <!-- Main Content Area -->
    <div class="pc-container">
        <div class="pc-content">
            <!-- Page Header -->
            @if(isset($pageHeader))
                <div class="page-header">
                    {{ $pageHeader }}
                </div>
            @endif

            <!-- Main Slot Content -->
            {{ $slot }}
        </div>
    </div>

   

    <!-- Scripts -->
    <!-- Core JS Files -->
    <script src="{{ asset('all/assets/js/plugins/popper.min.js') }}"></script>
    <script src="{{ asset('all/assets/js/plugins/simplebar.min.js') }}"></script>
    <script src="{{ asset('all/assets/js/plugins/bootstrap.min.js') }}"></script>
    <script src="{{ asset('all/assets/js/plugins/feather.min.js') }}"></script>

    <!-- Theme JS Files -->
    <script src="{{ asset('all/assets/js/fonts/custom-font.js') }}"></script>
    <script src="{{ asset('all/assets/js/pcoded.js') }}"></script>
    <script src="{{ asset('all/assets/js/plugins/apexcharts.min.js') }}"></script>
    <script src="{{ asset('all/assets/js/pages/dashboard-default.js') }}"></script>

    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


</body>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<script>
    function logoutConfirm() {
        Swal.fire({
            title: "<i class='fas fa-power-off text-red-500'></i> Logout",
            html: "<p style='font-size:14px; color:#4b5563;'>Are you sure you want to end your session?</p>",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "<i class='fas fa-sign-out-alt'></i> Logout",
            cancelButtonText: "<i class='fas fa-times'></i> Cancel",
            confirmButtonColor: "#374151", // dark gray
            cancelButtonColor: "#9ca3af",  // light gray
            background: "#f3f4f6", // light gray (dashboard look)
            color: "#111827", // dark text
            customClass: {
                popup: "rounded-xl shadow-2xl border border-gray-300",
                title: "text-lg font-semibold text-gray-800",
                confirmButton: "px-4 py-2 rounded-md font-medium shadow hover:bg-gray-700",
                cancelButton: "px-4 py-2 rounded-md font-medium shadow hover:bg-gray-400"
            }
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: "<i class='fas fa-spinner fa-spin'></i> Logging out...",
                    text: "Please wait while we end your session",
                    showConfirmButton: false,
                    background: "#f3f4f6",
                    color: "#111827",
                    timer: 1500,
                    timerProgressBar: true,
                }).then(() => {
                    document.getElementById("logout-form").submit();
                });
            }
        });
    }
</script>






</html>
