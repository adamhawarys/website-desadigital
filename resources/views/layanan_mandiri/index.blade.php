<title>Beranda | Layanan Mandiri Desa Bengkel</title>
@extends('layanan_mandiri.layout.app')

@section('section')

{{-- BANNER SNS --}}
@if(auth()->user() && !auth()->user()->sns_confirmed)
<div class="alert alert-warning m-0 rounded-0 border-0 border-bottom"
     style="background: #fff8e1; border-left: 5px solid #f59e0b !important;">
  <div class="container d-flex align-items-center justify-content-between flex-wrap gap-2 py-2">
    <div class="d-flex align-items-center gap-2">
      <i class="bi bi-envelope-exclamation-fill text-warning fs-5"></i>
      <div>
        <strong>Aktifkan notifikasi email Anda!</strong>
        <div class="small text-muted">
          Cek email dari <strong>no-reply@sns.amazonaws.com</strong> dan klik link konfirmasi
          agar bisa menerima notifikasi dan informasi dari Website Desa Digital Bengkel.
        </div>
      </div>
    </div>
    <a href="https://mail.google.com/mail/u/0/#search/from%3Asns.amazonaws.com"
       target="_blank"
       class="btn btn-sm btn-warning fw-semibold">
      <i class="bi bi-google me-1"></i> Buka Gmail
    </a>
  </div>
</div>
@endif

<!-- Page Title -->
<div class="page-title" data-aos="fade">
  <div class="heading">
    <div class="container">
      <div class="row d-flex justify-content-center text-center">
        <div class="col-lg-8">
          <h1>SELAMAT DATANG DI <br> LAYANAN MANDIRI DESA BENGKEL</h1>
          <p class="mb-0">{{ auth()->user()->name }}</p>
        </div>
      </div>
    </div>
  </div>
  <nav class="breadcrumbs">
    <div class="container">
      <ol>
        <li><a href="{{ route('layanan_mandiri') }}">Beranda</a></li>
        <li class="current">-</li>
      </ol>
    </div>
  </nav>
</div><!-- End Page Title -->

<section class="section">
  <div class="container" data-aos="fade-up">

    {{-- STATUS DATA PENDUDUK (tampilkan hanya jika belum terhubung) --}}
    @if(!$penduduk)
      <div class="alert alert-warning d-flex align-items-center justify-content-between flex-wrap gap-2">
        <div>
          <strong>Data penduduk belum terhubung.</strong>
          <div class="small text-muted">Silakan hubungkan NIK agar dapat menggunakan layanan.</div>
        </div>

        <a href="{{ route('edit_data') }}" class="btn btn-sm btn-primary">
          Hubungkan Data
        </a>
      </div>
    @endif

{{-- MENU UTAMA --}}
<div class="row gy-4 mt-3 justify-content-center">

  <div class="col-lg-4 col-md-6">
    <div class="card text-center shadow-sm h-100">
      <div class="card-body">
        <i class="bi bi-person fs-1 text-primary"></i>
        <h5 class="mt-3">Profil Saya</h5>
        <p class="small text-muted">
          Lihat dan perbarui data pribadi Anda.
        </p>
        <a href="{{ route('profil') }}" class="btn btn-outline-primary btn-sm">
          Buka Profil
        </a>
      </div>
    </div>
  </div>

  <div class="col-lg-4 col-md-6">
    <div class="card text-center shadow-sm h-100">
      <div class="card-body">
        <i class="bi bi-pencil-square fs-1 text-success"></i>
        <h5 class="mt-3">Perbarui Data</h5>
        <p class="small text-muted">
          Edit atau lengkapi data penduduk Anda.
        </p>
        <a href="{{ route('edit_data') }}" class="btn btn-outline-success btn-sm">
          Edit Data
        </a>
      </div>
    </div>
  </div>

  <div class="col-lg-4 col-md-6">
    <div class="card text-center shadow-sm h-100">
      <div class="card-body">
        <i class="bi bi-megaphone fs-1 text-danger"></i>
        <h5 class="mt-3">Pengaduan</h5>
        <p class="small text-muted">
          Sampaikan pengaduan atau aspirasi Anda kepada desa.
        </p>
        <button type="button"
                class="btn btn-outline-danger btn-sm"
                data-bs-toggle="modal"
                data-bs-target="#modalPengaduan">
          Buat Pengaduan
        </button>
      </div>
    </div>
  </div>

</div>

