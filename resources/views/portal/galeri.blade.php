<title>Galeri | Website Desa Bengkel</title>
@extends('portal.layout.app')

@section('section')
 <!-- Page Title -->
    <div class="page-title" data-aos="fade">
      <div class="heading">
        <div class="container">
          <div class="row d-flex justify-content-center text-center">
            <div class="col-lg-8">
              <h1>Galeri</h1>
              <p class="mb-0">DESA BENGKEL - KECAMATAN LABUAPI</p>
            </div>
          </div>
        </div>
      </div>
      <nav class="breadcrumbs">
        <div class="container">
          <ol>
            <li><a href="{{ route('welcome') }}">Home</a></li>
            <li class="current">Galeri</li>
          </ol>
        </div>
      </nav>
    </div><!-- End Page Title -->

        <!-- Starter Section Section -->
<section id="agenda" class="agenda section">
    <div class="container" data-aos="fade-up">
        
      <div class="row g-5">
        <div class="col-lg-8">
          @include('partials.galeri')
        </div>
        <div class="col-lg-4">
          @include('partials.berita.sidebar')
        </div>
      </div>


        

    </div>
</section>
    <!-- /Starter Section Section -->




@endsection