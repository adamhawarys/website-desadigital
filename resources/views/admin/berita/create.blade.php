<title>Dashboard | Upload Berita</title>
@extends('layout.master')

@section('content')
<div class="content-wrapper" style="min-height: 1202.4px;">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Upload Berita</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="dashboard">Dashboard</a></li>
              <li class="breadcrumb-item active">Upload Berita</li>
            </ol>
          </div>
        </div>
        </div>
    </section>

    <section class="content">
        <div class="card">
            <div class = "card-header bg-primary">
            <a   href  = "{{ route('berita.index') }}" class = "btn btn-success btn-sm">
            <i   class = "fas fa-arrow-left mr-2"></i>Kembali
                </a>
            </div>

            <form action="{{ route('berita.store') }}" method="post" enctype="multipart/form-data">
                @csrf

                <div class="card-body">
                    <div class="row">

                        {{-- Gambar --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Gambar</label>
                                <input type="file" name="gambar" class="form-control">
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
                                    <option value="draft">Draft</option>
                                    <option value="published">Published</option>
                                    <option value="archived">Archived</option>
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
                                <input type="text" name="judul" id="judul" class="form-control" required>
                              @error('judul')
                                  <small class="text-danger">{{ $message }}</small>
                                @enderror
                              </div>
                        </div>

                        {{-- Slug --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Slug</label>
                                <input type="text" name="slug" id="slug" class="form-control" required>
                              @error('slug')
                                  <small class="text-danger">{{ $message }}</small>
                                @enderror
                              </div>
                        </div>

                        {{-- Konten --}}
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Konten</label>
                                <textarea name="konten" id="summernote" class="form-control"></textarea>

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

<script>
function slugify(text) {
    return text
        .toString()
        .toLowerCase()
        .trim()
        .replace(/\s+/g, '-')           // spasi jadi -
        .replace(/[^\w\-]+/g, '')       // hapus karakter aneh
        .replace(/\-\-+/g, '-');        // hapus -- berlebih
}

document.getElementById('judul').addEventListener('keyup', function () {
    document.getElementById('slug').value = slugify(this.value);
});
</script>
@endsection
