@extends('layout.master')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <h1>Edit Statistik Dusun</h1>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">

            <div class="card">
                <div class="card-body">

                    <form action="{{ route('statistik.update', $statistik->id) }}" method="POST">
                        @csrf
                        

                        {{-- Nama Dusun --}}
                        <div class="form-group">
                            <label>Nama Dusun</label>
                            <input type="text"
                                   name="nama_dusun"
                                   class="form-control @error('nama_dusun') is-invalid @enderror"
                                   value="{{ old('nama_dusun', $statistik->nama_dusun) }}"
                                   required>
                            @error('nama_dusun')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Nama Kepala Dusun --}}
                        <div class="form-group">
                            <label>Nama Kepala Dusun</label>
                            <input type="text"
                                   name="nama_kepala_dusun"
                                   class="form-control @error('nama_kepala_dusun') is-invalid @enderror"
                                   value="{{ old('nama_kepala_dusun', $statistik->nama_kepala_dusun) }}"
                                   required>
                            @error('nama_kepala_dusun')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Jumlah Laki-laki --}}
                        <div class="form-group">
                            <label>Jumlah Laki-laki</label>
                            <input type="number"
                                   name="jumlah_laki_laki"
                                   class="form-control @error('jumlah_laki_laki') is-invalid @enderror"
                                   value="{{ old('jumlah_laki_laki', $statistik->jumlah_laki_laki) }}"
                                   min="0"
                                   required>
                            @error('jumlah_laki_laki')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Jumlah Perempuan --}}
                        <div class="form-group">
                            <label>Jumlah Perempuan</label>
                            <input type="number"
                                   name="jumlah_perempuan"
                                   class="form-control @error('jumlah_perempuan') is-invalid @enderror"
                                   value="{{ old('jumlah_perempuan', $statistik->jumlah_perempuan) }}"
                                   min="0"
                                   required>
                            @error('jumlah_perempuan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Jumlah Penduduk (otomatis, tidak disimpan) --}}
                        <div class="form-group">
                            <label>Jumlah Penduduk</label>
                            <input type="number"
                                   class="form-control"
                                   value="{{ $statistik->jumlah_laki_laki + $statistik->jumlah_perempuan }}"
                                   readonly>
                            <small class="text-muted">
                                *Jumlah penduduk dihitung otomatis (L + P)
                            </small>
                        </div>

                        {{-- Tombol --}}
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                Update
                            </button>
                            <a href="{{ route('statistik.index') }}" class="btn btn-secondary">
                                Kembali
                            </a>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </section>
</div>
@endsection
