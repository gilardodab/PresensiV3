<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover">
    <title>{{ config('app.name') }}</title>
    <meta name="theme-color" content="#FF396F">
    <meta name="msapplication-navbutton-color" content="#FF396F">
    <meta name="apple-mobile-web-app-status-bar-style" content="#FF396F">
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
</head>

<body>
    <div class="loading">
        <div class="spinner-border text-primary" role="status"></div>
    </div>
    <!-- loader -->
    <div id="loader">
        <img src="{{ url('/assets/img/logo-icon.png') }}" alt="icon" class="loading-icon">
    </div>
<div id="appCapsule">

    <div class="section mt-2 text-center">
        <h1>Masuk</h1>
        <h4>Isi formulir untuk masuk</h4>
    </div>
    <div class="section mb-5 p-2">

        <form id="form-login">
            <div class="card">
                <div class="card-body pb-1">
                    <div class="form-group basic">
                        <div class="input-wrapper">
                            <label class="label" for="email1">E-mail</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="E-mail Anda">
                            <i class="clear-input"><ion-icon name="close-circle"></ion-icon></i>
                        </div>
                    </div>
    
                    <div class="form-group basic">
                        <div class="input-wrapper">
                            <label class="label" for="password1">Password</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Kata sandi Anda">
                            <i class="clear-input"><ion-icon name="close-circle"></ion-icon></i>
                        </div>
                    </div>
                </div>
            </div>


            <div class="form-links mt-2">
                <div>
                    <a href="register">Mendaftar</a>
                </div>
                <div><a href="forgot" class="text-muted">Lupa Password?</a></div>
            </div>

            <div class="form-button-group transparent">
               <button type="submit" class="btn btn-primary btn-block"><ion-icon name="log-in-outline"></ion-icon> Masuk</button>
            </div>

        </form>
    </div>

</div>
</body>
</html>

@include('layouts.scripts')