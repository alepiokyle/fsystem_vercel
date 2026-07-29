<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-pc-preset="preset-1" data-pc-direction="ltr" data-pc-theme="light">
<head>
    <!-- Basic Meta Tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">


    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Login</title>


    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

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

  <div class="auth-main">
    <div class="auth-wrapper v3">
     {{$slot}}
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

</body>
</html>

