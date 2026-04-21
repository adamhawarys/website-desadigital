<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Reset Password | Website Desa Bengkel</title>

  <link href="{{asset('adminlte3/dist/img/logo-desa-bengkel.png')}}" rel="icon">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="{{asset('adminlte3/plugins/fontawesome-free/css/all.min.css')}}">
  <link rel="stylesheet" href="{{asset('adminlte3/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
  <link rel="stylesheet" href="{{asset('adminlte3/dist/css/adminlte.min.css')}}">
  <link rel="stylesheet" href="{{asset('adminlte3/dist/css/custom.css')}}">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href=""><b>Reset Password</b></a>
  </div>

  <div class="card">
    <div class="card-body login-card-body p-0">
      <div class="d-flex flex-column flex-md-row align-items-stretch">

        <!-- KIRI -->
        <div class="register-left text-white d-flex flex-column justify-content-center align-items-center p-4">
          <img src="{{asset('adminlte3/dist/img/logo-desa-bengkel.png')}}" alt="Logo Desa Bengkel" class="logo-desa mb-3">
          <h5 class="fw-bold text-center mb-2"><b>LAYANAN MANDIRI<br>DESA BENGKEL</b></h5>
          <p class="text-center small mb-0">
            Kecamatan Labuapi<br>
            Kabupaten Lombok Barat<br>
            Nusa Tenggara Barat
          </p>
        </div>

        <!-- KANAN -->
        <div class="register-right flex-grow-1 p-4">

          @if(session('failed'))
            <div class="alert alert-danger">{{ session('failed') }}</div>
          @endif

          <p class="login-box-msg">Masukkan password baru kamu</p>

          <form action="{{ route('lupa_password.simpan', $unique_id) }}" method="POST">
            @csrf

            @error('password')
              <small class="text-danger">{{ $message }}</small>
            @enderror
            <div class="input-group mb-3">
              <input 
                type="password" 
                name="password" 
                id="password"
                class="form-control" 
                placeholder="Password Baru"
                required
              >
              <div class="input-group-append show-password">
                <div class="input-group-text">
                  <span class="fas fa-lock" id="password-lock"></span>
                </div>
              </div>
            </div>

            @error('confirm_password')
              <small class="text-danger">{{ $message }}</small>
            @enderror
            <div class="input-group mb-3">
              <input 
                type="password" 
                name="confirm_password"
                id="confirm_password"
                class="form-control" 
                placeholder="Konfirmasi Password Baru"
                required
              >
              <div class="input-group-append show-confirm-password">
                <div class="input-group-text">
                  <span class="fas fa-lock" id="confirm-password-lock"></span>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-12">
                <button type="submit" class="btn btn-primary btn-block">Simpan Password</button>
              </div>
            </div>
          </form>

        </div>

      </div>
    </div>
  </div>
</div>

<script src="{{asset('adminlte3/plugins/jquery/jquery.min.js')}}"></script>
<script src="{{asset('adminlte3/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('adminlte3/dist/js/adminlte.min.js')}}"></script>

<script>
  $('.show-password').on('click', function(){
    if($('#password').attr('type') == 'password'){
      $('#password').attr('type', 'text');
      $('#password-lock').attr('class', 'fas fa-unlock');
    } else {
      $('#password').attr('type', 'password');
      $('#password-lock').attr('class', 'fas fa-lock');
    }
  });

  $('.show-confirm-password').on('click', function(){
    if($('#confirm_password').attr('type') == 'password'){
      $('#confirm_password').attr('type', 'text');
      $('#confirm-password-lock').attr('class', 'fas fa-unlock');
    } else {
      $('#confirm_password').attr('type', 'password');
      $('#confirm-password-lock').attr('class', 'fas fa-lock');
    }
  });
</script>
</body>
</html>