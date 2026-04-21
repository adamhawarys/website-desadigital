<title>Profil | Layanan Mandiri Desa Bengkel</title>
@extends('layanan_mandiri.layout.app')

@section('section')
    <div class="page-title" data-aos="fade">
      
      <nav class="breadcrumbs">
        <div class="container">
          <ol>
            <li><a href="">Beranda</a></li>
            <li><a href="{{ route('profil') }}">Profil</a></li>
            <li class="current">Edit Profil</li>
          </ol>
        </div>
      </nav>
    </div><!-- End Page Title -->

<section id="profil" class="profil section light">
  <div class="container" data-aos="fade-up">

    @if(session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
      <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="row g-4">

      {{-- LEFT CARD --}}
      <div class="col-lg-3">
        @include('layanan_mandiri.sidebar')
      </div>

      {{-- RIGHT CONTENT --}}
      <div class="col-lg-9">

        {{-- FORM: Informasi Akun --}}
        <div class="card shadow-sm border-0 mb-4" style="border-radius:16px;">
          <div class="card-header bg-primary d-flex align-items-center justify-content-between">
            <div class="text-white fw-semibold">
              Edit Profil Akun
            </div>
            <a href="{{ route('profil') }}" class="btn btn-light">
              <i class="fas fa-arrow-left mr-2"></i> Kembali
            </a>
          </div>
          <div class="card-body p-4">

            <form action="{{ route('update_profil') }}" method="POST" autocomplete="off" enctype="multipart/form-data">
              @csrf

              <div class="row g-3">

                {{-- FOTO PROFIL --}}
                <div class="col-md-12 text-center mb-2">
                  <img 
                    src="{{ \App\Helpers\FotoHelper::url(auth()->user()->foto) }}" 
                    alt="Foto Profil" 
                    class="rounded-circle mb-2" 
                    width="100" 
                    height="100"
                    style="object-fit:cover;">
                                    
                  <div>
                    <label class="form-label d-block">Foto Profil</label>
                    <input 
                      type="file" 
                      name="foto" 
                      class="form-control @error('foto') is-invalid @enderror"
                      accept="image/jpg,image/jpeg,image/png"
                    >
                    @error('foto')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">Format: jpg, jpeg, png. Maks: 2MB</small>
                  </div>
                </div>

                {{-- NAMA --}}
                <div class="col-md-6">
                  <label class="form-label">Nama <span class="text-danger">*</span></label>
                  <input
                    type="text"
                    name="name"
                    class="form-control @error('name') is-invalid @enderror"
                    value="{{ old('name', auth()->user()->name) }}"
                    required
                  >
                  @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>

                {{-- EMAIL --}}
                <div class="col-md-6">
                  <label class="form-label">Email <span class="text-danger">*</span></label>
                  <input
                    type="email"
                    name="email"
                    class="form-control @error('email') is-invalid @enderror"
                    value="{{ old('email', auth()->user()->email) }}"
                    required
                  >
                  @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                  <small class="text-muted">Perubahan email dapat mempengaruhi status verifikasi.</small>
                </div>

                {{-- NO HP --}}
                <div class="col-md-6">
                  <label class="form-label">No HP</label>
                  <input
                    type="text"
                    name="no_hp"
                    class="form-control @error('no_hp') is-invalid @enderror"
                    value="{{ old('no_hp', auth()->user()->no_hp ?? '') }}"
                    placeholder="Contoh: 08xxxxxxxxxx"
                  >
                  @error('no_hp')
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
                Jika Anda mengubah email, Anda mungkin perlu melakukan verifikasi ulang.
              </div>
            </div>
          </div>
        </div>

      </div>

    </div>
  </div>
</section>

@endsection