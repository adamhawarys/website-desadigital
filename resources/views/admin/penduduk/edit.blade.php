<title>Dashboard | Edit Data Penduduk</title>
@extends('layout.master')

@php
$agamaOptions          = ['Islam','Kristen','Katolik','Hindu','Buddha','Konghucu'];
$pendidikanOptions     = ['Tidak/Belum Sekolah','Belum Tamat SD','Tamat SD','SLTP','SLTA','D1/D2','D3','S1','S2','S3'];
$statusKawinOptions    = ['Belum Kawin','Kawin','Cerai Hidup','Cerai Mati'];
$golDarahOptions       = ['A','B','AB','O','-'];
$shdkOptions           = ['Kepala Keluarga','Istri','Anak','Menantu','Cucu','Orang Tua','Mertua','Famili Lain','Pembantu','Lainnya'];
@endphp

@section('content')
<div class="content-wrapper">

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6"><h1>Edit Data Penduduk</h1></div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('penduduk.index') }}">Data Penduduk</a></li>
                        <li class="breadcrumb-item active">Edit Data Penduduk</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="card">

            <div class="card-header bg-primary">
                <a href="{{ route('penduduk.index') }}" class="btn btn-sm btn-success">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali
                </a>
            </div>

            <form action="{{ route('penduduk.update', $penduduk->id) }}" method="POST">
                @csrf
                
                <div class="card-body">
                    <div class="row">

                        {{-- ===== KIRI ===== --}}
                        <div class="col-md-6">

                            <div class="form-group">
                                <label>NIK <span class="text-danger">*</span></label>
                                <input type="text" name="nik" maxlength="16"
                                    class="form-control @error('nik') is-invalid @enderror"
                                    value="{{ old('nik', $penduduk->nik) }}">
                                @error('nik')<small class="text-danger">{{ $message }}</small>@enderror
                            </div>

                            <div class="form-group">
                                <label>Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" name="nama_lengkap" maxlength="100"
                                    class="form-control @error('nama_lengkap') is-invalid @enderror"
                                    value="{{ old('nama_lengkap', $penduduk->nama_lengkap) }}">
                                @error('nama_lengkap')<small class="text-danger">{{ $message }}</small>@enderror
                            </div>

                            <div class="form-group">
                                <label>Jenis Kelamin <span class="text-danger">*</span></label>
                                <select name="jenis_kelamin" class="form-control @error('jenis_kelamin') is-invalid @enderror">
                                    <option value="" disabled>-- Pilih --</option>
                                    <option value="L" {{ old('jenis_kelamin', $penduduk->jenis_kelamin) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="P" {{ old('jenis_kelamin', $penduduk->jenis_kelamin) == 'P' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                                @error('jenis_kelamin')<small class="text-danger">{{ $message }}</small>@enderror
                            </div>

                            <div class="form-group">
                                <label>No KK</label>
                                <input type="text" name="kk" maxlength="16"
                                    class="form-control" value="{{ old('kk', $penduduk->kk) }}">
                            </div>

                            <div class="form-group">
                                <label>Tempat Lahir</label>
                                <input type="text" name="tempat_lahir" maxlength="50"
                                    class="form-control" value="{{ old('tempat_lahir', $penduduk->tempat_lahir) }}">
                            </div>

                            <div class="form-group">
                                <label>Tanggal Lahir</label>
                                <input type="date" name="tanggal_lahir" class="form-control"
                                    value="{{ old('tanggal_lahir', optional($penduduk->tanggal_lahir)->format('Y-m-d')) }}">
                            </div>

                            <div class="form-group">
                                <label>Agama</label>
                                <select name="agama" class="form-control">
                                    <option value="">-- Pilih --</option>
                                    @foreach($agamaOptions as $opt)
                                        <option value="{{ $opt }}"
                                            {{ old('agama', $penduduk->agama) == $opt ? 'selected' : '' }}>
                                            {{ $opt }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Pendidikan</label>
                                <select name="pendidikan" class="form-control">
                                    <option value="">-- Pilih --</option>
                                    @foreach($pendidikanOptions as $opt)
                                        <option value="{{ $opt }}"
                                            {{ old('pendidikan', $penduduk->pendidikan) == $opt ? 'selected' : '' }}>
                                            {{ $opt }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Kewarganegaraan</label>
                                <input type="text" name="kewarganegaraan" maxlength="30"
                                    class="form-control"
                                    value="{{ old('kewarganegaraan', $penduduk->kewarganegaraan ?? 'Indonesia') }}">
                            </div>

                            <div class="form-group">
                                <label>Pekerjaan</label>
                                <input type="text" name="pekerjaan" maxlength="50"
                                    class="form-control" value="{{ old('pekerjaan', $penduduk->pekerjaan) }}">
                            </div>

                        </div>

                        {{-- ===== KANAN ===== --}}
                        <div class="col-md-6">

                            <div class="form-group">
                                <label>Status Perkawinan</label>
                                <select name="status_perkawinan" class="form-control">
                                    <option value="">-- Pilih --</option>
                                    @foreach($statusKawinOptions as $opt)
                                        <option value="{{ $opt }}"
                                            {{ old('status_perkawinan', $penduduk->status_perkawinan) == $opt ? 'selected' : '' }}>
                                            {{ $opt }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Golongan Darah</label>
                                <select name="gol_darah" class="form-control">
                                    <option value="">-- Pilih --</option>
                                    @foreach($golDarahOptions as $opt)
                                        <option value="{{ $opt }}"
                                            {{ old('gol_darah', $penduduk->gol_darah) == $opt ? 'selected' : '' }}>
                                            {{ $opt }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Status Hubungan Dalam Keluarga (SHDK)</label>
                                <select name="shdk" class="form-control">
                                    <option value="">-- Pilih --</option>
                                    @foreach($shdkOptions as $opt)
                                        <option value="{{ $opt }}"
                                            {{ old('shdk', $penduduk->shdk) == $opt ? 'selected' : '' }}>
                                            {{ $opt }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Alamat</label>
                                <textarea name="alamat" class="form-control" rows="3">{{ old('alamat', $penduduk->alamat) }}</textarea>
                            </div>

                            <div class="form-group">
                                <label>RT</label>
                                <input type="text" name="rt" maxlength="3"
                                    class="form-control" value="{{ old('rt', $penduduk->rt) }}">
                            </div>

                            <div class="form-group">
                                <label>Dusun</label>
                                <input type="text" name="dusun" maxlength="50"
                                    class="form-control" value="{{ old('dusun', $penduduk->dusun) }}">
                            </div>

                            <div class="form-group">
                                <label>Desa</label>
                                <input type="text" name="desa" maxlength="50"
                                    class="form-control" value="{{ old('desa', $penduduk->desa) }}">
                            </div>

                            <div class="form-group">
                                <label>Kecamatan</label>
                                <input type="text" name="kecamatan" maxlength="50"
                                    class="form-control" value="{{ old('kecamatan', $penduduk->kecamatan) }}">
                            </div>

                            <div class="form-group">
                                <label>Nama Ayah</label>
                                <input type="text" name="ayah" maxlength="100"
                                    class="form-control" value="{{ old('ayah', $penduduk->ayah) }}">
                            </div>

                            <div class="form-group">
                                <label>Nama Ibu</label>
                                <input type="text" name="ibu" maxlength="100"
                                    class="form-control" value="{{ old('ibu', $penduduk->ibu) }}">
                            </div>

                        </div>
                    </div>
                </div>

                <div class="card-footer text-right">
                    <button type="submit" class="btn btn-sm btn-primary">
                        <i class="fas fa-save mr-2"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </section>
</div>
@endsection