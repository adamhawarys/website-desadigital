<title> Edit Layanan | {{$layanan->nama_layanan }}</title>
@extends('layout.master')

@section('content')
<div class="content-wrapper" style="min-height: 1302.4px;">

    {{-- HEADER --}}
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Data Layanan</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ url('dashboard') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('layanan.index') }}">Data Layanan</a>
                        </li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    {{-- CONTENT --}}
    <section class="content">
        <div class="card">

            {{-- CARD HEADER --}}
            <div class="card-header bg-primary">
                <a href="{{ route('layanan.index') }}" class="btn btn-success btn-sm">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Kembali
                </a>
            </div>

            {{-- CARD BODY --}}
            <div class="card-body">

                {{-- ALERT VALIDATION --}}
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0 pl-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- FORM --}}
                <form action="{{ route('layanan.update', $layanan->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <label for="nama_layanan">Nama Layanan</label>
                        <input type="text"
                               name="nama_layanan"
                               id="nama_layanan"
                               class="form-control @error('nama_layanan') is-invalid @enderror"
                               placeholder="Masukkan nama layanan"
                               value="{{ old('nama_layanan', $layanan->nama_layanan) }}">
                        @error('nama_layanan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="kode_layanan">Kode</label>
                        <input type="text"
                               name="kode_layanan"
                               id="kode_layanan"
                               class="form-control @error('kode_layanan') is-invalid @enderror"
                               placeholder="Masukkan kode layanan"
                               value="{{ old('kode_layanan', $layanan->kode_layanan) }}">
                        @error('kode_layanan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="deskripsi">Deskripsi</label>
                        <textarea name="deskripsi"
                                  id="deskripsi"
                                  rows="4"
                                  class="form-control @error('deskripsi') is-invalid @enderror"
                                  placeholder="Masukkan deskripsi layanan">{{ old('deskripsi', $layanan->deskripsi) }}</textarea>
                        @error('deskripsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="template_surat">Template Surat</label>
                        <small class="text-muted d-block mb-2">
                            Gunakan placeholder berikut di dalam template:
                            <br>
                            <code>@{{nama_lengkap}}</code>
                            <code>@{{nik}}</code>
                            <code>@{{kk}}</code>
                            <code>@{{tempat_lahir}}</code>
                            <code>@{{tanggal_lahir}}</code>
                            <code>@{{jenis_kelamin}}</code>
                            <code>@{{agama}}</code>
                            <code>@{{pekerjaan}}</code>
                            <code>@{{alamat}}</code>
                            <code>@{{rt}}</code>
                            <code>@{{dusun}}</code>
                            <code>@{{desa}}</code>
                            <code>@{{kecamatan}}</code>
                            <code>@{{keperluan}}</code>
                            <code>@{{nomor_surat}}</code>
                            <code>@{{tanggal_disetujui}}</code>
                            <code>@{{nama_desa}}</code>
                            <code>@{{kades}}</code>
                        </small>
                        <textarea name="template_surat"
                                  id="template_surat"
                                  class="form-control @error('template_surat') is-invalid @enderror">{!! old('template_surat', $layanan->template_surat) !!}</textarea>
                        @error('template_surat')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-end">
                        <a href="{{ route('layanan.index') }}" class="btn btn-sm btn-secondary mr-2">
                            Batal
                        </a>
                        <button type="submit" class="btn btn-sm btn-warning">
                            <i class="fas fa-save mr-2"></i>
                            Update
                        </button>
                    </div>

                </form>

            </div>

        </div>
    </section>

</div>
@endsection

@push('scripts')
<script>
    $('#template_surat').summernote({
        height: 400,
        lang: 'id-ID',
        toolbar: [
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['font', ['strikethrough']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['insert', ['table', 'hr']],
            ['view', ['fullscreen', 'codeview']],
        ]
    });
</script>
@endpush