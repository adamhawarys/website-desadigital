<title>Dashboard | Visi & Misi</title>
@extends('layout.master')

@section('content')
  <div class="content-wrapper" style="min-height: 1502.4px;">
    <!-- Content Header -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Visi & Misi</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Visi & Misi</li>
                </ol>
            </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <section class="content">
        <div class="card">
            <form action="{{ route('visimisi.update') }}" method="POST">
                @csrf
                <div class="card-body">

                    {{-- Visi --}}
                    <div class="form-group">
                        <label><h3><b>Visi</b></h3></label>
                        <textarea id="summernote-visi" name="visi" class="form-control">
                            {{ old('visi', $visimisi->visi ?? '') }}
                        </textarea>
                    </div>

                    {{-- Misi --}}
                    <div class="form-group">
                        <label><h3><b>Misi</b></h3></label>
                        <textarea id="summernote-misi" name="misi" class="form-control">
                            {{ old('misi', $visimisi->misi ?? '') }}
                        </textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save mr-2"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </section>
  </div>
  
@endsection

@section('js')
<script>
    $(document).ready(function() {
        $('#summernote-visi, #summernote-misi').summernote({
            placeholder: 'Tulis disini...',
            height: 200,
            toolbar: [
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['strikethrough', 'superscript', 'subscript']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ]
        });
    });
</script>
@endsection
