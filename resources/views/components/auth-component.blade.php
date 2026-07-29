<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('all/assets/images/favicon.svg') }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap">
    <link rel="stylesheet" href="{{ asset('all/assets/css/style.css') }}" id="main-style-link">
    <link rel="stylesheet" href="{{ asset('all/assets/css/style-preset.css') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body>
    <div class="auth-wrapper">
        {{ $slot }}
    </div>
    <script src="{{ asset('all/assets/js/plugins/popper.min.js') }}"></script>
    <script src="{{ asset('all/assets/js/plugins/simplebar.min.js') }}"></script>
    <script src="{{ asset('all/assets/js/plugins/bootstrap.min.js') }}"></script>
    <script src="{{ asset('all/assets/js/plugins/feather.min.js') }}"></script>
    <script src="{{ asset('all/assets/js/fonts/custom-font.js') }}"></script>
    <script src="{{ asset('all/assets/js/pcoded.js') }}"></script>
    @stack('scripts')
</body>
</html>
