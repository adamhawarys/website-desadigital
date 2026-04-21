<title>Layanan | Website Desa Bengkel</title>
@extends('portal.layout.app')

@section('section')
 <!-- Page Title -->
    <div class="page-title" data-aos="fade">
      <div class="heading">
        <div class="container">
          <div class="row d-flex justify-content-center text-center">
            <div class="col-lg-8">
              <h1>Layanan</h1>
              <p class="mb-0">DESA BENGKEL - KECAMATAN LABUAPI</p>
            </div>
          </div>
        </div>
      </div>
      <nav class="breadcrumbs">
        <div class="container">
          <ol>
            <li><a href="{{ route('welcome') }}">Home</a></li>
            <li class="current">Layanan</li>
          </ol>
        </div>
      </nav>
    </div><!-- End Page Title -->

           <!-- Services Section -->
     <section id="services" class="services section">
        <div class="container">
            <div class="row gy-4">
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="service-item position-relative">
                    <div class="icon">
                        <i class="fa-solid fa-file-lines"></i>
                    </div>
                    <a href="{{ route('layanan.detail', 'surat-keterangan-usaha') }}" class="stretched-link">
                        <h3>Surat Keterangan Usaha</h3>
                    </a>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
                    <div class="service-item position-relative">
                    <div class="icon">
                        <i class="fa-solid fa-file-lines"></i>
                    </div>
                    <a href="{{ route('layanan.detail', 'surat-keterangan-domisili') }}" class="stretched-link">
                        <h3>Surat Keterangan Domisili</h3>
                    </a>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
                    <div class="service-item position-relative">
                    <div class="icon">
                        <i class="fa-solid fa-file-lines"></i>
                    </div>
                    <a href="{{ route('layanan.detail', 'surat-keterangan-tidak-mampu') }}" class="stretched-link">
                        <h3>Surat Keterangan Tidak Mampu</h3>
                    </a>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="400">
                    <div class="service-item position-relative">
                    <div class="icon">
                        <i class="fa-solid fa-file-lines"></i>
                    </div>
                    <a href="{{ route('layanan.detail', 'surat-rekomendasi') }}" class="stretched-link">
                        <h3>Surat Rekomendasi</h3>
                    </a>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="500">
                    <div class="service-item position-relative">
                    <div class="icon">
                        <i class="fa-solid fa-file-lines"></i>
                    </div>
                    <a href="{{ route('layanan.detail', 'surat-pengantar-permohonan-kk') }}" class="stretched-link">
                        <h3>Surat Pengantar Permohonan KK</h3>
                    </a>
                    </div>
                </div>

            </div>
        </div>
    </section>
<!-- /Services Section --> 
@endsection