@include('pengaduan.modal')

    {{-- RIWAYAT PENGAJUAN --}}
    <div class="card shadow-sm mt-5">
      <div class="card-header d-flex align-items-center justify-content-between">
        <strong>Riwayat Pengajuan</strong>

        @if($penduduk)
    <a href="{{ route('layanan_mandiri.layanan') }}" class="btn btn-sm btn-primary">
        <i class="bi bi-plus-circle me-1"></i> Ajukan Baru
    </a>
        @else
            <button class="btn btn-sm btn-secondary" disabled>
                <i class="bi bi-plus-circle me-1"></i> Ajukan Baru
            </button>
        @endif
      </div>

      <div class="card-body">
        @php
          $items = $riwayatPengajuan ?? collect();
        @endphp

        @if($items->count() === 0)
          <div class="text-center text-muted py-4">
            Belum ada riwayat pengajuan.
          </div>
        @else
          <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle mb-0">
              <thead class="table-light">
                <tr>
                  <th class="text-center" style="width: 70px;">No</th>
                  <th class="text-center" style="width: 180px;">Layanan</th>
                  <th class="text-center" style="width: 180px;">Tanggal</th>
                  <th class="text-center" style="width: 180px;">Status</th>
                  <th class="text-center" style="width: 200px;">Aksi</th>
                </tr>
              </thead>
              <tbody>
                @foreach($items as $i => $p)
                  @php $st = $p->status ?? '-'; @endphp
                  <tr>
                    <td class="text-center">{{ $i + 1 }}</td>

                    <td>{{ $p->layanan->nama_layanan ?? '-' }}</td>

                    <td class="text-center">
                      {{ \Carbon\Carbon::parse($p->tanggal_pengajuan)->format('d-m-Y') }}
                    </td>

                    <td class="text-center">
                      @if($st === 'Menunggu Diproses')
                        <span class="badge bg-warning text-dark">{{ $st }}</span>
                      @elseif($st === 'Disetujui')
                        <span class="badge bg-success">{{ $st }}</span>
                      @elseif($st === 'Ditolak')
                        <span class="badge bg-danger">{{ $st }}</span>
                      @else
                        <span class="badge bg-secondary">{{ $st }}</span>
                      @endif
                    </td>

                    <td class="text-center">
                        <div class="d-flex justify-content-center align-items-center gap-2 flex-nowrap">

                            <button type="button"
                                    class="btn btn-sm btn-outline-secondary"
                                    data-bs-toggle="modal"
                                    data-bs-target="#previewPengajuan{{ $p->id }}">
                                <i class="bi bi-eye"></i> Detail
                            </button>

                            @if($p->layanan && $p->layanan->template_surat)
                                <a href="{{ route('layanan_mandiri.preview_surat', $p->id) }}"
                                  class="btn btn-sm btn-outline-primary"
                                  target="_blank">
                                    <i class="bi bi-file-earmark-text"></i> Preview
                                </a>
                            @endif

                            {{-- DOWNLOAD (SELALU ADA) --}}
                            <a href="{{ $st === 'Disetujui' && $p->surat_pdf ? route('layanan_mandiri.download_surat', $p->id) : '#' }}"
                              class="btn btn-sm btn-success {{ $st !== 'Disetujui' || !$p->surat_pdf ? 'disabled' : '' }}"
                              tabindex="{{ $st !== 'Disetujui' || !$p->surat_pdf ? '-1' : '' }}"
                              aria-disabled="{{ $st !== 'Disetujui' || !$p->surat_pdf ? 'true' : 'false' }}"
                              title="{{ $st === 'Disetujui' ? 'Download Surat' : 'Belum bisa download' }}">
                                <i class="bi bi-download"></i> Download
                            </a>

                        </div>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>

          {{-- MODAL DI LUAR TABLE (biar HTML valid) --}}
          @foreach($items as $p)
            @php
              $st = $p->status ?? '-';
            @endphp

            <div class="modal fade" id="previewPengajuan{{ $p->id }}" tabindex="-1" aria-hidden="true">
              <div class="modal-dialog modal-lg modal-dialog-scrollable">
                <div class="modal-content">

                  <div class="modal-header">
                    <h5 class="modal-title">Preview Pengajuan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>

                  <div class="modal-body">

                    {{-- RINGKAS --}}
                    <div class="row g-3 mb-3">
                      <div class="col-md-6">
                        <small class="text-muted d-block">Layanan</small>
                        <div class="fw-semibold">{{ $p->layanan->nama_layanan ?? '-' }}</div>
                      </div>

                      <div class="col-md-6">
                        <small class="text-muted d-block">Status</small>
                        <div>
                          @if($st === 'Menunggu Diproses')
                            <span class="badge bg-warning text-dark">{{ $st }}</span>
                          @elseif($st === 'Disetujui')
                            <span class="badge bg-success">{{ $st }}</span>
                          @elseif($st === 'Ditolak')
                            <span class="badge bg-danger">{{ $st }}</span>
                          @else
                            <span class="badge bg-secondary">{{ $st }}</span>
                          @endif
                        </div>
                      </div>

                      <div class="col-md-6">
                        <small class="text-muted d-block">Tanggal Pengajuan</small>
                        <div class="fw-semibold">
                          {{ \Carbon\Carbon::parse($p->tanggal_pengajuan)->format('d-m-Y H:i') }}
                        </div>
                      </div>

                      <div class="col-md-6">
                        <small class="text-muted d-block">Nomor Surat</small>
                        <div class="fw-semibold">{{ $p->nomor_surat ?? '-' }}</div>
                      </div>

                      <div class="col-12">
                        <small class="text-muted d-block">Keperluan</small>
                        <div class="p-3 bg-light rounded">
                          {{ $p->keperluan ?? '-' }}
                        </div>
                      </div>
                    </div>

                    <hr>

                    {{-- DETAIL ISIAN --}}
                    <h6 class="mb-2">Detail Isian</h6>
                    @if(($p->detail ?? collect())->count())
                      <div class="table-responsive mb-3">
                        <table class="table table-sm table-bordered align-middle mb-0">
                          <thead class="table-light">
                            <tr>
                              <th style="width: 35%;">Keterangan</th>
                              <th>Isi</th>
                            </tr>
                          </thead>
                          <tbody>
                            @forelse(($p->detail ?? collect()) as $d)
                              <tr>
                                <td>{{ $d->detailLayanan->keterangan ?? '-' }}</td>
                                <td>{{ $d->isi ?? '-' }}</td>
                              </tr>
                            @empty
                              <tr>
                                <td colspan="2" class="text-center text-muted">
                                  Tidak ada detail isian.
                                </td>
                              </tr>
                            @endforelse
                          </tbody>
                        </table>
                      </div>
                    @else
                      <div class="text-muted mb-3">Tidak ada detail tambahan.</div>
                    @endif

                    <hr>

                    {{-- BERKAS --}}
                    <h6 class="mb-2">Berkas Terlampir</h6>
                    @if(($p->berkas ?? collect())->count())
                      <div class="row g-3">
                        @foreach($p->berkas as $b)
                          @php
                              $filePath = $b->file_path ?? null;
                              $ext      = $filePath ? strtolower(pathinfo($filePath, PATHINFO_EXTENSION)) : '';
                              $fileUrl  = null;
                              if ($filePath) {
                                  try {
                                      $fileUrl = Storage::disk('s3')->temporaryUrl(
                                          $filePath, now()->addMinutes(30)
                                      );
                                  } catch (\Exception $e) {
                                      $fileUrl = null;
                                  }
                              }
                          @endphp

                          <div class="col-md-6">
                            <div class="border rounded p-3">
                              <div class="fw-semibold mb-2">
                                {{ $b->persyaratan->nama_persyaratan ?? 'Berkas' }}
                              </div>

                              @if(!$fileUrl)
                                <div class="text-muted">File tidak tersedia.</div>

                              {{-- ====== GAMBAR: pakai GLightbox (zoom) ====== --}}
                              @elseif(in_array($ext, ['jpg','jpeg','png','webp']))
                                <a href="{{ $fileUrl }}"
                                   class="glightbox"
                                   data-gallery="pengajuan-{{ $p->id }}"
                                   data-title="{{ $b->persyaratan->nama_persyaratan ?? 'Berkas' }}">
                                  <img src="{{ $fileUrl }}"
                                       class="img-fluid rounded border"
                                       alt="Berkas"
                                       style="max-height:220px; width:100%; object-fit:cover; cursor:zoom-in;">
                                </a>

                                <div class="mt-2 text-end">
                                  <a href="{{ $fileUrl }}"
                                     class="btn btn-sm btn-outline-primary glightbox"
                                     data-gallery="pengajuan-{{ $p->id }}"
                                     data-title="{{ $b->persyaratan->nama_persyaratan ?? 'Berkas' }}">
                                    Lihat Detail
                                  </a>
                                </div>

                              {{-- ====== PDF: tetap iframe ====== --}}
                              @elseif($ext === 'pdf')
                                <iframe src="{{ $fileUrl }}"
                                        width="100%"
                                        height="400"
                                        class="border rounded"></iframe>

                              @else
                                <div class="text-muted">Preview tidak tersedia untuk tipe file ini.</div>
                              @endif
                            </div>
                          </div>
                        @endforeach
                      </div>
                    @else
                      <div class="text-muted">Tidak ada berkas terlampir.</div>
                    @endif

                  </div>

                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">
                      Tutup
                    </button>
                  </div>

                </div>
              </div>
            </div>
          @endforeach
          {{-- END MODAL --}}
        @endif
      </div>
    </div>

  {{-- RIWAYAT PENGADUAN --}}
