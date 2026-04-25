<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{asset('adminlte3/index3.html')}}" class="brand-link">
      <img src="{{ Storage::disk('s3')->url('logo-desa/logo-desa-bengkel.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">{{config('app.name')}}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- SidebarSearch Form -->
      <div class="form-inline mt-2">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div><div class="sidebar-search-results"><div class="list-group"><a href="#" class="list-group-item"><div class="search-title"><strong class="text-light"></strong>N<strong class="text-light"></strong>o<strong class="text-light"></strong> <strong class="text-light"></strong>e<strong class="text-light"></strong>l<strong class="text-light"></strong>e<strong class="text-light"></strong>m<strong class="text-light"></strong>e<strong class="text-light"></strong>n<strong class="text-light"></strong>t<strong class="text-light"></strong> <strong class="text-light"></strong>f<strong class="text-light"></strong>o<strong class="text-light"></strong>u<strong class="text-light"></strong>n<strong class="text-light"></strong>d<strong class="text-light"></strong>!<strong class="text-light"></strong></div><div class="search-path"></div></a></div></div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item {{ $menuDashboard ?? '' }}">
            <a href="{{ route('dashboard') }}" class="nav-link ">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
           @if (auth()->user()->role == 'Admin')
          <li class="nav-item">
            <a href="{{ route('users.users') }}" class="nav-link">
              <i class="nav-icon fas fa-user"></i>
              <p>
                Users
              </p>
            </a>
          </li>
          @endif
          
          @if (in_array(auth()->user()->role, ['Admin']))
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-landmark"></i>
              <p>
                Info Desa
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview" style="display: none;">
              <li class="nav-item">
                <a href="{{ route('profil_desa') }}" class="nav-link">
                  
                  <p>Profil Desa</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('visimisi.index') }}" class="nav-link">
                  
                  <p>Visi & Misi</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('sejarah.index') }}" class="nav-link">
                  
                  <p>Sejarah Desa</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('pegawai.index') }}" class="nav-link">
                  
                  <p>Perangkat Desa</p>
                </a>
              </li>
            </ul>
          </li>
          @endif

          @if (in_array(auth()->user()->role, ['Admin', 'Petugas']))
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Kependudukan
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview" style="display: none;">
              <li class="nav-item">
                <a href="{{ route('penduduk.index') }}" class="nav-link">
                  
                  <p>Data Penduduk</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('statistik.index') }}" class="nav-link">
                  
                  <p>Statistik</p>
                </a>
              </li>
              
            </ul>
          </li>
          @endif
          @if (in_array(auth()->user()->role, ['Admin', 'Petugas']))
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-newspaper"></i>
              <p>
                Informasi
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview" style="display: none;">
              <li class="nav-item">
                <a href="{{ route('berita.index') }}" class="nav-link">
                  
                  <p>Berita</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('agenda.index') }}" class="nav-link">
                  
                  <p>Agenda</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('pengumuman.index') }}" class="nav-link">
                  
                  <p>Pengumuman</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('galeri.index') }}" class="nav-link">
                  
                  <p>Galeri</p>
                </a>
              </li>
            </ul>
          </li>
          @endif
          
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-envelope"></i>
              <p>
                Layanan Surat
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview" style="display: none;">
              @if (in_array(auth()->user()->role, ['Admin']))
              <li class="nav-item">
                <a href="{{ route('layanan.index') }}" class="nav-link">
                  
                  <p>Data Layanan</p>
                </a>
              </li>
              @endif
              @if (in_array(auth()->user()->role, ['Admin', 'Petugas']))
              <li class="nav-item">
                <a href="{{ route('pengajuan.index') }}" class="nav-link">
                  
                  <p>Data Pengajuan Surat</p>
                </a>
              </li>
              @endif
            </ul>
          </li>

          <li class="nav-item">
              <a href="{{ route('admin.pengaduan.index') }}" class="nav-link">
                  <i class="nav-icon fas fa-bullhorn"></i>
                  <p>
                      Pengaduan
                  </p>
              </a>
          </li>
          



        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>