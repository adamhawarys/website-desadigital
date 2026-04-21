<title>Visi & Misi | Website Desa Bengkel</title>
@extends('portal.layout.app')


    
@section('section')
  <!-- Page Title -->
    <div class="page-title" data-aos="fade">
      <div class="heading">
        <div class="container">
          <div class="row d-flex justify-content-center text-center">
            <div class="col-lg-8">
              <h1>Visi & Misi</h1>
              <p class="mb-0">DESA BENGKEL - KECAMATAN LABUAPI</p>
            </div>
          </div>
        </div>
      </div>
      <nav class="breadcrumbs">
        <div class="container">
          <ol>
            <li><a href="{{ route('welcome') }}">Home</a></li>
            <li class="current">Visi & Misi</li>
          </ol>
        </div>
      </nav>
    </div><!-- End Page Title -->

    <!-- Starter Section Section -->
    <section id="visi-misi" class="visi-misi section">
    <div class="container" data-aos="fade-up">

     <div class="card-wrapper">
      <div class="container">

        <div class="card-box">
          <h2 class="card-title">Visi</h2>
          <div class="card-text">
            {!! $visimisi->visi !!}
          </div>
        </div>

        <div class="card-box">
          <h2 class="card-title">Misi</h2>
          <div class="card-text">
            {!! $visimisi->misi !!}
          </div>
        </div>

      </div>
    </div>

    </div>
  </section>
    <!-- /Starter Section Section -->

@endsection