<div class="card shadow-sm mt-4">
  <div class="card-header d-flex align-items-center justify-content-between">
    <strong>Riwayat Pengaduan</strong>
  </div>

  <div class="card-body p-0">
    @php $pengaduans = $riwayatPengaduan ?? collect(); @endphp

    @if($pengaduans->count() === 0)
      <div class="text-center text-muted py-4">
        Belum ada riwayat pengaduan.
      </div>
    @else
      @foreach($pengaduans as $pg)
        <div class="border-bottom p-3" style="background:#f8f9fa;">
          <div class="d-flex align-items-start gap-3">
            <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center flex-shrink-0"
                style="width:42px;height:42px;overflow:hidden;">
                <img src="{{ \App\Helpers\FotoHelper::url(auth()->user()->foto) }}"
                    alt="Foto Profil"
                    class="rounded-circle"
                    width="42"
                    height="42"
                    style="object-fit:cover;">
            </div>
            <div class="flex-grow-1">
              <div class="d-flex align-items-center justify-content-between flex-wrap gap-1">
                <span class="fw-semibold">{{ $pg->nama }}</span>
                @if($pg->status === 'menunggu')
                  <span class="badge bg-warning text-dark">Menunggu diproses</span>
                @elseif($pg->status === 'selesai')
                  <span class="badge bg-success">Selesai</span>
                @else
                  <span class="badge bg-secondary">{{ $pg->status }}</span>
                @endif
              </div>
              <div class="small text-muted">
                {{ \Carbon\Carbon::parse($pg->created_at)->format('Y-m-d H:i:s') }}
                | {{ $pg->judul }}
                | {{ $pg->status }}
              </div>
              <div class="mt-2">{{ $pg->isi }}</div>

              @if($pg->balasan)
                <div class="mt-2 d-flex align-items-center justify-content-end gap-1 text-muted small">
                  <i class="bi bi-chat-fill"></i>
                  <span>{{ $pg->tanggapan_count ?? 1 }} Tanggapan</span>
                </div>
              @endif

              <div class="mt-2">
                <button type="button"
                        class="btn btn-sm btn-outline-secondary"
                        data-bs-toggle="modal"
                        data-bs-target="#detailPengaduan{{ $pg->id }}">
                  <i class="bi bi-eye"></i> Lihat Detail
                </button>
              </div>
            </div>
          </div>
        </div>
      @endforeach

      {{-- MODAL DETAIL PENGADUAN --}}
      @foreach($pengaduans as $pg)
        <div class="modal fade" id="detailPengaduan{{ $pg->id }}" tabindex="-1" aria-hidden="true">
          <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Detail Pengaduan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
              </div>
              <div class="modal-body">
                <div class="row g-3">
                  <div class="col-md-6">
                    <small class="text-muted d-block">Judul</small>
                    <div class="fw-semibold">{{ $pg->judul }}</div>
                  </div>
                  <div class="col-md-6">
                    <small class="text-muted d-block">Status</small>
                    @if($pg->status === 'menunggu')
                      <span class="badge bg-warning text-dark">Menunggu diproses</span>
                    @elseif($pg->status === 'diproses')
                      <span class="badge bg-secondary">Diproses</span>
                    @else
                      <span class="badge bg-success">{{ $pg->status }}</span>
                    @endif
                  </div>
                  <div class="col-12">
                    <small class="text-muted d-block">Isi Pengaduan</small>
                    <div class="p-3 bg-light rounded">{{ $pg->isi }}</div>
                  </div>
                  @if($pg->foto)
                    <div class="col-12">
                      <small class="text-muted d-block">Foto/Bukti</small>
                      <img src="{{ Storage::disk('s3')->url($pg->foto) }}"
                           class="img-fluid rounded border mt-1"
                           style="max-height:300px;">
                    </div>
                  @endif
                  @if($pg->balasan)
                      <div class="col-12">
                          <small class="text-muted d-block">Balasan dari Admin</small>
                          <div class="p-3 bg-light rounded border-start border-success border-3">
                              {!! nl2br(e($pg->balasan)) !!}
                          </div>
                          <small class="text-muted">
                              {{ $pg->tanggal_balasan ? \Carbon\Carbon::parse($pg->tanggal_balasan)->translatedFormat('d F Y H:i') : '' }}
                          </small>
                      </div>
                  @endif      
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Tutup</button>
              </div>
            </div>
          </div>
        </div>
      @endforeach
    @endif
  </div>
</div>

  
</section>

{{-- INIT GLIGHTBOX --}}
<script>
  document.addEventListener('DOMContentLoaded', function () {
    if (typeof GLightbox !== 'undefined') {
      GLightbox({ selector: '.glightbox' });
    }
  });
</script>
@endsection