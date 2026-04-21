<title>Statistik Desa | Website Desa Bengkel</title>
@extends('portal.layout.app')

@section('section')
 <!-- Page Title -->
    <div class="page-title" data-aos="fade">
      <div class="heading">
        <div class="container">
          <div class="row d-flex justify-content-center text-center">
            <div class="col-lg-8">
              <h1>Statistik Desa</h1>
              <p class="mb-0">DESA BENGKEL - KECAMATAN LABUAPI</p>
            </div>
          </div>
        </div>
      </div>
      <nav class="breadcrumbs">
        <div class="container">
          <ol>
            <li><a href="{{ route('welcome') }}">Home</a></li>
            <li class="current">Statistik Desa</li>
           
          </ol>
        </div>
      </nav>
      
    </div><!-- End Page Title -->

        <!-- Starter Section Section -->
<section id="stats" class="stats section">
    <div class="container" data-aos="fade-up">
        <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row gy-4">

          <div class="col-lg-3 col-md-6 d-flex flex-column align-items-center">
            <i class="fa-solid fa-user-doctor"></i>
            <div class="stats-item">
              <span data-purecounter-start="0" data-purecounter-end="{{ $totalLakiLaki }}" data-purecounter-duration="1" class="purecounter"></span>
              <p>Laki-Laki</p>
            </div>
          </div><!-- End Stats Item -->

          <div class="col-lg-3 col-md-6 d-flex flex-column align-items-center">
            <i class="fa-regular fa-hospital"></i>
            <div class="stats-item">
              <span data-purecounter-start="0" data-purecounter-end="{{ $totalPerempuan }}" data-purecounter-duration="1" class="purecounter"></span>
              <p>Perempuan</p>
            </div>
          </div><!-- End Stats Item -->

          <div class="col-lg-3 col-md-6 d-flex flex-column align-items-center">
            <i class="fas fa-flask"></i>
            <div class="stats-item">
              <span data-purecounter-start="0" data-purecounter-end="2979" data-purecounter-duration="1" class="purecounter"></span>
              <p>Jumlah KK</p>
            </div>
          </div><!-- End Stats Item -->

          <div class="col-lg-3 col-md-6 d-flex flex-column align-items-center">
            <i class="fas fa-award"></i>
            <div class="stats-item">
              <span data-purecounter-start="0" data-purecounter-end="{{ $totalPenduduk }}" data-purecounter-duration="1" class="purecounter"></span>
              <p>Total Penduduk</p>
            </div>
          </div><!-- End Stats Item -->

        </div>

      </div>
        <div class="row g-5">
            <div class="col-lg-3">
                {{-- @include('partials.statistik.sidebar') --}}
            </div>
            <div class="col-lg-9">
              
              
            </div>
        </div>
        
  </section>
    <!-- /Starter Section Section -->
@endsection