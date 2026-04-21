<title>Berita | Website Desa Bengkel</title>
@extends('portal.layout.app')

@section('section')
 <!-- Page Title -->
    <div class="page-title" data-aos="fade">
      <div class="heading">
        <div class="container">
          <div class="row d-flex justify-content-center text-center">
            <div class="col-lg-8">
              <h1>Berita</h1>
              <p class="mb-0">DESA BENGKEL - KECAMATAN LABUAPI</p>
            </div>
          </div>
        </div>
      </div>
      <nav class="breadcrumbs">
        <div class="container">
          <ol>
            <li><a href="{{ route('welcome') }}">Home</a></li>
            <li class="current">Berita</li>
          </ol>
        </div>
      </nav>
    </div><!-- End Page Title -->

        <!-- Starter Section Section -->
<section id="berita" class="berita section">
    <div class="container" data-aos="fade-up">
        <div class="row">
          <div class="col-md-6 offset-md-3">
            <form action="{{ route('berita') }}" method="GET">
              <div class="input-group">
                <input type="text" name="table_search" class="form-control"
                      placeholder="Cari Judul Berita..." value="{{ request('table_search') }}">
                <button class="btn btn-primary" type="submit">
                  <i class="bi bi-search"></i>
                </button>
              </div>
            </form>
          </div>
        </div>

        <br>
        @include('partials.berita.index', ['berita' => $beritaTerbaru])

  </section>
    <!-- /Starter Section Section -->
@endsection