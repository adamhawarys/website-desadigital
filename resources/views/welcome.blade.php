<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Home | Website Desa Bengkel</title>
  <meta name="description" content="">
  <meta name="keywords" content="">

  <!-- Favicons -->
  <link href="{{ Storage::disk('s3')->url('logo-desa/logo-desa-bengkel.png') }}" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="assets/css/main.css" rel="stylesheet">

  

  <!-- =======================================================
  * Template Name: Medilab
  * Template URL: https://bootstrapmade.com/medilab-free-medical-bootstrap-theme/
  * Updated: Aug 07 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body class="index-page">

  @include('portal.layout.navbar')

  <main class="main">

    <!-- Hero Section -->
    <section id="hero" class="hero section light-background">

      <img src="assets/img/hero-bg-abstract.jpg" alt="" data-aos="fade-in">

      <div class="container position-relative">

        <div class="welcome position-relative" data-aos="fade-down" data-aos-delay="100">
          <h2>SELAMAT DATANG DI <br> WEBSITE DESA DIGITAL</h2>
          <p>Desa Bengkel - Kecamatan Labuapi - Kabupaten Lombok Barat</p>
        </div>
        <!-- End Welcome -->

         <div class="row gy-4 mt-5">
          <div class="col-md-6 col-lg-3" data-aos="zoom-out" data-aos-delay="100">
            <div class="icon-box" >
              <div class="icon"><i class="bi bi-book"></i></div>
              <h4 class="title"><a href="{{ route('sejarah') }}">Sejarah Desa</a></h4>
              {{-- <p class="description">Voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi</p> --}}
            </div>
          </div><!--End Icon Box -->

          <div class="col-md-6 col-lg-3" data-aos="zoom-out" data-aos-delay="200">
            <div class="icon-box">
              <div class="icon"><i class="bi bi-journal-text"></i></div>
              <h4 class="title"><a href="{{ route('berita') }}">Berita</a></h4>
              {{-- <p class="description">Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore</p> --}}
            </div>
          </div><!--End Icon Box -->

          <div class="col-md-6 col-lg-3" data-aos="zoom-out" data-aos-delay="300">
            <div class="icon-box">
              <div class="icon"><i class="bi bi-person-workspace"></i></div>
              <h4 class="title"><a href="{{ route('login_user') }}">Layanan Mandiri</a></h4>
              {{-- <p class="description">Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia</p> --}}
            </div>
          </div><!--End Icon Box -->

          <div class="col-md-6 col-lg-3" data-aos="zoom-out" data-aos-delay="400">
            <div class="icon-box">
              <div class="icon"><i class="bi bi-newspaper"></i></div>
              <h4 class="title"><a href="{{ route('pengumuman') }}">Pengumuman</a></h4>
              {{-- <p class="description">At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis</p> --}}
            </div>
          </div><!--End Icon Box -->

        </div>
        </div><!-- End  Content--> 

      </div>

    </section><!-- /Hero Section -->

 <!-- berita Section -->
    <section id="berita" class="berita section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Berita Terkini</h2>
        
      </div><!-- End Section Title -->

      <div class="container">

        @include('partials.berita.index')
       


      </div>

    </section><!-- /berita Section -->

    <!-- Stats Section -->
    <section id="stats" class="stats section light-background">
      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Statistik Penduduk</h2>
        
      </div><!-- End Section Title -->

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row gy-4">

          <div class="col-lg-3 col-md-6 d-flex flex-column align-items-center">
            <i class="bi bi-house-door"></i>
            <div class="stats-item">
              <span data-purecounter-start="0" data-purecounter-end="{{$jumlahDusun}}" data-purecounter-duration="1" class="purecounter"></span>
              <p>Dusun</p>
            </div>
          </div><!-- End Stats Item -->

          <div class="col-lg-3 col-md-6 d-flex flex-column align-items-center">
            <i class="bi bi-gender-male"></i>
            <div class="stats-item">
              <span data-purecounter-start="0" data-purecounter-end="{{ $totalLakiLaki }}" data-purecounter-duration="1" class="purecounter"></span>
              <p>Laki-Laki</p>
            </div>
          </div><!-- End Stats Item -->

          <div class="col-lg-3 col-md-6 d-flex flex-column align-items-center">
            <i class="bi bi-gender-female"></i>
            <div class="stats-item">
              <span data-purecounter-start="0" data-purecounter-end="{{ $totalPerempuan }}" data-purecounter-duration="1" class="purecounter"></span>
              <p>Perempuan</p>
            </div>
          </div><!-- End Stats Item -->

          <div class="col-lg-3 col-md-6 d-flex flex-column align-items-center">
            <i class="bi bi-people-fill"></i>
            <div class="stats-item">
              <span data-purecounter-start="0" data-purecounter-end="{{ $totalPenduduk }}" data-purecounter-duration="1" class="purecounter"></span>
              <p>Total Penduduk</p>
            </div>

            
          </div><!-- End Stats Item -->
         
        </div>
        <div class="row mt-4">
              <!-- DUSUN -->
            <div class="col-lg-4 col-md-6 mb-4">
              {{-- <h6 class="text-center">Penduduk per Dusun</h6> --}}
              <div style="height:400px">
                <canvas id="chartDusun"></canvas>
              </div>
            </div>

              <!-- USIA -->
            <div class="col-lg-4 col-md-6 mb-4">
              {{-- <h6 class="text-center">Penduduk per Usia</h6> --}}
              <div style="height:310px">
                <canvas id="chartUsia"></canvas>
              </div>
            </div>

              <!-- PENDIDIKAN -->
            <div class="col-lg-4 col-md-6 mb-4">
              {{-- <h6 class="text-center">Penduduk per Pendidikan</h6> --}}
              <div style="height:350px">
                <canvas id="chartPendidikan"></canvas>
              </div>
            </div>


        </div>

      </div>

    </section><!-- /Stats Section -->

