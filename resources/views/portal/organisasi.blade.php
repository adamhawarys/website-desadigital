<title>Struktur Organisasi | Website Desa Bengkel</title>
@extends('portal.layout.app')

@section('section')
 <!-- Page Title -->
    <div class="page-title" data-aos="fade">
      <div class="heading">
        <div class="container">
          <div class="row d-flex justify-content-center text-center">
            <div class="col-lg-8">
              <h1>Struktur Organisasi</h1>
              <p class="mb-0">DESA BENGKEL - KECAMATAN LABUAPI</p>
            </div>
          </div>
        </div>
      </div>
      <nav class="breadcrumbs">
        <div class="container">
          <ol>
            <li><a href="{{ route('welcome') }}">Home</a></li>
            <li class="current">Struktur Organisasi</li>
           
          </ol>
        </div>
      </nav>
      
    </div><!-- End Page Title -->

        <!-- Starter Section Section -->
<section id="berita" class="berita section">
    <div class="container" data-aos="fade-up">
        <div class="row g-5">
            <div class="col-lg-3">
                @include('partials.organisasi.sidebar')
            </div>
            <div class="col-lg-9">
              <article class="card-box">
                <img src="{{ Storage::disk('s3')->url('perangkat_desa_photos/struktur organisasi.jpg') }}" class="img-fluid" alt="Struktur Organisasi">
              </article>
              
            </div>
        </div>
        
  </section>
    <!-- /Starter Section Section -->
@endsection