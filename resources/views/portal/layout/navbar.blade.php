<header id="header" class="header sticky-top">

    <div class="topbar d-flex align-items-center">
      <div class="container d-flex justify-content-center justify-content-md-between">
        <div class="contact-info d-flex align-items-center">
          <i class="bi bi-envelope d-flex align-items-center"><a href="mailto:desadigital192@gmail.com">desadigital192@gmail.com</a></i>
          <i class="bi bi-phone d-flex align-items-center ms-4"><span>0818366698, 087701047211</span></i>
        </div>
        {{-- <div class="social-links d-none d-md-flex align-items-center">
          <a href="#" class="twitter"><i class="bi bi-twitter-x"></i></a>
          <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
          <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
          <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
        </div> --}}
      </div>
    </div><!-- End Top Bar -->

    <div class="branding d-flex align-items-center">

      <div class="container position-relative d-flex align-items-center justify-content-between">
        <a href="{{ route('welcome') }}" class="logo d-flex align-items-center me-auto">
          <!-- Uncomment the line below if you also wish to use an image logo -->
          <img src="{{ Storage::disk('s3')->url('logo-desa/logo-desa-bengkel.png') }}" alt=""> 
          <h1 class="sitename">Desa Bengkel</h1>
        </a>

        <nav id="navmenu" class="navmenu">
          <ul>
            <li class="dropdown"><a href="#"><span>Profil Desa</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
              <ul>
                <li><a href="{{ route('visimisi') }}">Visi & Misi</a></li>
                <li><a href="{{ route('sejarah') }}">Sejarah Desa</a></li>
                {{-- <li><a href="#">Dropdown 4</a></li> --}}
              </ul>
            </li>
            <li class="dropdown"><a href="#"><span>Pemerintahan</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
              <ul>
                <li><a href="{{ route('organisasi') }}">Struktur Organisasi</a></li>
                <li><a href="{{ route('pegawai') }}">Perangkat Desa</a></li>
                {{-- <li><a href="#">Dropdown 4</a></li> --}}
              </ul>
            </li>
            <li class="dropdown"><a href="#"><span>Informasi</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
              <ul>
                <li><a href="{{ route('agenda') }}">Agenda</a></li>
                <li><a href="{{ route('berita') }}">Berita</a></li>
                <li><a href="{{ route('pengumuman') }}">Pengumuman</a></li>
                {{-- <li><a href="{{ route('statistik') }}">Statistik Desa/<a></li> --}}
              </ul>
            </li>
            <li><a href="{{ route('layanan') }}" >Layanan<br></a></li>
            <li><a href="{{ route('galeri') }}">Galeri</a></li>
          </ul>
          <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
        </nav>

        <a class="cta-btn d-none d-sm-block" href="#" data-bs-toggle="modal" data-bs-target="#modalPengaduan">
    <i class="bi bi-megaphone-fill me-1"></i> Pengaduan
</a>

      </div>

    </div>

  </header>

  @include('pengaduan.modal')