<!-- Faq Section -->
    <section id="faq" class="faq section ">

      
     

      <div class="container">

        <div class="row ">
          <!-- Section Title -->
      
          <div class="col-lg-7" data-aos="fade-up" data-aos-delay="100">
            <div class="container section-title" data-aos="fade-up">
        <h2>Pengumuman</h2>
        
      </div><!-- End Section Title -->
            @include('partials.pengumuman')

          </div>
           <!-- Section Title -->
      
          <div class="col-lg-5" data-aos="fade-up" data-aos-delay="100">
            <div class="container section-title" data-aos="fade-up">
        <h2>Agenda</h2>
        
      </div><!-- End Section Title -->
            @include('partials.agenda')

          </div>
          <!-- End Faq Column-->

        </div>

      </div>

    </section><!-- /Faq Section -->

    <!-- Pegawai Section -->
   <section id="pegawai" class="pegawai section light-background">
    <div class="container section-title" data-aos="fade-up">
      <h2>Perangkat Desa</h2>
    </div>

    <div class="container">
      <div class="swiper init-swiper pegawai-swiper" data-aos="fade-up">
        <script type="application/json" class="swiper-config">
          {
            "loop": true,
            "speed": 600,
            "autoplay": { "delay": 3500, "disableOnInteraction": false },
            "spaceBetween": 24,
            "pagination": { "el": ".pegawai-pagination", "clickable": true },
            "breakpoints": {
              "0":   { "slidesPerView": 1 },
              "768": { "slidesPerView": 2 },
              "992": { "slidesPerView": 3 }
            }
          }
        </script>
        <div class="swiper-wrapper">
          @foreach ($pegawai as $item)
            <div class="swiper-slide">
              <div class="team-member d-flex align-items-center">
                <div class="pic">
                  <img src="{{ Storage::disk('s3')->url($item->foto ?: 'images.png') }}"
                      class="img-fluid"
                      alt="{{ $item->nama_pejabat }}">
                </div>
                <div class="member-info">
                  <h4>{{ $item->nama_pejabat }}</h4>
                  <span>{{ $item->jabatan }}</span>
                </div>
              </div>
            </div>
          @endforeach
        </div>

        <div class="swiper-pagination pegawai-pagination"></div>
      </div>

    </div>
   </section>
