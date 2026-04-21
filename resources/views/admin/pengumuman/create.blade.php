<title>Dashboard | Tambah Pengumuman</title>
@extends('layout.master')

@section('content')
<div class="content-wrapper"  style="min-height: 1002.4px;">

  <!-- Content Header -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Tambah Pengumuman</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            
            <li class="breadcrumb-item active">Tambah Pengumuman</li>
          </ol>
        </div>
      </div>
    </div>
  </section>

  <!-- Main Content -->
  <section class="content">
    <div class="container-fluid">

      <div class="card">
        <div class="card-header bg-primary">
            <a href="{{ route('pengumuman.index') }}" class="btn btn-success btn-sm">
                <i class="fas fa-arrow-left mr-2"></i> Kembali
            </a>
        
        </div>

        <form action="{{ route('pengumuman.store') }}" method="POST">
          @csrf

          <div class="card-body">

            <!-- Judul -->
            <div class="form-group">
              <label>Judul Pengumuman</label>
              <input type="text"
                     name="judul"
                     class="form-control @error('judul') is-invalid @enderror"
                     value="{{ old('judul') }}"
                     placeholder="Masukkan judul pengumuman">
              @error('judul')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <!-- Kategori -->
            <div class="form-group">
              <label>Kategori</label>
              <input type="text"
                     name="kategori"
                     class="form-control @error('kategori') is-invalid @enderror"
                     value="{{ old('kategori') }}"
                     placeholder="Contoh: Informasi, Pemberitahuan">
              @error('kategori')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <!-- Deskripsi -->
            <div class="form-group">
              <label>Deskripsi</label>
              <textarea name="deskripsi"
                        rows="5"
                        class="form-control @error('deskripsi') is-invalid @enderror"
                        placeholder="Isi pengumuman...">{{ old('deskripsi') }}</textarea>
              @error('deskripsi')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="row">

              <!-- Tanggal Mulai -->
              <div class="col-md-6">
                <div class="form-group">
                  <label>Tanggal Mulai</label>
                  <input type="date"
                         name="tanggal_mulai"
                         class="form-control @error('tanggal_mulai') is-invalid @enderror"
                         value="{{ old('tanggal_mulai') }}">
                  @error('tanggal_mulai')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>

              <!-- Tanggal Selesai -->
              <div class="col-md-6">
                <div class="form-group">
                  <label>Tanggal Selesai</label>
                  <input type="date"
                         name="tanggal_selesai"
                         class="form-control @error('tanggal_selesai') is-invalid @enderror"
                         value="{{ old('tanggal_selesai') }}">
                  @error('tanggal_selesai')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>

            </div>

            <!-- Status -->
            <div class="form-group">
              <label>Status</label>
              <select name="status"
                      class="form-control @error('status') is-invalid @enderror">
                <option value="">-- Pilih Status --</option>
                <option value="aktif" {{ old('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                <option value="berakhir" {{ old('status') == 'berakhir' ? 'selected' : '' }}>Berakhir</option>
              </select>
              @error('status')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

          </div>

          <div class="card-footer text-right">
           
            <button type="submit" class="btn btn-primary">
              <i class="fas fa-save mr-2"></i>Simpan 
            </button>
          </div>

        </form>
      </div>

    </div>
  </section>
</div>
@endsection
