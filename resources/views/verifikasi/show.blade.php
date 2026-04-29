<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Masukkan Kode OTP | Website Desa Bengkel</title>

  <link href="{{ asset('adminlte3/dist/img/logo-desa-bengkel.png') }}" rel="icon">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="{{ asset('adminlte3/plugins/fontawesome-free/css/all.min.css') }}">
  <link rel="stylesheet" href="{{ asset('adminlte3/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('adminlte3/dist/css/adminlte.min.css') }}">
  <link rel="stylesheet" href="{{ asset('adminlte3/dist/css/custom.css') }}">
</head>
<body class="hold-transition login-page">

<div class="login-box">
  <div class="login-logo">
    <a href=""><b>Verifikasi OTP</b></a>
  </div>

  <div class="card">
    <div class="card-body login-card-body p-0">
      <div class="d-flex flex-column flex-md-row align-items-stretch">

        <!-- KIRI: LOGO & INFO DESA -->
        <div class="register-left text-white d-flex flex-column justify-content-center align-items-center p-4">
          <img src="{{ asset('adminlte3/dist/img/logo-desa-bengkel.png') }}" alt="Logo Desa Bengkel" class="logo-desa mb-3">
          <h5 class="fw-bold text-center mb-2"><b>LAYANAN MANDIRI<br>DESA BENGKEL</b></h5>
          <p class="text-center small mb-0">
            Kecamatan Labuapi<br>
            Kabupaten Lombok Barat<br>
            Nusa Tenggara Barat
          </p>
        </div>

        <!-- KANAN: FORM OTP -->
        <div class="register-right flex-grow-1 p-4">

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

          <p class="login-box-msg">
            Masukkan kode OTP yang telah dikirim ke email Anda.<br>
            <small class="text-muted">Kode berlaku selama <strong id="countdown">5:00</strong></small>
          </p>

          <form action="/verify/{{ $unique_id }}" method="post">
            @method('PUT')
            @csrf

            <div class="input-group mb-3">
              <input type="number" name="otp" class="form-control" placeholder="Masukkan Kode OTP" autofocus>
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-key"></span>
                </div>
              </div>
            </div>

            <div class="row mb-3">
              <div class="col-4">
                <button type="submit" class="btn btn-primary btn-block">Verifikasi</button>
              </div>
            </div>
          </form>

          <p class="mb-0 text-center">
            OTP kedaluwarsa? 
            <a href="{{ route('verifikasi.index') }}">Kirim ulang OTP</a>
          </p>

        </div>
        <!-- /KANAN -->

      </div>
    </div>
  </div>
</div>

<script src="{{ asset('adminlte3/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('adminlte3/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('adminlte3/dist/js/adminlte.min.js') }}"></script>

{{-- Countdown 5 menit --}}
<script>
  let totalSeconds = 5 * 60;

  const countdownEl = document.getElementById('countdown');

  const timer = setInterval(function () {
    totalSeconds--;

    const minutes = Math.floor(totalSeconds / 60);
    const seconds = totalSeconds % 60;

    countdownEl.textContent = minutes + ':' + (seconds < 10 ? '0' : '') + seconds;

    if (totalSeconds <= 0) {
      clearInterval(timer);
      countdownEl.textContent = '0:00';
      countdownEl.classList.add('text-danger');
      // Tampilkan pesan expired
      document.querySelector('.login-box-msg').innerHTML =
        '<span class="text-danger"><i class="fas fa-exclamation-circle"></i> OTP kedaluwarsa. Silakan <a href="{{ route("verifikasi.index") }}">kirim ulang</a>.</span>';
    }
  }, 1000);
</script>

</body>
</html>