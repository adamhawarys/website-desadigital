<title>{{ $berita->judul }} | Website Desa Bengkel</title>
@extends('portal.layout.app')

@section('section')
 <!-- Page Title -->
    <div class="page-title" data-aos="fade">
      <div class="heading">
        <div class="container">
          <div class="row d-flex justify-content-center text-center">
            <div class="col-lg-8">
              <h1>{{ $berita->judul }}</h1>
              <p class="mb-0">DESA BENGKEL - KECAMATAN LABUAPI</p>
            </div>
          </div>
        </div>
      </div>
      <nav class="breadcrumbs">
        <div class="container">
          <ol>
            <li><a href="{{ route('welcome') }}">Home</a></li>
            <li><a href="{{ route('berita') }}">Berita</a></li>
            <li class="current">{{ $berita->judul }}</li>
          </ol>
        </div>
      </nav>
    </div><!-- End Page Title -->

        <!-- Starter Section Section -->
<section id="detail-berita" class="detail-berita section">
    <div class="container" data-aos="fade-up">
        <div class="row g-5">
            <div class="col-lg-8">
                <div class="row g-5">
                    
                    <div class="col-lg-12">
                        <div class="berita-detail">
                            <div class="berita-img">
                                <img src="{{ Storage::disk('s3')->url($berita->gambar ?? 'images.png') }}" class="img-fluid w-100" alt="{{ $berita->judul }}">
                            </div>
                            <h2 class="title">{{ $berita->judul }}</h2>
                            <div class="meta-top">
                                <ul>
                                  <li class="d-flex align-items-center">
                                    <i class="fas fa-clock"></i>
                                    <time>{{ $berita->tanggal_publikasi }}</time>
                                  </li>

                                  <li class="d-flex align-items-center">
                                    <i class="fas fa-user"></i>
                                    <span>{{ $berita->penulis->name ?? '-' }}</span>
                                  </li>
                                </ul>

                            </div>
                            <div class="content">
                                <p>{!! $berita->konten !!}</p>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
            <div class="col-lg-4">
              {{-- <div class="sidebar">
                <div class="sidebar-item search-form">
                  <h3 class="sidebar-title"> Cari Berita</h3>
                  <form action="" class="mt-3">
                    <input type="text" placeholder="Cari berita..." maxlength="25">
                    <button type="submit">
                      <i class="bi bi-search">
                        <img src="" alt="">
                      </i>
                    </button>
                  </form>
                </div>
                
              </div> --}}
              @include('partials.berita.sidebar')
            </div>
        </div>
        <br>
        
  </section>
    <!-- /Starter Section Section -->
@endsection