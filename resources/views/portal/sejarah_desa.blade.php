<title>Sejarah Desa | Website Desa Bengkel</title>
@extends('portal.layout.app')

@section('section')
  <!-- Page Title -->
    <div class="page-title" data-aos="fade">
        <div class="heading">
          <div class="container">
            <div class="row d-flex justify-content-center text-center">
              <div class="col-lg-8">
                <h1>Sejarah Desa</h1>
                <p class="mb-0">DESA BENGKEL - KECAMATAN LABUAPI</p>
              </div>
            </div>
          </div>
        </div>

        <nav class="breadcrumbs">
          <div class="container">
            <ol>
              <li><a href="{{ route('welcome') }}">Home</a></li>
              <li class="current">Sejarah Desa</li>
            </ol>
          </div>
        </nav>
    </div><!-- End Page Title -->

    <!-- Starter Section Section -->
    <section id="sejarah" class="sejarah section">
    <div class="container" data-aos="fade-up">
        <div class="row g-5">
          <div class="col-xl-8">
            <div class="card-wrapper">
              <div class="card-box">
                <h2 class="card-title">Sejarah Desa</h2>
                <div class="card-text">
                  {!! $sejarah->sejarah !!}
                </div>

                <hr class="my-4">

                <h4 class="mt-4 mb-3">Daftar Kepala Desa Bengkel</h4>

                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead class="table-dark text-center">
                            <tr>
                                <th style="width: 60px;">No</th>
                                <th>Nama Kepala Desa</th>
                                <th style="width: 180px;">Masa Jabatan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr><td class="text-center">1</td><td>Amen Teker</td><td class="text-center">-</td></tr>
                            <tr><td class="text-center">2</td><td>Amen Bosok</td><td class="text-center">-</td></tr>
                            <tr><td class="text-center">3</td><td>Bapen Jidah</td><td class="text-center">-</td></tr>
                            <tr><td class="text-center">4</td><td>Haji Abdullah</td><td class="text-center">1921 – 1930</td></tr>
                            <tr><td class="text-center">5</td><td>Putrajab</td><td class="text-center">1930 – 1936</td></tr>
                            <tr><td class="text-center">6</td><td>Haji Abdul Hamid</td><td class="text-center">1936 – 1938</td></tr>
                            <tr><td class="text-center">7</td><td>Mustapa</td><td class="text-center">1938 – 1940</td></tr>
                            <tr><td class="text-center">8</td><td>Haji Ridwan Merembu</td><td class="text-center">1940 – 1949</td></tr>
                            <tr><td class="text-center">9</td><td>Rajab</td><td class="text-center">1949 – 1955</td></tr>
                            <tr><td class="text-center">10</td><td>Bapak Nakiah</td><td class="text-center">1955 – 1960</td></tr>
                            <tr><td class="text-center">11</td><td>Haji Muhtar</td><td class="text-center">1961 – 1966</td></tr>
                            <tr><td class="text-center">12</td><td>Haji Jalal Mahri</td><td class="text-center">1966 – 1967</td></tr>
                            <tr><td class="text-center">13</td><td>Mohamad Athar</td><td class="text-center">1967 – 1968</td></tr>
                            <tr><td class="text-center">14</td><td>Ahmad Hermain</td><td class="text-center">1968 – 1970</td></tr>
                            <tr><td class="text-center">15</td><td>Keniludin</td><td class="text-center">1970 – 1973</td></tr>
                            <tr><td class="text-center">16</td><td>Haji Ahmad Ramli</td><td class="text-center">1973 – 1987</td></tr>
                            <tr><td class="text-center">17</td><td>Haji Abdul Hamid</td><td class="text-center">1988 – 1997</td></tr>
                            <tr><td class="text-center">18</td><td>Haji Halisussabri, S.Pd</td><td class="text-center">1997 – 2005</td></tr>
                            <tr><td class="text-center">19</td><td>Akhmad Parhan</td><td class="text-center">2005 – 2011</td></tr>
                            <tr><td class="text-center">20</td><td>H. Muhamad Idrus, Sp</td><td class="text-center">2011 – 2017</td></tr>
                            <tr><td class="text-center">21</td><td>H. Muhamad Idrus, Sp</td><td class="text-center">2017 – 2023</td></tr>
                            <tr><td class="text-center">22</td><td>H. Muhamad Idrus, Sp</td><td class="text-center">2023 – Sekarang</td></tr>
                        </tbody>
                    </table>
                </div>
              </div>
            </div>
        </div>
  

        <div class="col-xl-4">
          
          @include('partials.profil-desa')
        </div>
               
        </div>
      
  </section>
    <!-- /Starter Section Section -->

@endsection