<title>Dashboard | Edit Berita</title>
@extends('layout.master')

@section('content')
<div class="content-wrapper" style="min-height: 1202.4px;">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Edit Berita</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="dashboard">Dashboard</a></li>
              <li class="breadcrumb-item active">Edit Berita</li>
            </ol>
          </div>
        </div>
        </div>
    </section>

    <section class="content">
        <div class="card">
            <div class="card-header bg-primary">
                <a href="{{ route('berita.index') }}" class="btn btn-success btn-sm">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali
                </a>
            </div>

            <form action="{{ route('berita.update',$berita->id) }}" method="post" enctype="multipart/form-data">
                @csrf

                <div class="card-body">
                    <div class="row">

                        {{-- Gambar --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                 <label>Foto <small class="text-muted">(Biarkan kosong jika tidak ingin mengganti foto)</small></label>
                                
                                @if($berita->gambar)
                                <div class="mb-2">
                                    <img src="{{ Storage::disk('s3')->url($berita->gambar ?? 'images.png') }}" 
                                        alt="Preview" class="img-thumbnail" style="max-height: 150px; object-fit: cover;">
                                </div>
                                @endif
                                <input type="file" name="gambar" class="form-control" @error('gambar') is-invalid
                                 @enderror value="{{ $berita->gambar }}">
                              @error('gambar')
                                  <small class="text-danger">{{ $message }}</small>
                                @enderror
                              </div>
                        </div>

                        {{-- Status --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Status</label>
                                <select name="status" class="form-control @error('status') is-invalid
                                  @enderror" required>
                                    <option selected disabled>-- Pilih Status --</option>

                                    <option value="draft" {{ $berita->status  == 'draft' ? 'selected' : ''  }}>Draft</option>
                                    <option value="published" {{ $berita->status  == 'published' ? 'selected' : ''  }}>Published</option>
                                    <option value="archived" {{ $berita->status  == 'archived' ? 'selected' : ''  }}>Archived</option>
                                </select>
                                @error('status')
                                  <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        {{-- Judul --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Judul</label>
                                <input type="text" name="judul" id="judul" class="form-control" @error('judul') is-invalid
                                    @enderror required value="{{ $berita->judul }}">
                              @error('judul')
                                  <small class="text-danger">{{ $message }}</small>
                                @enderror
                              </div>
                        </div>

                        {{-- Slug --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Slug</label>
                                <input type="text" name="slug" id="slug" class="form-control @error('slug') is-invalid @enderror" value="{{ old('slug', $berita->slug) }}" readonly>
                                @error('slug')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>


                        {{-- Konten --}}
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Konten</label>
                                <textarea name="konten" id="summernote" class="form-control">{{ old('konten', $berita->konten) }}</textarea>

                            </div>
                        </div>

                        {{-- Tanggal Publikasi --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Tanggal Publikasi</label>
                                <input type="date" name="tanggal_publikasi" class="form-control">
                            </div>
                        </div>

                        {{-- Penulis --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Penulis</label>
                                <input type="text" class="form-control" value="{{ auth()->user()->name }}" readonly>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="card-footer text-right">
                    <button class="btn btn-primary">
                        <i class="fas fa-save mr-2"></i>Simpan 
                    </button>
                </div>
            </form>
        </div>
    </section>
</div>
@endsection

@section('js')
<script>
    $(document).ready(function () {
        $('#summernote').summernote({
            placeholder: 'Tulis konten berita...',
            height: 200
        });
    });
</script>
@endsection
