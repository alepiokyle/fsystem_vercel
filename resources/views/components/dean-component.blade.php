<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-pc-preset="preset-1" data-pc-direction="ltr" data-pc-theme="light">
<head>
    <!-- Basic Meta Tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">


    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Dean Dashboard</title>


    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Mobile Overlay for Sidebar -->
    <div class="mobile-overlay"></div>

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
                @include('dean.partials.header')
            </div>
        </header>

        <!-- Sidebar Navigation -->
        <nav class="pc-sidebar">
            <div class="navbar-wrapper">
                <div class="m-header">
                    <a href="{{ route('Dean.deandashboard') }}" class="b-brand text-primary">
                        <img src="{{ asset('all/assets/images/logo-dark.svg') }}" class="img-fluid logo-lg" alt="Logo">
                    </a>
                </div>
                @include('dean.partials.sidebar')
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

        <!-- Footer -->
        <footer class="pc-footer">
            <div class="footer-wrapper container-fluid">
                @include('dean.partials.footer')
            </div>
        </footer>

        <script src="{{ asset('all/assets/js/plugins/popper.min.js') }}"></script>
        <script src="{{ asset('all/assets/js/plugins/simplebar.min.js') }}"></script>
        <script src="{{ asset('all/assets/js/plugins/bootstrap.min.js') }}"></script>
        <script src="{{ asset('all/assets/js/fonts/custom-font.js') }}"></script>
        <script src="{{ asset('all/assets/js/pcoded.js') }}"></script>
        <script src="{{ asset('all/assets/js/plugins/feather.min.js') }}"></script>

        <!-- jQuery CDN -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

         <!-- SweetAlert2 CDN -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </body>

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

    function switchRole() {
        Swal.fire({
            title: "<i class='fas fa-exchange-alt text-blue-500'></i> Switch Role",
            html: "<p style='font-size:14px; color:#4b5563;'>Are you sure you want to switch your role? You are currently logged in as Dean. Switching roles will redirect you to the Teacher Dashboard.</p>",
            icon: "question",
            showCancelButton: true,
            confirmButtonText: "<i class='fas fa-check'></i> Switch",
            cancelButtonText: "<i class='fas fa-times'></i> Cancel",
            confirmButtonColor: "#0d6efd", // blue
            cancelButtonColor: "#6c757d",  // gray
            background: "#f3f4f6",
            color: "#111827",
            customClass: {
                popup: "rounded-xl shadow-2xl border border-gray-300",
                title: "text-lg font-semibold text-gray-800",
                confirmButton: "px-4 py-2 rounded-md font-medium shadow hover:bg-blue-700",
                cancelButton: "px-4 py-2 rounded-md font-medium shadow hover:bg-gray-600"
            }
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "{{ route('dean.switch-role') }}";
            }
        });
    }
</script>

</html>
