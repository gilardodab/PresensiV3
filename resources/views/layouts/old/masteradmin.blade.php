<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Dashboard | </title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <meta http-equiv="cache-control" content="no-cache">
  <meta http-equiv="Pragma" content="no-cache">
  <meta name="robots" content="noindex">
  <meta name="googlebot" content="noindex">
  <meta name="mobile-web-app-capable" content="yes">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="shortcut icon" href="{{ asset('content/favicon.png') }}">
  <link rel="apple-touch-icon" href="{{ asset('content/favicon.png') }}">
  <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('content/favicon.png') }}">
  <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('content/favicon.png') }}">
  <link rel="stylesheet" href="{{ asset('admin/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('admin/css/AdminLTE.min.css') }}">
  <link rel="stylesheet" href="{{ asset('admin/css/skin-blue-light.css') }}">
  <link rel="stylesheet" href="{{ asset('admin/css/font-awesome.css') }}">
  <link rel="stylesheet" href="{{ asset('admin/css/sw-custom.css') }}">
  <link rel="stylesheet" href="{{ asset('admin/plugins/datepicker/datepicker3.css') }}">
  <link rel="stylesheet" href="{{ asset('admin/plugins/timepicker/bootstrap-timepicker.min.css') }}">
  {{-- <link rel="stylesheet" href="{{ asset('admin/plugins/leaflet/leaflet.css') }}">
  <link rel="stylesheet" href="{{ asset('admin/plugins/leaflet/L.Control.Locate.min.css') }}">   --}}
  @if(Request::is('kantor'))
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
  @endif
  <link rel="stylesheet" type="text/css" href="{{ asset('admin/css/simple-lightbox.min.css') }}">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

    <link rel="stylesheet" href="{{ asset('admin/plugins/select2/dist/css/select2.min.css') }}">

    <link rel="stylesheet" href="{{ asset('admin/plugins/datepicker/datepicker3.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/js/plugins/magnific-popup/magnific-popup.css') }}">


 
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body class="sidebar-mini skin-blue-light fixed">
<div class="wrapper">
    <div class="loading"></div>
    
@include('layouts.header')
@include('layouts.sidebar')   


 @yield('content')

@include('layouts.footer')
@include('sweetalert::alert')

@include('layouts.scriptadmin')

</body>

</html>



