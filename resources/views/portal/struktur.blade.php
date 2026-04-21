<title>Struktur Organisasi | Website Desa Bengkel</title>
@extends('portal.layout.app')

@section('section')
 <!-- Page Title -->
    <div class="page-title" data-aos="fade">
      <div class="heading">
        <div class="container">
          <div class="row d-flex justify-content-center text-center">
            <div class="col-lg-8">
              <h1>Struktur Organisasi</h1>
              <p class="mb-0">{{ $pegawai->jabatan }}</p>
            </div>
          </div>
        </div>
      </div>
      <nav class="breadcrumbs">
        <div class="container">
          <ol>
            <li><a href="{{ route('welcome') }}">Home</a></li>
            <li><a href="{{ route('organisasi') }}">Struktur Organisasi</a></li>
             @if(isset($pegawai))
            <li class="current">
              {{ ucwords(strtolower($pegawai->jabatan)) }}
            </li>
            @endif
            
          </ol>
        </div>
      </nav>
      
    </div><!-- End Page Title -->

        <!-- Starter Section Section -->
<section id="berita" class="berita section">
    <div class="container" data-aos="fade-up">
        <div class="row g-5">
            <div class="col-lg-3">
                @include('partials.organisasi.sidebar')
            </div>
            <div class="col-lg-9">
              <article class="card-box">
                <p class="h4">{{ $pegawai->jabatan }}</p>
                <hr>

                <div class="row mb-3 p-3">
                    <div class="col-md-2">
                        <img src="{{ Storage::disk('s3')->url($pegawai->foto ?: 'images.png') }}"
                            class="img-thumbnail"
                            alt="{{ $pegawai->nama_pejabat }}">
                    </div>

                    <div class="col-md-10">
                        <dl class="row">
                            <dt class="col-sm-3">Nama Pejabat</dt>
                            <dt class="col-sm-9">: {{ $pegawai->nama_pejabat }}</dt>
                        </dl>

                        <table cellspacing="0" class="MsoTableGrid">
                            <tbody>
                                <tr>
                                    <td style="vertical-align:bottom; width:140.1pt"><p><strong>TEMPAT TANGGAL LAHIR</strong></p></td>
                                    <td style="vertical-align:bottom; width:1.0cm"><p><strong>:</strong></p></td>
                                    <td style="vertical-align:bottom; width:184.25pt">
                                        <p><strong>
                                            {{ $pegawai->tempat_lahir }},
                                            {{ $pegawai->tanggal_lahir }}
                                        </strong></p>
                                    </td>
                                </tr>

                                <tr>
                                    <td style="vertical-align:bottom; width:140.1pt"><p><strong>JENIS KELAMIN</strong></p></td>
                                    <td style="vertical-align:bottom; width:1.0cm"><p><strong>:</strong></p></td>
                                    <td style="vertical-align:bottom; width:184.25pt"><p><strong>{{ $pegawai->jenis_kelamin }}</strong></p></td>
                                </tr>

                                <tr>
                                    <td style="vertical-align:bottom; width:140.1pt"><p><strong>PENDIDIKAN</strong></p></td>
                                    <td style="vertical-align:bottom; width:1.0cm"><p><strong>:</strong></p></td>
                                    <td style="vertical-align:bottom; width:184.25pt"><p><strong>{{ $pegawai->pendidikan }}</strong></p></td>
                                </tr>

                                <tr>
                                    <td style="vertical-align:bottom; width:140.1pt"><p><strong>NOMOR SK</strong></p></td>
                                    <td style="vertical-align:bottom; width:1.0cm"><p><strong>:</strong></p></td>
                                    <td style="vertical-align:bottom; width:184.25pt"><p><strong>{{ $pegawai->nomor_sk }}</strong></p></td>
                                </tr>

                                <tr>
                                    <td style="vertical-align:bottom; width:140.1pt"><p><strong>TANGGAL SK</strong></p></td>
                                    <td style="vertical-align:bottom; width:1.0cm"><p><strong>:</strong></p></td>
                                    <td style="vertical-align:bottom; width:184.25pt"><p><strong>{{ $pegawai->tanggal_sk }}</strong></p></td>
                                </tr>

                                <tr>
                                    <td style="vertical-align:top; width:140.1pt"><p><strong>ALAMAT</strong></p></td>
                                    <td style="vertical-align:top; width:1.0cm"><p><strong>:</strong></p></td>
                                    <td style="vertical-align:top; width:184.25pt"><p><strong>{{ $pegawai->alamat }}</strong></p></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <br>
                <hr>
              </article>
            </div>
        </div>
        
  </section>
    <!-- /Starter Section Section -->
@endsection