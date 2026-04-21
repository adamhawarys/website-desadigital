<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Masuk Layanan Mandiri | Website Desa bengkel</title>

  <link href="{{asset('adminlte3/dist/img/logo-desa-bengkel.png')}}" rel="icon">
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('adminlte3/plugins/fontawesome-free/css/all.min.css')}}">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="{{asset('adminlte3/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('adminlte3/dist/css/adminlte.min.css')}}">
   <link rel="stylesheet" href="{{asset('adminlte3/dist/css/custom.css')}}">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href=""><b>Login Layanan Mandiri</b></a>
  </div>
  <!-- /.login-logo -->

  <div class="card">
    <div class="card-body login-card-body p-0">
      <div class="d-flex flex-column flex-md-row align-items-stretch">

        <!-- KIRI: LOGO & INFO DESA -->
        <div class="register-left text-white d-flex flex-column justify-content-center align-items-center p-4">
          <img src="{{asset('adminlte3/dist/img/logo-desa-bengkel.png')}}" alt="Logo Desa Bengkel" class="logo-desa mb-3">
          <h5 class="fw-bold text-center mb-2"><b>LAYANAN MANDIRI<br>DESA BENGKEL</b></h5>
          <p class="text-center small mb-0">
            Kecamatan Labuapi<br>
            Kabupaten Lombok Barat<br>
            Nusa Tenggara Barat<br>
           
          </p>
        </div>

        <!-- KANAN: FORM LOGIN ASLI -->
        <div class="register-right flex-grow-1 p-4">

          @if (session('failed'))
            <div class="alert alert-danger">{{ session('failed') }}</div>
          @endif

          <p class="login-box-msg">Sign in to start your session</p>

          <form action="{{ route('login_user') }}" method="post">
            @csrf
            @error('email')
              <small class="text-danger">{{ $message }}</small>
            @enderror
            <div class="input-group mb-3">
              <input type="email" name="email" class="form-control" placeholder="Masukkan Email" value="{{ old('email') }}">
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-envelope"></span>
                </div>
              </div>
            </div>

            @error('password')
              <small class="text-danger">{{ $message }}</small>
            @enderror
            <div class="input-group mb-3">
              <input type="password" name="password" class="form-control" placeholder="Masukkan Password" id="password">
              <div class="input-group-append show-password">
                <div class="input-group-text ">
                  <span class="fas fa-lock" id="password-lock"></span>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-8">
                <div class="icheck-primary">
                  <input type="checkbox" name="remember" id="remember">
                  <label for="remember">
                    Remember Me
                  </label>
                </div>
              </div>
              <!-- /.col -->
              <div class="col-4">
                <button type="submit" class="btn btn-primary btn-block">Login</button>
              </div>
              <!-- /.col -->
            </div>
          </form>

          <div class="social-auth-links text-center mb-3">
            <p>- Atau -</p>
            
            <a href="{{ route('google_redirect') }}" class="btn btn-block btn-danger">
              <i class="fab fa-google mr-2"></i> Masuk menggunakan Google
            </a>
          </div>
          <!-- /.social-auth-links -->

          <p class="mb-1">
            <a href="{{ route('lupa_password') }}">Lupa password?</a>
          </p>
          <p class="mb-0">
            <a href="/register" class="text-center">Registrasi akun</a>
          </p>

        </div>
        <!-- /KANAN -->

      </div>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>

<!-- /.login-box -->

<!-- jQuery -->
<script src="{{asset('adminlte3/plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script src="{{asset('adminlte3/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('adminlte3/dist/js/adminlte.min.js')}}"></script>

{{-- SKRIP u/ icon password --}}
<script>
    $('.show-password').on('click', function(){
        if($('#password').attr('type') == 'password'){
            $('#password').attr('type', 'text');
            $('#password-lock').attr('class', 'fas-fa-unlock');
        }else {
            $('#password').attr('type', 'password');
            $('#password-lock').attr('class', 'fas-fa-lock');
         }
    })
</script>
</body>
</html>
