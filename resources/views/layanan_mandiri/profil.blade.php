<title>Profil | Layanan Mandiri Desa Bengkel</title>

@extends('layanan_mandiri.layout.app')
@section('section')
    <div class="page-title" data-aos="fade">
      
      <nav class="breadcrumbs">
        <div class="container">
          <ol>
            <li><a href="{{ route('layanan_mandiri') }}">Beranda</a></li>
            <li class="current">Profil</li>
          </ol>
        </div>
      </nav>
    </div><!-- End Page Title -->
<section id="profil" class="profil section light">
    
<div class="container" data-aos="fade-up">
    
    <div class="row g-5">
        <div class="col-lg-3">
            @include('layanan_mandiri.sidebar')
        </div>
        <div class="col-lg-9">
            <div class="card profile-card">
                <div class="card-header bg-primary d-flex align-items-center justify-content-between">
                    <div class="text-white fw-semibold">
                        Informasi Akun
                    </div>

                </div>
                <div class="profile-section">

                    <div class="profile-item">
                        <div class="profile-label">Nama</div>
                        <div class="profile-value">{{ auth()->user()->name }}</div>
                    </div>

                    <div class="profile-item">
                        <div class="profile-label">Email</div>
                        <div class="profile-value">
                            {{ auth()->user()->email }}
                            
                        </div>
                    </div>
                    <div class="profile-item">
                        <div class="profile-label">No HP</div>
                        <div class="profile-value">
                            {{ auth()->user()->no_hp }}
                            
                        </div>
                    </div>
                </div>

            </div>
            <br>

            <div  iv class="card profile-card">
                <div class="card-header bg-primary d-flex align-items-center justify-content-between">
                    <div class="text-white fw-semibold">
                        Biodata Penduduk
                    </div>

                </div>
                <div class="profile-section">
                        <h6>Biodata Penduduk</h6>

                        @if(!$penduduk)
                            <div class="alert alert-warning">
                                Data penduduk belum diisi.
                                <a href="{{ route('edit_data') }}">Lengkapi Profil</a>
                            </div>
                        @else

                        <div class="profile-item">
                            <div class="profile-label">NIK</div>
                            <div class="profile-value">{{ $penduduk->nik ?? '-' }}</div>
                        </div>

                        <div class="profile-item">
                            <div class="profile-label">Nomor KK</div>
                            <div class="profile-value">{{ $penduduk->kk ?? '-' }}</div>
                        </div>

                        <div class="profile-item">
                            <div class="profile-label">Nama Lengkap</div>
                            <div class="profile-value">{{ $penduduk->nama_lengkap ?? '-' }}</div>
                        </div>

                        <div class="profile-item">
                            <div class="profile-label">Jenis Kelamin</div>
                            <div class="profile-value">
                                {{ $penduduk->jenis_kelamin == 'L' ? 'Laki-Laki' : 'Perempuan' }}
                            </div>
                        </div>

                        <div class="profile-item">
                            <div class="profile-label">Tempat / Tgl Lahir</div>
                            <div class="profile-value">
                                {{ $penduduk->tempat_lahir ?? '-' }},
                                {{ $penduduk->tanggal_lahir?->format('d-m-Y') ?? '-' }}
                            </div>
                        </div>

                        <div class="profile-item">
                            <div class="profile-label">Agama</div>
                            <div class="profile-value">{{ $penduduk->agama ?? '-' }}</div>
                        </div>

                        <div class="profile-item">
                            <div class="profile-label">Pendidikan</div>
                            <div class="profile-value">{{ $penduduk->pendidikan ?? '-' }}</div>
                        </div>

                        <div class="profile-item">
                            <div class="profile-label">Pekerjaan</div>
                            <div class="profile-value">{{ $penduduk->pekerjaan ?? '-' }}</div>
                        </div>

                        <div class="profile-item">
                            <div class="profile-label">Alamat</div>
                            <div class="profile-value">
                                {{ $penduduk->alamat ?? '-' }},
                                RT {{ $penduduk->rt ?? '-' }},
                                Dusun {{ $penduduk->dusun ?? '-' }},
                                Desa {{ $penduduk->desa ?? '-' }},
                                Kecamatan {{ $penduduk->kecamatan ?? '-' }}
                            </div>
                        </div>

                        @endif
                </div>  
            </div>
        </div>
        </div>
</div>
</div>

</section>
@endsection
