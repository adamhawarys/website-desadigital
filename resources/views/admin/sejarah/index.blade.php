<title>Dashboard | Sejarah Desa</title>
@extends('layout.master')

@section('content')
<div class="content-wrapper" style="min-height: 102.4px;">
    <!-- Content Header -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Sejarah Desa</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Sejarah Desa</li>
                </ol>
            </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <section class="content">
        <div class="card">
            <form action="{{ route('sejarah.update') }}" method="post">
                @csrf
                <div class="card-body">

                    {{-- Visi --}}
                    <div class="form-group">
                        <label><h3><b></b></h3></label>
                        <textarea id="summernote" name="sejarah" class="form-control">
                            {{ $sejarah->sejarah ?? '' }}
                        </textarea>
                    </div>

                    {{-- Misi --}}
                    

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
        $('#summernote').summernote({
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
