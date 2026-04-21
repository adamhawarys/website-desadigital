<title>Daftar Layanan Surat | Layanan Mandiri Desa Bengkel</title>
@extends('layanan_mandiri.layout.app')

@section('section')

<!-- Page Title -->
<div class="page-title" data-aos="fade">
  <div class="heading">
    <div class="container">
      <div class="row d-flex justify-content-center text-center">
        <div class="col-lg-8">
          <h1>DAFTAR LAYANAN SURAT</h1>
          <p class="mb-0">Silakan pilih layanan yang ingin Anda ajukan</p>
        </div>
      </div>
    </div>
  </div>
  <nav class="breadcrumbs">
    <div class="container">
      <ol>
        <li><a href="{{ route('layanan_mandiri') }}">Beranda</a></li>
        <li class="current">Daftar Layanan</li>
      </ol>
    </div>
  </nav>
</div>
<!-- End Page Title -->


<section id="services" class="services section">
  <div class="container" >

        @if(!$penduduk)
      <div class="alert alert-warning d-flex align-items-center justify-content-between flex-wrap gap-2 mb-4">
        <div>
          <strong>Data penduduk belum terhubung.</strong>
          <div class="small text-muted">Silakan hubungkan NIK agar dapat mengajukan layanan.</div>
        </div>
        <a href="{{ route('edit_data') }}" class="btn btn-sm btn-primary">
          Hubungkan Data
        </a>
      </div>
    @endif

    <div class="row gy-4">

@forelse($layanan as $item)
<div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
    <div class="service-item position-relative {{ !$penduduk ? 'opacity-50 bg-light' : '' }}" 
         style="{{ !$penduduk ? 'pointer-events: none; filter: grayscale(100%);' : '' }}">
        
        <div class="icon">
            <i class="fa-solid fa-file-lines"></i>
        </div>
        
        @if($penduduk)
            <a href="{{ route('layanan_mandiri.pengajuan.create', $item->id) }}" class="stretched-link">
                <h3 class="mt-3">{{ $item->nama_layanan }}</h3>
            </a>
        @else
            <a href="#" class="stretched-link text-muted" style="text-decoration: none;" onclick="return false;">
                <h3 class="mt-3">{{ $item->nama_layanan }} </h3>
            </a>
        @endif

    </div>
</div>
@empty
<div class="col-12">
    <div class="alert alert-warning text-center">
        Belum ada layanan tersedia.
    </div>
</div>
@endforelse

    </div>

  </div>
</section>

@endsection