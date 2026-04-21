<title>Dashboard | Tambah Profil Desa</title>
@extends('layout.master')

@section('content')
<div class="content-wrapper">

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Tambah Profil Desa</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="dashboard">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('profil_desa') }}">Profil Desa</a></li>
                        <li class="breadcrumb-item active">Tambah</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="card">

            <div class="card-header">
                <a href="{{ route('profil_desa') }}" class="btn btn-sm btn-secondary">
                    <i class="fas fa-arrow-left mr-1"></i> Kembali
                </a>
            </div>

            <div class="card-body">

                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('profil_desa.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nama Desa <span class="text-danger">*</span></label>
                                <input type="text"
                                       name="nama_desa"
                                       class="form-control @error('nama_desa') is-invalid @enderror"
                                       value="{{ old('nama_desa') }}"
                                       placeholder="Contoh: Desa Bengkel"
                                       required>
                                @error('nama_desa')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Kode Pos <span class="text-danger">*</span></label>
                                <input type="text"
                                       name="kode_pos"
                                       class="form-control @error('kode_pos') is-invalid @enderror"
                                       value="{{ old('kode_pos') }}"
                                       placeholder="Contoh: 83361"
                                       maxlength="5"
                                       required>
                                @error('kode_pos')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Alamat Desa <span class="text-danger">*</span></label>
                                <textarea name="alamat"
                                          class="form-control @error('alamat') is-invalid @enderror"
                                          rows="3"
                                          placeholder="Contoh: Jl. Raya Bengkel No. 1, Kecamatan Labuapi"
                                          required>{{ old('alamat') }}</textarea>
                                @error('alamat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nama Kepala Desa <span class="text-danger">*</span></label>
                                <input type="text"
                                       name="kades"
                                       class="form-control @error('kades') is-invalid @enderror"
                                       value="{{ old('kades') }}"
                                       placeholder="Nama lengkap kepala desa"
                                       required>
                                @error('kades')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nama Sekretaris Desa <span class="text-danger">*</span></label>
                                <input type="text"
                                       name="sekdes"
                                       class="form-control @error('sekdes') is-invalid @enderror"
                                       value="{{ old('sekdes') }}"
                                       placeholder="Nama lengkap sekretaris desa"
                                       required>
                                @error('sekdes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Logo Desa</label>
                                <input type="file"
                                       name="logo"
                                       class="form-control @error('logo') is-invalid @enderror"
                                       accept=".jpg,.jpeg,.png">
                                <small class="text-muted">Format: JPG, JPEG, PNG (maks 2MB)</small>
                                @error('logo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Preview logo --}}
                            <div id="preview-container" style="display:none;">
                                <img id="preview-logo"
                                     src=""
                                     alt="Preview Logo"
                                     style="width:100px; height:100px; object-fit:contain; border:1px solid #ddd; padding:4px; border-radius:4px;">
                            </div>
                        </div>

                    </div>

                    <hr>

                    <div class="text-right">
                        <a href="{{ route('profil_desa') }}" class="btn btn-secondary mr-2">
                            Batal
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save mr-1"></i> Simpan
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </section>

</div>

<script>
    // Preview logo sebelum upload
    document.querySelector('input[name="logo"]').addEventListener('change', function () {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                document.getElementById('preview-logo').src = e.target.result;
                document.getElementById('preview-container').style.display = 'block';
            };
            reader.readAsDataURL(file);
        }
    });
</script>
@endsection