<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Verifikasi Akun | Website Desa Bengkel</title>

  <link href="{{ asset('adminlte3/dist/img/logo-desa-bengkel.png') }}" rel="icon">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="{{ asset('adminlte3/plugins/fontawesome-free/css/all.min.css') }}">
  <link rel="stylesheet" href="{{ asset('adminlte3/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('adminlte3/dist/css/adminlte.min.css') }}">
  <link rel="stylesheet" href="{{ asset('adminlte3/dist/css/custom.css') }}">
</head>
<body class="hold-transition login-page">
<div class="login-boxx">
  <div class="login-logo">
    <b>Verifikasi Akun Layanan Mandiri</b>
  </div>

  <div class="card">
    <div class="card-body login-card-body">

      {{-- Pesan error --}}
      @if (session('failed'))
        <div class="alert alert-danger">
          <i class="fas fa-times-circle mr-1"></i> {{ session('failed') }}
        </div>
      @endif

      {{-- Pesan sukses --}}
      @if (session('success'))
        <div class="alert alert-success">
          <i class="fas fa-check-circle mr-1"></i> {{ session('success') }}
        </div>
      @endif

      <p class="login-box-msg">Mohon verifikasi akun Anda</p>

      <form action="{{ route('verifikasi.index') }}" method="post">
        @csrf
        <input type="hidden" value="register" name="type">
        <button type="submit" class="btn btn-sm btn-primary">
          <i class="fas fa-envelope mr-1"></i> Kirim OTP via Email
        </button>
      </form>

    </div>
  </div>
</div>

<script src="{{ asset('adminlte3/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('adminlte3/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('adminlte3/dist/js/adminlte.min.js') }}"></script>
</body>
</html>