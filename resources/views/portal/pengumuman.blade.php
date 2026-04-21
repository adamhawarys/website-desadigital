<title>Pengumuman | Website Desa Bengkel</title>
@extends('portal.layout.app')

@section('section')
 <!-- Page Title -->
    <div class="page-title" data-aos="fade">
        <div class="heading">
          <div class="container">
            <div class="row d-flex justify-content-center text-center">
              <div class="col-lg-8">
                <h1>Pengumuman</h1>
                <p class="mb-0">DESA BENGKEL - KECAMATAN LABUAPI</p>
              </div>
            </div>
          </div>
        </div>

        <nav class="breadcrumbs">
          <div class="container">
            <ol>
              <li><a href="{{ route('welcome') }}">Home</a></li>
              <li class="current">Pengumuman</li>
            </ol>
          </div>
        </nav>
    </div><!-- End Page Title -->

        <!-- Starter Section Section -->
<section id="pengumuman" class="faq section light " >
    <div class="container" data-aos="fade-up">

        <div class="row g-5">
          <div class="col-lg-8">
            @include('partials.pengumuman', ['pengumuman' => $pengumuman]) 
          </div>
          <div class="col-lg-4">
              @include('partials.berita.sidebar') 
            
          </div>
        </div>
        
  </section>
    <!-- /Starter Section Section -->


<script>
  document.querySelectorAll('.faq-header').forEach(function(header) {
  header.addEventListener('click', function(e) {
    e.stopPropagation(); // biar aman

    var item = this.parentElement;
    var isOpen = item.classList.contains('faq-active');

    document.querySelectorAll('.faq-item.faq-active').forEach(function(el) {
      el.classList.remove('faq-active');
    });

    if (!isOpen) item.classList.add('faq-active');
  });
});
</script>

@endsection