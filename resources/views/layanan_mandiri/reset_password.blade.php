<title>Ganti Password | Layanan Mandiri Desa Bengkel</title>
@extends('layanan_mandiri.layout.app')

@section('section')
    <div class="page-title" data-aos="fade">
      
      <nav class="breadcrumbs">
        <div class="container">
          <ol>
            <li><a href="">Beranda</a></li>
            <li><a href="{{ route('profil') }}">Profil</a></li>
            <li class="current">Ganti Password</li>
          </ol>
        </div>
      </nav>
    </div>

<section id="profil" class="profil section light">
  <div class="container" data-aos="fade-up">

    @if(session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('failed'))
      <div class="alert alert-danger">{{ session('failed') }}</div>
    @endif

    <div class="row g-4">

      {{-- LEFT CARD --}}
      <div class="col-lg-3">
        @include('layanan_mandiri.sidebar')
      </div>

      {{-- RIGHT CONTENT --}}
      <div class="col-lg-9">

        {{-- FORM --}}
        <div class="card shadow-sm border-0 mb-4" style="border-radius:16px;">
          <div class="card-header bg-primary d-flex align-items-center justify-content-between">
            <div class="text-white fw-semibold">
              Ganti Password
            </div>
            <a href="{{ route('profil') }}" class="btn btn-light">
              <i class="fas fa-arrow-left mr-2"></i> Kembali
            </a>
          </div>
          <div class="card-body p-4">

            <form action="{{ route('reset_password.proses') }}" method="POST" autocomplete="off">
              @csrf

              <div class="row g-3">

                {{-- PASSWORD LAMA --}}
                <div class="col-md-12">
                  <label class="form-label">Password Lama <span class="text-danger">*</span></label>
                  <input
                    type="password"
                    name="password_lama"
                    class="form-control @error('password_lama') is-invalid @enderror"
                    placeholder="Masukkan password lama"
                    required
                  >
                  @error('password_lama')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>

                {{-- PASSWORD BARU --}}
                <div class="col-md-6">
                  <label class="form-label">Password Baru <span class="text-danger">*</span></label>
                  <input
                    type="password"
                    name="password"
                    class="form-control @error('password') is-invalid @enderror"
                    placeholder="Masukkan password baru"
                    required
                  >
                  @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>

                {{-- KONFIRMASI PASSWORD --}}
                <div class="col-md-6">
                  <label class="form-label">Konfirmasi Password Baru <span class="text-danger">*</span></label>
                  <input
                    type="password"
                    name="confirm_password"
                    class="form-control @error('confirm_password') is-invalid @enderror"
                    placeholder="Ulangi password baru"
                    required
                  >
                  @error('confirm_password')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>

              </div>

              <hr class="my-4">

              <div class="d-flex justify-content-end gap-2">
                <button type="submit" class="btn btn-primary">
                  <i class="fas fa-save me-1"></i> Simpan
                </button>
              </div>

            </form>
          </div>
        </div>

        {{-- INFO BOX --}}
        <div class="alert alert-info border-0" style="border-radius:14px;background:#eaf5ff;">
          <div class="d-flex">
            <i class="bi bi-info-circle me-2"></i>
            <div>
              <div class="fw-semibold">Catatan</div>
              <div class="small">
                Pastikan password baru minimal 8 karakter.
              </div>
            </div>
          </div>
        </div>

      </div>

    </div>
  </div>
</section>

@endsection