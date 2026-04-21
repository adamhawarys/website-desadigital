<title>Dashboard | Tambah Perangkat Desa</title>
@extends('layout.master')

@section('content')
<div class="content-wrapper" style="min-height: 902.4px;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Tambah Perangkat Desa</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('pegawai.index') }}">Perangkat Desa</a></li>
              <li class="breadcrumb-item active">Tambah Perangkat Desa</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Default box -->
      <div class="card">
        <div class="card-header bg-primary">
          <a href="{{ route('pegawai.index') }}" class="btn btn-sm btn-success">
            <i class="fas fa-arrow-left mr-2"></i>
            Kembali
          </a>
        </div>


        <form action="{{ route('pegawai.store') }}" method="POST" enctype="multipart/form-data">
          @csrf
        <div class="card-body">
            <div class="row">
                <!-- Foto -->
            <div class="col-md-6">
              <div class="form-group">
                <label class="form-label">Foto:</label>
                <input type="file" name="foto" class="form-control @error('foto') is-invalid @enderror">
                @error('foto')
                  <small class="text-danger">{{ $message }}</small>
                @enderror
              </div>
            </div>

            <!-- Nama Pejabat -->
            <div class="col-md-6">
              <div class="form-group">
                <label class="form-label"><span class="text-danger">*</span> Nama Pejabat:</label>
                <input type="text" name="nama_pejabat" class="form-control @error('nama_pejabat') is-invalid @enderror" value="{{ old('nama_pejabat') }}">
                @error('nama_pejabat')
                  <small class="text-danger">{{ $message }}</small>
                @enderror
              </div>
            </div>

            {{-- Jabatan --}}
            <div class="col-md-6">  
              <div class="form-group">
                <label class="form-label"><span class="text-danger">*</span> Jabatan:</label>
                <input type="text" name="jabatan" class="form-control @error('jabatan') is-invalid @enderror" value="{{ old('jabatan') }}">
                @error('jabatan')
                  <small class="text-danger">{{ $message }}</small>
                @enderror
              </div>
            </div>

            <!-- Jenis Kelamin -->
            <div class="col-md-6">
              <div class="form-group">
                <label class="form-label"><span class="text-danger">*</span> Jenis Kelamin:</label>
                <select name="jenis_kelamin" class="form-control @error('jenis_kelamin') is-invalid @enderror">
                  <option value="" selected disabled>-- Pilih Jenis Kelamin --</option>
                  <option value="Laki-Laki" {{ old('jenis_kelamin') == 'Laki-Laki' ? 'selected' : '' }}>Laki-Laki</option>
                  <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                </select>
                @error('jenis_kelamin')
                  <small class="text-danger">{{ $message }}</small>
                @enderror
              </div>
            </div>

            <!-- Tempat dan Tanggal Lahir -->
            <div class="col-md-6">
              <div class="form-group">
                <label class="form-label"><span class="text-danger">*</span> Tempat Lahir:</label>
                <input type="text" name="tempat_lahir" class="form-control @error('tempat_lahir') is-invalid @enderror" value="{{ old('tempat_lahir') }}">
                @error('tempat_lahir')
                  <small class="text-danger">{{ $message }}</small>
                @enderror
              </div>
            </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label class="form-label"><span class="text-danger">*</span> Tanggal Lahir:</label>
                  <input type="date" name="tanggal_lahir" class="form-control @error('tanggal_lahir') is-invalid @enderror" value="{{ old('tanggal_lahir') }}">
                  @error('tanggal_lahir')
                    <small class="text-danger">{{ $message }}</small>
                  @enderror
                </div>
              </div>

            <!-- Pendidikan and Nomor SK -->
            <div class="col-md-6">
              <div class="form-group">
                <label class="form-label"><span class="text-danger">*</span> Pendidikan:</label>
                <input type="text" name="pendidikan" class="form-control @error('pendidikan') is-invalid @enderror" value="{{ old('pendidikan') }}">
                @error('pendidikan')
                  <small class="text-danger">{{ $message }}</small>
                @enderror
              </div>
            </div>
            
            <div class="col-md-6">    
              <div class="form-group">
                <label class="form-label"><span class="text-danger">*</span> Nomor SK:</label>
                <input type="text" name="nomor_sk" class="form-control @error('nomor_sk') is-invalid @enderror" value="{{ old('nomor_sk') }}">
                @error('nomor_sk')
                  <small class="text-danger">{{ $message }}</small>
                @enderror
              </div>
            </div>

            <!-- Tanggal SK -->
            <div class="col-md-6">
              <div class="form-group">
                <label class="form-label"><span class="text-danger">*</span> Tanggal SK:</label>
                <input type="date" name="tanggal_sk" class="form-control @error('tanggal_sk') is-invalid @enderror" value="{{ old('tanggal_sk') }}">
                @error('tanggal_sk')
                  <small class="text-danger">{{ $message }}</small>
                @enderror
              </div>
            </div>

            <!-- Alamat -->
            <div class="col-md-12">
              <div class="form-group">
                <label class="form-label">Alamat:</label>
                <textarea name="alamat" class="form-control @error('alamat') is-invalid @enderror">{{ old('alamat') }}</textarea>
                @error('alamat')
                  <small class="text-danger">{{ $message }}</small>
                @enderror
              </div>
            </div>
            </div>
              
            </div>
            
            <!-- Submit Button -->
            <div class="card-footer text-right">
                    <button type="submit" class="btn btn-sm btn-primary">
                        <i class="fas fa-save mr-2"></i> Simpan
                    </button>
                </div>
              </div>
            </form>
    </section>

</div>
@endsection
