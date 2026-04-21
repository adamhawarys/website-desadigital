<title>Dashboard | Edit Profil Desa</title>
@extends('layout.master')

@section('content')
<div class="content-wrapper" style="min-height: 1002.4px;">

  <!-- Content Header -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Edit Profil Desa</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item">
              <a href="{{ route('dashboard') }}">Dashboard</a>
            </li>
            <li class="breadcrumb-item">
              <a href="{{ route('profil_desa') }}">Profil Desa</a>
            </li>
            <li class="breadcrumb-item active">Edit Profil Desa</li>
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
          <a href="{{ route('profil_desa') }}" class="btn btn-success btn-sm">
            <i class="fas fa-arrow-left mr-2"></i> Kembali
          </a>
        </div>

        <form action="{{ route('profil_desa.update', $profil->id) }}" method="POST" enctype="multipart/form-data">
          @csrf
          

          <div class="card-body">

            <!-- Nama Desa -->
            <div class="form-group">
              <label>Nama Desa</label>
              <input type="text"
                     name="nama_desa"
                     class="form-control @error('nama_desa') is-invalid @enderror"
                     value="{{ old('nama_desa', $profil->nama_desa) }}"
                     placeholder="Masukkan nama desa">
              @error('nama_desa')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <!-- Alamat Desa -->
            <div class="form-group">
              <label>Alamat Desa</label>
              <textarea name="alamat"
                        rows="3"
                        class="form-control @error('alamat') is-invalid @enderror"
                        placeholder="Masukkan alamat desa">{{ old('alamat', $profil->alamat) }}</textarea>
              @error('alamat')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="row">
              <!-- Kode Pos -->
              <div class="col-md-4">
                <div class="form-group">
                  <label>Kode Pos</label>
                  <input type="text"
                         name="kode_pos"
                         class="form-control @error('kode_pos') is-invalid @enderror"
                         value="{{ old('kode_pos', $profil->kode_pos) }}"
                         placeholder="Contoh: 83361">
                  @error('kode_pos')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>

              <!-- Kepala Desa -->
              <div class="col-md-4">
                <div class="form-group">
                  <label>Kepala Desa</label>
                  <input type="text"
                         name="kades"
                         class="form-control @error('kades') is-invalid @enderror"
                         value="{{ old('kades', $profil->kades) }}"
                         placeholder="Nama Kepala Desa">
                  @error('kades')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>

              <!-- Sekretaris Desa -->
              <div class="col-md-4">
                <div class="form-group">
                  <label>Sekretaris Desa</label>
                  <input type="text"
                         name="sekdes"
                         class="form-control @error('sekdes') is-invalid @enderror"
                         value="{{ old('sekdes', $profil->sekdes) }}"
                         placeholder="Nama Sekretaris Desa">
                  @error('sekdes')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>
            </div>

            <!-- Logo Desa -->
            <div class="form-group">
              <label>Logo Desa</label>
              <input type="file"
                     name="logo"
                     class="form-control @error('logo') is-invalid @enderror">
              @error('logo')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror

              @if ($profil->logo)
                <div class="mt-2">
                  <small class="text-muted d-block mb-1">Logo saat ini:</small>
                  <img src="{{ asset('storage/logo/'.$profil->logo) }}"
                       class="img-thumbnail"
                       width="120">
                </div>
              @endif
            </div>

          </div>

          <div class="card-footer text-right">
            <button type="submit" class="btn btn-primary">
              <i class="fas fa-save mr-2"></i> Simpan
            </button>
          </div>

        </form>
      </div>

    </div>
  </section>
</div>
@endsection
