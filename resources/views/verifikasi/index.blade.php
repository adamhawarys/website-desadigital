<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Verifikasi Akun | Website Desa Bengkel</title>

  <link href="{{ asset('adminlte3/dist/img/logo-desa-bengkel.png') }}" rel="icon">
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('adminlte3/plugins/fontawesome-free/css/all.min.css') }}">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="{{ asset('adminlte3/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('adminlte3/dist/css/adminlte.min.css') }}">
  <link rel="stylesheet" href="{{ asset('adminlte3/dist/css/custom.css') }}">
</head>
<body class="hold-transition login-page">
<div class="login-boxx">
  <div class="login-logo">
    <b>Verifikasi Akun Layanan Mandiri</b>
  </div>
  <!-- /.login-logo -->

<div class="card">
  <div class="card-body login-card-body ">
    @if (session('failed'))
      <div class="alert alert-danger"> {{ session('failed') }}</div>
    @endif

    <p class="login-box-msg">Mohon verifikasi akun Anda</p>
      <form action="{{ route('verifikasi.index') }}" method="post">
        @csrf
        <input type="hidden" value="register" name="type">
        <button type="submit" class="btn btn-sm btn-primary"> Kirim OTP via Email</button>

      </form>
    
    
  </div>
  <!-- /.login-card-body -->
</div>
</div>

<!-- /.login-box -->

<!-- jQuery -->
<script src="{{ asset('adminlte3/plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('adminlte3/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('adminlte3/dist/js/adminlte.min.js') }}"></script>

{{-- Skrip untuk icon password --}}
<script>
    $('.show-password').on('click', function(){
        if($('#password').attr('type') == 'password'){
            $('#password').attr('type', 'text');
            $('#password-lock').attr('class', 'fas fa-unlock');
        } else {
            $('#password').attr('type', 'password');
            $('#password-lock').attr('class', 'fas fa-lock');
        }
    })
</script>
</body>
</html>