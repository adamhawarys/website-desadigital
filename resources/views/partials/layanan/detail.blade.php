<title>{{ $detail['judul'] }} | Website Desa Bengkel</title>

@extends('portal.layout.app')

@section('section')
<!-- Page Title -->
<div class="page-title" data-aos="fade">
  <div class="heading">
    <div class="container">
      <div class="row d-flex justify-content-center text-center">
        <div class="col-lg-8">
          <h1>{{ $detail['judul'] }}</h1>
        </div>
      </div>
    </div>
  </div>

  <nav class="breadcrumbs">
    <div class="container">
      <ol>
        <li><a href="{{ route('welcome') }}">Home</a></li>
        <li><a href="{{ route('layanan') }}">Layanan</a></li>
        <li class="current">{{ $detail['judul'] }}</li>
      </ol>
    </div>
  </nav>
</div>
<!-- End Page Title -->

<section id="services" class="services section">
  <div class="container">
    <div class="row">
      <div class="col-lg-7">
        <div class="card">
          <div class="card-body">
            <b>Persyaratan :</b>
            <ul>
              @foreach ($detail['syarat'] as $item)
                <li>
                    @if(is_array($item))
                        {{ $item['teks'] }} 
                        <a href="{{ $item['link'] }}" class="btn btn-sm btn-primary ms-2" target="_blank" download>
                            <i class="fas fa-download"></i> Download Form disini
                        </a>
                    @else
                        {{ $item }}
                    @endif
                </li>
              @endforeach
            </ul>

            <div class="mt-3">
              <b>Alur Pengajuan :</b>
              <ul>
                @foreach ($alur as $item)
                  <li>{{ $item }}</li>
                @endforeach
              </ul>
            </div>
          </div>
        </div>
      </div>

      <div class="col-lg-5">
        @include('partials.sidebar_login')
      </div>
    </div>
  </div>
</section>
@endsection
