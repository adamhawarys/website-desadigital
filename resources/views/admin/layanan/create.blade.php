<title>Dashboard | Tambah Layanan </title>
@extends('layout.master')

@section('content')
<div class="content-wrapper" style="min-height: 1002.4px;">

    {{-- HEADER --}}
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Tambah Layanan</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ url('dashboard') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active">Tambah Layanan</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    {{-- CONTENT --}}
    <section class="content">
        <div class="card">

            {{-- HEADER CARD --}}
            <div class="card-header bg-primary">
                <a href="{{ route('layanan.index') }}" 
                   class="btn btn-success btn-sm">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Kembali
                </a>
            </div>

            {{-- FORM --}}
            <form action="{{ route('layanan.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="card-body">
                    <div class="row">

                        {{-- Nama Layanan --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nama Layanan</label>
                                <input type="text"
                                       name="nama_layanan"
                                       class="form-control @error('nama_layanan') is-invalid @enderror"
                                       value="{{ old('nama_layanan') }}"
                                       required>

                                @error('nama_layanan')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        {{-- Kode Layanan --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Kode Layanan</label>
                                <input type="text"
                                       name="kode_layanan"
                                       id="kode_layanan"
                                       class="form-control @error('kode_layanan') is-invalid @enderror"
                                       value="{{ old('kode_layanan') }}"
                                       required>

                                @error('kode_layanan')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        {{-- Deskripsi --}}
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Deskripsi</label>
                                <textarea name="deskripsi"
                                          class="form-control @error('deskripsi') is-invalid @enderror"
                                          rows="4"
                                          placeholder="Masukkan deskripsi layanan...">{{ old('deskripsi') }}</textarea>

                                @error('deskripsi')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                    </div>
                </div>

                {{-- FOOTER --}}
                <div class="card-footer text-right">
                    <button class="btn btn-primary">
                        <i class="fas fa-save mr-2"></i>
                        Simpan
                    </button>
                </div>

            </form>

        </div>
    </section>

</div>
@endsection