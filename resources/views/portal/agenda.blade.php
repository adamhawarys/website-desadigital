<title>Agenda | Website Desa Bengkel</title>
@extends('portal.layout.app')

@section('section')
 <!-- Page Title -->
    <div class="page-title" data-aos="fade">
      <div class="heading">
        <div class="container">
          <div class="row d-flex justify-content-center text-center">
            <div class="col-lg-8">
              <h1>Agenda</h1>
              <p class="mb-0">DESA BENGKEL - KECAMATAN LABUAPI</p>
            </div>
          </div>
        </div>
      </div>
      <nav class="breadcrumbs">
        <div class="container">
          <ol>
            <li><a href="{{ route('welcome') }}">Home</a></li>
            <li class="current">Agenda</li>
          </ol>
        </div>
      </nav>
    </div><!-- End Page Title -->

        <!-- Starter Section Section -->
<section id="agenda" class="agenda section">
    <div class="container" data-aos="fade-up">
        
      <div class="row g-5">
        <div class="col-lg-8">
          @include('partials.agenda.index')
        </div>
        <div class="col-lg-4">
          @include('partials.berita.sidebar')
        </div>
      </div>
        {{-- <div class="row mb-5">
            <div class="col-md-6 offset-md-3">
                <form action="{{ route('agenda') }}" method="GET">
                    <div class="input-group">
                        <input type="text" name="table_search" class="form-control"
                            placeholder="Cari Agenda Kegiatan..." value="{{ request('table_search') }}">
                        <button class="btn btn-primary px-4" type="submit">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div> --}}

        

    </div>
</section>
    <!-- /Starter Section Section -->


<script>
  document.querySelectorAll('.agenda-card').forEach(function(card) {
    card.addEventListener('click', function() {
      var isOpen = card.classList.contains('open');
      document.querySelectorAll('.agenda-card.open').forEach(function(c) {
        c.classList.remove('open');
      });
      if (!isOpen) card.classList.add('open');
    });
  });
</script>

@endsection