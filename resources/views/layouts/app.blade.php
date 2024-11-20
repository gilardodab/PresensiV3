<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover">
    <title>{{ config('app.name') }}</title>
    <meta name="theme-color" content="#90319a">
    <meta name="msapplication-navbutton-color" content="#90319a">
    <meta name="apple-mobile-web-app-status-bar-style" content="#90319a">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicons -->
    <link rel="shortcut icon" href="{{ url('/content/favicon.png') }}">
    <link rel="apple-touch-icon" href="{{ url('/content/favicon.png') }}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{ url('/ontent/favicon.png') }}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{ url('content/favicon.png') }}">

    <meta name="robots" content="index, follow">
    <meta name="description" content="{{ config('app.meta_description') }}">
    <meta name="keywords" content="{{ config('app.meta_keywords') }}">
    <meta name="author" content="{{ config('app.name') }}">
    <meta http-equiv="Copyright" content="{{ config('app.name') }}">
    <meta name="copyright" content="{{ config('app.name') }}">
    <meta itemprop="image" content="content/meta-tag.jpg">

    <link rel="stylesheet" href="{{ url('/assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ url('/assets/css/custom.css') }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    
    @if(request()->is('history'))
        <link rel="stylesheet" href="{{ url('/assets/js/plugins/datepicker/datepicker3.css') }}">
        <link rel="stylesheet" href="{{ url('/assets/js/plugins/datatables/dataTables.bootstrap.css') }}">
        <link rel="stylesheet" href="{{ url('/assets/js/plugins/magnific-popup/magnific-popup.css') }}">
    @endif
    <link rel="manifest" href="__manifest.json"> 
</head>

<body>
    {{-- <div class="loading">
        <div class="spinner-border text-primary" role="status"></div>
    </div> --}}
    <!-- loader -->
    {{-- <div id="loader">
        <img src="{{ url('/assets/img/logo-icon.png') }}" alt="icon" class="loading-icon">
    </div> --}}
    <!-- * loader -->
    @include('layouts.appheader')
    @yield('content')
    @include('layouts.appfooter')
    @include('layouts.scripts')
    @stack('custom-scripts')
</body>
</html>