<!-- /Pegawai Section -->

    <!-- Gallery Section -->
    <section id="gallery" class="gallery section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Galeri</h2>
        
      </div><!-- End Section Title -->

      <div class="container-fluid" data-aos="fade-up" data-aos-delay="100">

        <div class="row g-0">

          @forelse($galeri as $item)
          <div class="col-lg-3 col-md-4">
            <div class="gallery-item">
              <a href="{{ Storage::disk('s3')->url($item->foto) }}" 
                  class="glightbox" 
                  data-gallery="images-gallery"
                  data-title="{{ $item->judul }}" 
                  data-description="{{ $item->deskripsi }}"
                  data-glightbox="descPosition: right;"> 
                  <img src="{{ Storage::disk('s3')->url($item->foto) }}" 
                      class="card-img-top w-100" 
                      alt="{{ $item->judul ?? 'Galeri Desa' }}"
                      style="height: 250px; object-fit: cover;">
               
              </a>
            </div>
          </div>@empty
          <div class="col-12 text-center py-5">
              <h5 class="text-muted">Belum ada foto galeri untuk ditampilkan.</h5>
          </div>
          @endforelse

        </div>

      </div>

    </section><!-- /Gallery Section -->

<!-- Pengaduan Section -->
<section id="pengaduan" class="pengaduan section light-background">
 
  <!-- Section Title -->
  <div class="container section-title" data-aos="fade-up">
    <h2>Pengaduan Warga</h2>
    
  </div><!-- End Section Title -->
 
  <div class="container" data-aos="fade-up" data-aos-delay="100">
 
    @forelse($pengaduans as $pg)
      <div class="pengaduan-item d-flex align-items-start gap-3">

        <div class="pengaduan-avatar" style="overflow:hidden;">
          @if($pg->user && $pg->user->foto)
            <img src="{{ \App\Helpers\FotoHelper::url($pg->user->foto) }}"
                 alt="Foto Profil"
                 class="rounded-circle"
                 width="50"
                 height="50"
                 style="object-fit:cover;">
          @else
            <i class="bi bi-person-fill"></i>
          @endif
        </div>

        <div class="flex-grow-1">
          <div class="pengaduan-nama">{{ $pg->nama }}</div>
          <div class="pengaduan-meta">
            {{ \Carbon\Carbon::parse($pg->created_at)->translatedFormat('d F Y H:i') }}
            | {{ $pg->judul }}
            | {{ $pg->status }}
          </div>
          <div class="pengaduan-isi">
            @if(strlen($pg->isi) > 100)
              <span class="isi-text">{{ Str::limit($pg->isi, 100) }}</span>
              <a href="#" class="read-more" data-full="{{ e($pg->isi) }}">read more...</a>
            @else
              {{ $pg->isi }}
            @endif
          </div>
        @if($pg->balasanThread->count() > 0)
            <div class="d-flex align-items-center justify-content-between mt-2">
                <div class="pengaduan-tanggapan">
                    <i class="bi bi-chat-fill"></i> {{ $pg->balasanThread->count() }} Tanggapan
                </div>
                <a href="#" class="read-more"
                  data-bs-toggle="modal"
                  data-bs-target="#modalBalasan{{ $pg->id }}">
                    Lihat Balasan
                </a>
            </div>
        @endif
        </div>

      </div>

      {{-- MODAL BALASAN --}}
    @if($pg->balasanThread->count() > 0)
        <div class="modal fade" id="modalBalasan{{ $pg->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ $pg->judul }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">

                        {{-- PENGADUAN WARGA --}}
                        <div class="d-flex align-items-start gap-3 mb-4">
                            <div class="pengaduan-avatar" style="overflow:hidden;">
                                @if($pg->user && $pg->user->foto)
                                    <img src="{{ \App\Helpers\FotoHelper::url($pg->user->foto) }}"
                                        class="rounded-circle" width="50" height="50"
                                        style="object-fit:cover;">
                                @else
                                    <i class="bi bi-person-fill"></i>
                                @endif
                            </div>
                            <div>
                                <div class="fw-semibold">{{ $pg->nama }}</div>
                                <div class="small text-muted mb-2">
                                    {{ \Carbon\Carbon::parse($pg->created_at)->translatedFormat('d F Y H:i') }}
                                </div>
                                <div>{{ $pg->isi }}</div>
                                @if($pg->foto)
                                    <img src="{{ Storage::disk('s3')->temporaryUrl($pg->foto, now()->addMinutes(5)) }}"
                                        class="img-fluid rounded border mt-2" style="max-height:250px;">
                                @endif
                            </div>
                        </div>

                        <hr>

                        {{-- THREAD BALASAN --}}
                        @foreach($pg->balasanThread as $b)
                            <div class="d-flex align-items-start gap-3 mb-3">
                                <div class="pengaduan-avatar" style="background-color:#198754;">
                                    <i class="bi bi-building-fill text-white"></i>
                                </div>
                                <div>
                                    <div class="fw-semibold">{{ $b->user->name ?? 'Admin Desa Bengkel' }}</div>
                                    <div class="small text-muted mb-2">
                                        {{ \Carbon\Carbon::parse($b->created_at)->translatedFormat('d F Y H:i') }}
                                    </div>
                                    <div class="p-3 bg-light rounded border-start border-success border-3">
                                        {!! nl2br(e($b->isi)) !!}
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @empty
      <div class="text-center text-muted py-4">Belum ada pengaduan.</div>
    @endforelse   
  </div>
 
