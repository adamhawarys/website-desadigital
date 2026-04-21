<title>Dashboard | Upload Galeri</title>
@extends('layout.master')

@section('content')
<div class="content-wrapper" style="min-height: 1202.4px;">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Upload Foto Galeri</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('galeri.index') }}">Galeri</a></li>
                        <li class="breadcrumb-item active">Upload Foto</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="card">
            <div class="card-header bg-primary">
                <a href="{{ route('galeri.index') }}" class="btn btn-success btn-sm">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali
                </a>
            </div>

            <form action="{{ route('galeri.store') }}" method="post" enctype="multipart/form-data">
                @csrf

                <div class="card-body">
                    <div class="row">

                        {{-- Foto (Wajib) --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Foto <span class="text-danger">*</span></label>
                                <input type="file" name="foto" class="form-control" required>
                                @error('foto')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        {{-- Status (Wajib) --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Status <span class="text-danger">*</span></label>
                                <select name="status" class="form-control @error('status') is-invalid @enderror" required>
                                    <option value="aktif" selected>Aktif</option>
                                    <option value="nonaktif">Nonaktif</option>
                                </select>
                                @error('status')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        {{-- Judul (Opsional) --}}
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Judul Foto <small class="text-muted">(Opsional)</small></label>
                                <input type="text" name="judul" class="form-control" placeholder="Masukkan judul foto jika ada...">
                                @error('judul')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        {{-- Deskripsi (Opsional) --}}
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Deskripsi <small class="text-muted">(Opsional)</small></label>
                                <textarea name="deskripsi" class="form-control" rows="4" placeholder="Tulis keterangan atau cerita singkat tentang foto ini..."></textarea>
                                @error('deskripsi')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                    </div>
                </div>

                <div class="card-footer text-right">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save mr-2"></i>Simpan 
                    </button>
                </div>
            </form>
        </div>
    </section>
</div>
@endsection