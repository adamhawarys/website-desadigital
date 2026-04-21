<title>Dashboard | Edit Data Penduduk</title>
@extends('layout.master')

@section('content')
<div class="content-wrapper" style="min-height: 1302.4px;">

    <!-- Content Header -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Data Penduduk</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('penduduk.index') }}">Data Penduduk</a>
                        </li>
                        <li class="breadcrumb-item active">Edit Data Penduduk</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Main content -->
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

                        <!-- ===== KIRI ===== -->
                        <div class="col-md-6">

                            <div class="form-group">
                                <label>NIK </label>
                                <input type="text" name="nik" class="form-control @error('nik') is-invalid @enderror"
                                       value="{{ old('nik', $penduduk->nik) }}">
                                @error('nik') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="form-group">
                                <label>Nama Lengkap</span></label>
                                <input type="text" name="nama_lengkap" class="form-control @error('nama_lengkap') is-invalid @enderror"
                                       value="{{ old('nama_lengkap', $penduduk->nama_lengkap) }}">
                                @error('nama_lengkap') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="form-group">
                                <label>Jenis Kelamin</label>
                                <select name="jenis_kelamin" class="form-control @error('jenis_kelamin') is-invalid @enderror">
                                    <option value="" disabled selected>-- Pilih --</option>
                                    <option value="L" {{ old('jenis_kelamin', $penduduk->jenis_kelamin) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="P" {{ old('jenis_kelamin', $penduduk->jenis_kelamin) == 'P' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                                @error('jenis_kelamin') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="form-group">
                                <label>NO KK</label>
                                <input type="text" name="kk" class="form-control" value="{{ old('kk', $penduduk->kk) }}">
                            </div>

                            <div class="form-group">
                                <label>Tempat Lahir</label>
                                <input type="text" name="tempat_lahir" class="form-control" value="{{ old('tempat_lahir', $penduduk->tempat_lahir) }}">
                            </div>

                            <div class="form-group">
                                <label>Tanggal Lahir</label>
                                <input type="date" name="tanggal_lahir" class="form-control" value="{{ old('tanggal_lahir', optional($penduduk->tanggal_lahir)->format('Y-m-d')) }}">
                            </div>

                            <div class="form-group">
                                <label>Alamat</label>
                                <input type="text" name="alamat" class="form-control" value="{{ old('alamat', $penduduk->alamat) }}">
                            </div>

                            <div class="form-group">
                                <label>RT</label>
                                <input type="text" name="rt" class="form-control" value="{{ old('rt', $penduduk->rt) }}">
                            </div>

                            <div class="form-group">
                                <label>Dusun</label>
                                <input type="text" name="dusun" class="form-control" value="{{ old('dusun', $penduduk->dusun) }}">
                            </div>

                            <div class="form-group">
                                <label>Desa</label>
                                <input type="text" name="desa" class="form-control" value="{{ old('desa', $penduduk->desa) }}">
                            </div>

                            <div class="form-group">
                                <label>Kecamatan</label>
                                <input type="text" name="kecamatan" class="form-control" value="{{ old('kecamatan',$penduduk->kecamatan) }}">
                            </div>

                        </div>

                        <!-- ===== KANAN ===== -->
                        <div class="col-md-6">

                            <div class="form-group">
                                <label>Agama</label>
                                <input type="text" name="agama" class="form-control" value="{{ old('agama', $penduduk->agama) }}">
                            </div>

                            <div class="form-group">
                                <label>Pendidikan</label>
                                <input type="text" name="pendidikan" class="form-control" value="{{ old('pendidikan', $penduduk->pendidikan) }}">
                            </div>

                            <div class="form-group">
                                <label>Kewarganegaraan</label>
                                <input type="text" name="kewarganegaraan" class="form-control"
                                       value="{{ old('kewarganegaraan', 'Indonesia') }}">
                            </div>

                            <div class="form-group">
                                <label>Status Perkawinan</label>
                                <input type="text" name="status_perkawinan" class="form-control"
                                       value="{{ old('status_perkawinan', $penduduk->status_perkawinan) }}">
                            </div>

                            <div class="form-group">
                                <label>Golongan Darah</label>
                                <input type="text" name="gol_darah" class="form-control" value="{{ old('gol_darah', $penduduk->gol_darah) }}">
                            </div>

                            <div class="form-group">
                                <label>Status Hubungan Dalam Keluarga</label>
                                <input type="text" name="shdk" class="form-control" value="{{ old('shdk', $penduduk->shdk) }}">
                            </div>

                            <div class="form-group">
                                <label>Pekerjaan</label>
                                <input type="text" name="pekerjaan" class="form-control" value="{{ old('pekerjaan', $penduduk->pekerjaan) }}">
                            </div>

                            <div class="form-group">
                                <label>Ayah</label>
                                <input type="text" name="ayah" class="form-control" value="{{ old('ayah', $penduduk->ayah) }}">
                            </div>

                            <div class="form-group">
                                <label>Ibu</label>
                                <input type="text" name="ibu" class="form-control" value="{{ old('ibu', $penduduk->ibu) }}">
                            </div>

                        </div>
                    </div>
                </div>

                <!-- Footer -->
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