</section><!-- /Pengaduan Section -->

    <!-- Contact Section -->
    <section id="contact" class="contact section ">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Tentang Kami</h2>
        
      </div><!-- End Section Title -->
      <div class="mb-5" data-aos="fade-up" data-aos-delay="200">
        <div class="row gy-4">
          <div class="col-lg-8 px-50">
            <iframe style="border:0;x-pointer-events:none;" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15778.960672404477!2d116.13725769089262!3d-8.620925097403996!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dcdb8d77c2c38eb%3A0x4e9eccad2213754c!2sBengkel%2C%20Kec.%20Labuapi%2C%20Kabupaten%20Lombok%20Barat%2C%20Nusa%20Tenggara%20Bar.!5e0!3m2!1sid!2sid!4v1764176606519!5m2!1sid!2sid" 
            frameborder="0" allowfullscreen="" loading="lazy" width="100%" height="100%"></iframe>

          </div>
          <div class="col-lg-4">
            @include('partials.profil-desa')
          </div>
        </div>
        
      </div><!-- End Google Maps -->



    </section><!-- /Contact Section -->

  </main>

  <footer id="footer" class="footer light-background">

      <div class="container footer-top">
        <div class="row gy-4">

          {{-- Kolom 1: Tentang Desa --}}
          <div class="col-lg-4 col-md-6 footer-about">
            <a href="{{ route('welcome') }}" class="logo d-flex align-items-center">
              <span class="sitename">Desa Bengkel</span>
            </a>
            <div class="footer-contact pt-3">
              <p>Jl. TGH. Shaleh Hambali No:10.</p>
              <p>Desa Bengkel, Kecamatan Labuapi, Kabupaten Lombok Barat, Kode Pos 83361</p>
              <p class="mt-3"><strong>Phone:</strong> <span>0818366698, 087701047211</span></p>
              <p><strong>Email:</strong> <span>desadigital192@gmail.com</span></p>
            </div>
            {{-- <div class="social-links d-flex mt-4">
              <a href=""><i class="bi bi-twitter-x"></i></a>
              <a href=""><i class="bi bi-facebook"></i></a>
              <a href=""><i class="bi bi-instagram"></i></a>
              <a href=""><i class="bi bi-linkedin"></i></a>
            </div> --}}
          </div>

          {{-- Kolom 2: Tautan Cepat --}}
          <div class="col-lg-2 col-md-3 footer-links">
            <h4>Tautan Cepat</h4>
            <ul>
              <li><a href="{{ route('welcome') }}">Beranda</a></li>
              <li><a href="{{ route('visimisi') }}">Visi &amp; Misi</a></li>
              <li><a href="{{ route('pegawai') }}">Perangkat Desa</a></li>
              <li><a href="{{ route('berita') }}">Berita</a></li>
              <li><a href="{{ route('pengumuman') }}">Pengumuman</a></li>
            </ul>
          </div>

          {{-- Kolom 3: Layanan --}}
          <div class="col-lg-2 col-md-3 footer-links">
            <h4>Layanan</h4>
            <ul>
              <li><a href="{{ route('layanan') }}">Daftar Layanan</a></li>
              <li><a href="{{ route('layanan_mandiri') }}">Layanan Mandiri</a></li>
              <li><a href="#pengaduan" data-bs-toggle="modal" data-bs-target="#modalPengaduan">Pengaduan</a></li>
            </ul>
          </div>

          {{-- Kolom 4: Visitor Counter --}}
          <div class="col-lg-4 col-md-6 footer-links">
            <h4>Statistik Pengunjung</h4>
            <div class="p-3 rounded text-white mt-2" style="background-color: #1977cc;">
              <div class="text-center py-2">
                <div class="fw-semibold">Total Visitor Hari Ini</div>
                <hr class="border-white border-opacity-25 my-2">
                <div>{{ $visitorHariIni ?? 0 }} Visitor</div>
              </div>
              <div class="text-center py-2">
                <div class="fw-semibold">Total Visitor Sepanjang Waktu</div>
                <hr class="border-white border-opacity-25 my-2">
                <div>{{ $visitorTotal ?? 0 }} Visitor</div>
              </div>
            </div>
          </div>

        </div>
      </div>

      <div class="container copyright text-center mt-4">
        <p>© <span>{{ date('Y') }}</span> <strong class="px-1 sitename">Desa Digital</strong> <span>All Rights Reserved</span></p>
      </div>

  </footer>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Preloader -->
  <div id="preloader"></div>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>

  <!-- Main JS File -->
  <script src="assets/js/main.js"></script>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"></script>

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

