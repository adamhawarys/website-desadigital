<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title></title>
  <meta name="description" content="">
  <meta name="keywords" content="">

 <!-- Favicons -->
<link href="{{ Storage::disk('s3')->url('logo-desa/logo-desa-bengkel.png') }}" rel="icon">
<link href="{{ asset('assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

<!-- Vendor CSS Files -->
<link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
<link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
<link href="{{ asset('assets/vendor/aos/aos.css') }}" rel="stylesheet">
<link href="{{ asset('assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
<link href="{{ asset('assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
<link href="{{ asset('assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">

<!-- Main CSS File -->
<link href="{{ asset('assets/css/main.css') }}" rel="stylesheet">

  

  <!-- =======================================================
  * Template Name: Medilab
  * Template URL: https://bootstrapmade.com/medilab-free-medical-bootstrap-theme/
  * Updated: Aug 07 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body class="starter-page-page">

  @include('portal.layout.navbar')

  <main class="main">
    
    <!-- Page Title -->
    
    <!-- End Page Title -->

    <!-- Starter Section Section -->
    @yield('section')
    <!-- /Starter Section Section -->

  </main>

  <footer id="footer" class="footer light-background">

      <div class="container footer-top">
        <div class="row gy-4">

          {{-- Kolom 1: Tentang Desa --}}
          <div class="col-lg-4 col-md-6 footer-about">
            <a href="{{ route('welcome') }}" class="logo d-flex align-items-center">
              <span class="sitename">Desa Bengkel</span>
            </a>
            <div class="footer-contact pt-3">
              <p>Jl. TGH. Shaleh Hambali No:10.</p>
              <p>Desa Bengkel, Kecamatan Labuapi, Kabupaten Lombok Barat, Kode Pos 83361</p>
              <p class="mt-3"><strong>Phone:</strong> <span>0818366698, 087701047211</span></p>
              <p><strong>Email:</strong> <span>desadigital192@gmail.com</span></p>
            </div>
            {{-- <div class="social-links d-flex mt-4">
              <a href=""><i class="bi bi-twitter-x"></i></a>
              <a href=""><i class="bi bi-facebook"></i></a>
              <a href=""><i class="bi bi-instagram"></i></a>
              <a href=""><i class="bi bi-linkedin"></i></a>
            </div> --}}
          </div>

          {{-- Kolom 2: Tautan Cepat --}}
          <div class="col-lg-2 col-md-3 footer-links">
            <h4>Tautan Cepat</h4>
            <ul>
              <li><a href="{{ route('welcome') }}">Beranda</a></li>
              <li><a href="{{ route('visimisi') }}">Visi &amp; Misi</a></li>
              <li><a href="{{ route('pegawai') }}">Perangkat Desa</a></li>
              <li><a href="{{ route('berita') }}">Berita</a></li>
              <li><a href="{{ route('pengumuman') }}">Pengumuman</a></li>
            </ul>
          </div>

          {{-- Kolom 3: Layanan --}}
          <div class="col-lg-2 col-md-3 footer-links">
            <h4>Layanan</h4>
            <ul>
              <li><a href="{{ route('layanan') }}">Daftar Layanan</a></li>
              <li><a href="{{ route('login_user') }}">Layanan Mandiri</a></li>
              <li><a href="#pengaduan" data-bs-toggle="modal" data-bs-target="#modalPengaduan">Pengaduan</a></li>
            </ul>
          </div>

          {{-- Kolom 4: Visitor Counter --}}
          <div class="col-lg-4 col-md-6 footer-links">
            <h4>Statistik Pengunjung</h4>
            <div class="p-3 rounded text-white mt-2" style="background-color: #1977cc;">
              <div class="text-center py-2">
                <div class="fw-semibold">Total Visitor Hari Ini</div>
                <hr class="border-white border-opacity-25 my-2">
                <div>{{ $visitorHariIni ?? 0 }} Visitor</div>
              </div>
              <div class="text-center py-2">
                <div class="fw-semibold">Total Visitor Sepanjang Waktu</div>
                <hr class="border-white border-opacity-25 my-2">
                <div>{{ $visitorTotal ?? 0 }} Visitor</div>
              </div>
            </div>
          </div>

        </div>
      </div>

      <div class="container copyright text-center mt-4">
        <p>© <span>{{ date('Y') }}</span> <strong class="px-1 sitename">Desa Digital</strong> <span>All Rights Reserved</span></p>
      </div>

  </footer>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Preloader -->
  <div id="preloader"></div>

  <!-- Vendor JS Files -->
<script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/vendor/php-email-form/validate.js') }}"></script>
<script src="{{ asset('assets/vendor/aos/aos.js') }}"></script>
<script src="{{ asset('assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
<script src="{{ asset('assets/vendor/purecounter/purecounter_vanilla.js') }}"></script>
<script src="{{ asset('assets/vendor/swiper/swiper-bundle.min.js') }}"></script>

<!-- Main JS File -->
<script src="{{ asset('assets/js/main.js') }}"></script>


</body>

</html>