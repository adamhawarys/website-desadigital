<header id="header" class="header sticky-top">

    <div class="branding d-flex align-items-center">

      <div class="container position-relative d-flex align-items-center justify-content-between">
        <a href="{{ route('welcome') }}" class="logo d-flex align-items-center me-auto">
          <img src="{{ Storage::disk('s3')->url('logo-desa/logo-desa-bengkel.png') }}" alt="Logo Desa Bengkel">
          <h1 class="sitename">Desa Bengkel</h1>
        </a>

        <nav id="navmenu" class="navmenu">
          <ul>
            <li><a href="{{ route('layanan_mandiri') }}">Beranda</a></li>
            <li><a href="{{ route('profil') }}">Profil</a></li>
            <li><a href="{{ route('layanan_mandiri.layanan') }}">Daftar Layanan</a></li>

            <li class="nav-item dropdown user-menu">
              <a href="#" class="nav-link dropdown-toggle d-flex align-items-center gap-2" data-bs-toggle="dropdown">
                  <img 
                      src="{{ \App\Helpers\FotoHelper::url(auth()->user()->foto) }}"
                      alt="Foto Profil" 
                      class="rounded-circle" 
                      width="40" 
                      height="40"
                      style="object-fit:cover;">
                  
                  <span class="fw-semibold text-dark">{{ auth()->user()->name }}</span>
              </a>

              <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 rounded-3 p-2" style="min-width: 200px;">
                <li class="text-center mb-2">
                  <img 
                    src="{{ \App\Helpers\FotoHelper::url(auth()->user()->foto) }}" 
                    alt="Foto Profil" 
                    class="rounded-circle mb-2" 
                    width="70" 
                    height="70"
                    style="object-fit:cover;">
                  
                  <p class="mb-0 fw-bold text-dark">{{ auth()->user()->name }}</p>
                </li>

                <li><hr class="dropdown-divider"></li>

                <li>
                  <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-danger w-100">
                        Logout
                    </button>
                  </form>
                </li>
              </ul>
            </li>

            <!-- ✅ FIX DI SINI (mobile logout) -->
            <li class="d-block d-xl-none mt-2">
              <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="text-danger fw-semibold d-flex align-items-center justify-content-center border-0 bg-transparent w-100">
                  <i class="fas fa-sign-out-alt me-2"></i> Keluar
                </button>
              </form>
            </li>

          </ul>
          <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
        </nav>

      </div>

    </div>

</header>