<script>
document.addEventListener("DOMContentLoaded", function () {

  // =====================
  // CHART DUSUN
  // =====================
  var ctxDusun = document.getElementById('chartDusun');
  if (ctxDusun) {
    new Chart(ctxDusun, {
      type: 'doughnut',
      data: {
        labels: {!! json_encode($labelsDusun) !!},
        datasets: [{
          data: {!! json_encode($jumlahPendudukDusun) !!},
          backgroundColor: [
            '#007bff','#28a745','#ffc107',
            '#dc3545','#17a2b8','#6f42c1',
            '#fd7e14','#20c997','#6610f2'
          ]
        }]
      },
      options: {
        maintainAspectRatio: false,
        legend: {
          position: 'top',
          labels: {
            fontSize: 14,
            padding: 10,
            boxWidth: 20
          }
        }
      }
    });
  }

  // =====================
  // CHART USIA
  // =====================
  var ctxUsia = document.getElementById('chartUsia');
  if (ctxUsia) {
    new Chart(ctxUsia, {
      type: 'doughnut',
      data: {
        labels: [
          '0–15 Tahun',
          '15–30 Tahun',
          '31–60 Tahun',
          '61 Tahun ke atas'
        ],
        datasets: [{
          data: [2270, 2637, 4122, 852],
          backgroundColor: [
            '#007bff',
            '#28a745',
            '#ffc107',
            '#dc3545'
          ]
        }]
      },
      options: {
        maintainAspectRatio: false,
        legend: {
          position: 'top',
          labels: { fontSize: 14 }
        }
      }
    });
  }

  // =====================
  // CHART PENDIDIKAN
  // =====================
  var ctxPendidikan = document.getElementById('chartPendidikan');
  if (ctxPendidikan) {
    new Chart(ctxPendidikan, {
      type: 'doughnut',
      data: {
        labels: [
          'Tidak Sekolah','SD','SMP','SMA',
          'D1','D2','D3','D4','S1','S2','S3'
        ],
        datasets: [{
          data: [
            1816,3168,1763,2706,
            4,0,1,4,23,3,0
          ],
          backgroundColor: [
            '#6c757d','#007bff','#17a2b8','#28a745',
            '#ffc107','#fd7e14','#20c997',
            '#6610f2','#dc3545','#343a40','#adb5bd'
          ]
        }]
      },
      options: {
        maintainAspectRatio: false,
        legend: {
          position: 'top',
          labels: {
            fontSize: 14,
            padding: 10
          }
        },
        tooltips: {
          callbacks: {
            label: function (tooltipItem, data) {
              var label = data.labels[tooltipItem.index];
              var value = data.datasets[0].data[tooltipItem.index];
              return label + ': ' + value.toLocaleString('id-ID') + ' jiwa';
            }
          }
        }
      }
    });
  }

});
</script>

<script>
  // Read more
  document.querySelectorAll('a.read-more[data-full]').forEach(function(link) {
    link.addEventListener('click', function(e) {
      e.preventDefault();
      var full = this.getAttribute('data-full');
      var span = this.previousElementSibling;
      if (span) span.textContent = full + ' ';
      this.remove();
    });
  });
</script>






</body>

</html>