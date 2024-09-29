<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Login Administrator</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <meta name="description" content="Login">
  <meta name="author" content="pixelcave">
  <meta name="robots" content="noindex, nofollow">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <!-- Icons -->
  <link rel="shortcut icon" href="{{ asset('content/favicon.png') }}">
  <link rel="apple-touch-icon" href="{{ asset('content/favicon.png') }}">
  <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('content/favicon.png') }}">
  <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('content/favicon.png') }}">

  <link rel="stylesheet" href="{{ asset('admin/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('admin/css/AdminLTE.min.css') }}">
  <link rel="stylesheet" href="{{ asset('admin/css/skin-blue-light.css') }}">
  <link rel="stylesheet" href="{{ asset('admin/css/font-awesome.css') }}">

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

  <!-- jQuery -->
  <script src="{{ asset('admin/js/jquery.min.js') }}"></script>

  <!-- Bootstrap -->
  <script src="{{ asset('admin/js/bootstrap.min.js') }}"></script>

  <!-- AdminLTE -->
  <script src="{{ asset('admin/js/adminlte.js') }}"></script>

  <!-- Demo -->
  <script src="{{ asset('admin/js/demo.js') }}"></script>

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="./"><img src=""  oncontextmenu="return false;" height="50"></a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Silahkan masukkan username dan password :</p>

    <div class="form-group has-feedback">
      <input type="text" id="username" name="username" class="form-control" placeholder="Username">
      <span class="fa fa-user form-control-feedback"></span>
    </div>
   
    <div class="form-group has-feedback">
      <input type="password" id="password" name="password" class="form-control" placeholder="Password">
      <span class="glyphicon glyphicon-lock form-control-feedback"></span>
    </div>
    <hr>
    <div class="row">
      <div class="col-md-12" style="min-height:40px;"><span id="stat"></span></div>
      <div class="col-xs-12">
        <button type="submit" class="btn btn-primary btn-block btn-flat" id="login">Login to Admin</button>
      </div>
      <!-- /.col -->
    </div>
  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<footer class="text-muted text-center">
  <small><span id="credits"><a class="credits" href="">Laksa Techno</a> - All Rights Reserved</span>
  <em>2023</em></small>
</footer>
<script src="{{ asset('assets/js/sweetalert.min.js') }}"></script>

<script>
function loading() {
    $("#stat").html('<div class="alert alert-info"><i>Authenticating..</i></div>');
}

$(document).ready(function () {
  $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $("#login").click(function () {
        login();
    });
});

function login() {
    if ($("#username").val() == "" || $("#password").val() == "") {
        $("#stat").fadeTo('slow', '1.99');
        $("#stat").fadeIn('slow', function () {
            $("#stat").html('<div class="alert alert-warning">Username/Password belum lengkap !</div>');
        });
        return false;
    } else {
        loading();
        var username = $("#username").val();
        var password = $("#password").val();
        $.ajax({
            url: "{{ route('prosesloginadmin') }}",
            method: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                username: username,
                password: password
            },
            success: function (json) {
                if (json.response.error == "0") { // jika login gagal
                    $("#stat").fadeTo('slow', '1.99');
                    $("#stat").fadeIn('slow', function () {
                        $("#stat").html('<div class="alert alert-danger">Periksa username & Password anda.!</div>');
                        swal({
                            title: "Login Failed",
                            text: "Periksa username & Password anda.!",
                            icon: "error",
                        })
                    });
                } else if (json.response.error == "1") { // jika login sukses
                    $("#stat").fadeOut('slow', function () {
                      swal({title: 'Login Success', text: 'Selamat datang ', icon: 'success', timer: 2000});
                      setInterval(() => {
                        window.location.replace("{{ route('dashboard') }}");
                      }, 2000);
                        
                    });
                }
            }
        });
        return false;
    }
}
</script>
</body>
</html>
