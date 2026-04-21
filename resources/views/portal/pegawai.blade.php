<title>Perangkat Desa | Website Desa Bengkel</title>
@extends('portal.layout.app')

@section('section')
 <!-- Page Title -->
    <div class="page-title" data-aos="fade">
      <div class="heading">
        <div class="container">
          <div class="row d-flex justify-content-center text-center">
            <div class="col-lg-8">
              <h1>Perangkat Desa</h1>
              <p class="mb-0">DESA BENGKEL - KECAMATAN LABUAPI</p>
            </div>
          </div>
        </div>
      </div>
      <nav class="breadcrumbs">
        <div class="container">
          <ol>
            <li><a href="{{ route('welcome') }}">Home</a></li>
            <li class="current">Perangkat Desa</li>
          </ol>
        </div>
      </nav>
    </div><!-- End Page Title -->

        <!-- Starter Section Section -->
<section id="pegawai" class="pegawai section">
    <div class="container" data-aos="fade-up">
        <div class="row g-4">
            @foreach ($pegawai as $item)
            <div class="col-6 col-sm-4 col-md-3 col-lg-2 pegawai-item">
                <div class="pegawai-card" style="min-height: 380px;">
                    <a href="{{ Storage::disk('s3')->url($item->foto ?: 'images.png') }}" class="glightbox" data-glightbox="description: .desc_{{ $item->id }}; descPosition: right;" data-gallery="pegawai-gallery"></a>
                    <img src="{{ Storage::disk('s3')->url($item->foto ?: 'images.png') }}" class="img-fluid" alt="{{ $item->nama_pejabat }}">
                    <div class="glightbox-desc desc_{{ $item->id }}">
                        <h4>{{ $item->nama_pejabat }}</h4>
                        <p >{{ $item->jabatan }}</p>
                        <table cellspacing="0" class="MsoTableGrid" style="border-collapse:collapse; border:undefined">
                            <tbody>
                                <tr>
                                    <td style="vertical-align:bottom; width:140.1pt">
                                        <p><strong>TEMPAT TANGGAL LAHIR</strong></p>
                                    </td>
                                    <td style="vertical-align:bottom; width:1.0cm">
                                        <p><strong>:</strong></p>
                                    </td>
                                    <td style="vertical-align:bottom; width:184.25pt">
                                        <p><strong>{{ $item->tempat_lahir }},{{ $item->tanggal_lahir }} </strong></p>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="vertical-align:bottom; width:140.1pt">
                                        <p><strong>JENIS KELAMIN</strong></p>
                                    </td>
                                    <td style="vertical-align:bottom; width:1.0cm">
                                        <p><strong>:</strong></p>
                                    </td>
                                    <td style="vertical-align:bottom; width:184.25pt">
                                        <p><strong>{{ $item->jenis_kelamin }} </strong></p>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="vertical-align:bottom; width:140.1pt">
                                        <p><strong>PENDIDIKAN</strong></p>
                                    </td>
                                    <td style="vertical-align:bottom; width:1.0cm">
                                        <p><strong>:</strong></p>
                                    </td>
                                    <td style="vertical-align:bottom; width:184.25pt">
                                        <p><strong>{{ $item->pendidikan }} </strong></p>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="vertical-align:bottom; width:140.1pt">
                                        <p><strong>NOMOR SK</strong></p>
                                    </td>
                                    <td style="vertical-align:bottom; width:1.0cm">
                                        <p><strong>:</strong></p>
                                    </td>
                                    <td style="vertical-align:bottom; width:184.25pt">
                                        <p><strong>{{ $item->nomor_sk }} </strong></p>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="vertical-align:bottom; width:140.1pt">
                                        <p><strong>TANGGAL SK</strong></p>
                                    </td>
                                    <td style="vertical-align:bottom; width:1.0cm">
                                        <p><strong>:</strong></p>
                                    </td>
                                    <td style="vertical-align:bottom; width:184.25pt">
                                        <p><strong>{{ $item->tanggal_sk }} </strong></p>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="vertical-align:top; width:140.1pt">
                                        <p><strong>ALAMAT</strong></p>
                                    </td>
                                    <td style="vertical-align:top; width:1.0cm">
                                        <p><strong>:</strong></p>
                                    </td>
                                    <td style="vertical-align:top; width:184.25pt">
                                        <p><strong>{{ $item->alamat }} </strong></p>
                                    </td>
                                </tr>
                                
                            </tbody>
                        </table>
                    </div>
                    <div class="pegawai-info">
                        <a href="{{ Storage::disk('s3')->url($item->foto ?: 'images.png') }}" class="glightbox" data-glightbox="description: .desc_{{ $item->id }}; descPosition: right;" data-gallery="pegawai-gallery">
                        <h4 >{{ $item->nama_pejabat }}</h4>
                        <p >{{ $item->jabatan }}</p>
                        </a>    
                        
                    </div>
                </div>
            </div>
            @endforeach
            {{-- <div class="col-lg-8">
                <div class="row gy-4 pegwai-container">
                </div>
            </div> --}}
        </div>
        
  </section>
    <!-- /Starter Section Section -->
@endsection