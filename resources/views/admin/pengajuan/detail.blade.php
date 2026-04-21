<title>Dashboard | Detail Pengajuan</title>
@extends('layout.master')

@section('content')
<div class="content-wrapper" style="min-height: 1302.4px;">

    {{-- HEADER --}}
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Detail Pengajuan</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('dashboard') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('pengajuan.index') }}">Data Pengajuan</a>
                        </li>
                        <li class="breadcrumb-item active">Detail</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    {{-- CONTENT --}}
    <section class="content">
        <div class="card">

            <div class="card-header">
                <h3 class="card-title">Informasi Pengajuan</h3>

                <div class="card-tools">
                    <a href="{{ route('pengajuan.index') }}" class="btn btn-sm btn-secondary">
                        <i class="fas fa-arrow-left mr-1"></i> Kembali
                    </a>
                </div>
            </div>

            <div class="card-body">

                {{-- STATUS --}}
                <div class="mb-4 text-center">
                    @php $st = $pengajuan->status ?? '-'; @endphp

                    @if($st == 'Menunggu Diproses')
                        <span class="badge badge-warning p-2" style="font-size: 14px;">Menunggu Diproses</span>
                    @elseif($st == 'Disetujui')
                        <span class="badge badge-success p-2" style="font-size: 14px;">Disetujui</span>
                    @elseif($st == 'Ditolak')
                        <span class="badge badge-danger p-2" style="font-size: 14px;">Ditolak</span>
                    @else
                        <span class="badge badge-secondary p-2" style="font-size: 14px;">{{ $st }}</span>
                    @endif
                </div>

                <div class="row">

                    {{-- DATA PEMOHON --}}
                    <div class="col-md-6">
                        <div class="border p-3 mb-3 h-100 rounded">
                            <h5 class="mb-3 border-bottom pb-2"><strong>Data Pemohon</strong></h5>

                            <p class="mb-2">
                                <span class="text-muted">Nama Akun :</span><br>
                                <strong>{{ $pengajuan->user->name ?? '-' }}</strong>
                            </p>

                            <p class="mb-2">
                                <span class="text-muted">Nama (Biodata) :</span><br>
                                <strong>{{ $pengajuan->user->penduduk->nama_lengkap ?? '-' }}</strong>
                            </p>

                            <p class="mb-2">
                                <span class="text-muted">Email :</span><br>
                                <strong>{{ $pengajuan->user->email ?? '-' }}</strong>
                            </p>

                            <p class="mb-0">
                                <span class="text-muted">NIK :</span><br>
                                <strong>{{ $pengajuan->user->penduduk->nik ?? '-' }}</strong>
                            </p>
                        </div>
                    </div>

                    {{-- DATA LAYANAN --}}
                    <div class="col-md-6">
                        <div class="border p-3 mb-3 h-100 rounded">
                            <h5 class="mb-3 border-bottom pb-2"><strong>Data Layanan</strong></h5>

                            <p class="mb-2">
                                <span class="text-muted">Nama Layanan :</span><br>
                                <strong>{{ $pengajuan->layanan->nama_layanan ?? '-' }}</strong>
                            </p>

                            <p class="mb-2">
                                <span class="text-muted">Tanggal Pengajuan :</span><br>
                                <strong>
                                    {{ $pengajuan->tanggal_pengajuan 
                                        ? \Carbon\Carbon::parse($pengajuan->tanggal_pengajuan)->format('d-m-Y H:i') 
                                        : '-' }}
                                </strong>
                            </p>

                            <p class="mb-0">
                                <span class="text-muted">Keperluan :</span><br>
                                <strong>{{ $pengajuan->keperluan ?? '-' }}</strong>
                            </p>
                        </div>
                    </div>

                </div>

                {{-- ========================= --}}
                {{-- DETAIL LAYANAN (ISIAN) --}}
                {{-- ========================= --}}
                <h5 class="mt-4 mb-3 border-bottom pb-2"><strong>Detail Layanan (Isian Pemohon)</strong></h5>

                @php
                    $detailIsian = $pengajuan->detail ?? collect();
                @endphp

                @if($detailIsian->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm table-striped">
                            <thead class="thead-light">
                                <tr>
                                    <th style="width:35%;">Keterangan</th>
                                    <th>Isi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($detailIsian as $d)
                                    <tr>
                                        <td>{{ $d->detailLayanan->keterangan ?? '-' }}</td>
                                        <td><strong>{{ $d->isi ?? '-' }}</strong></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="alert alert-info mb-0">
                        <i class="fas fa-info-circle mr-1"></i> Tidak ada detail layanan tambahan yang diisi.
                    </div>
                @endif

                {{-- ========================= --}}
                {{-- PERSYARATAN & DOKUMEN --}}
                {{-- ========================= --}}
                <h5 class="mt-4 mb-3 border-bottom pb-2"><strong>Persyaratan & Dokumen</strong></h5>

                @if($pengajuan->layanan && $pengajuan->layanan->persyaratan->count() > 0)
                    <ul class="list-group mt-2">
                        @foreach($pengajuan->layanan->persyaratan as $persyaratan)

                            @php
                                $berkas = $pengajuan->berkas
                                    ->where('persyaratan_id', $persyaratan->id)
                                    ->first();

                                $filePath = $berkas->file_path ?? null;
                                $fileUrl  = null;
                                
                                if ($filePath) {
                                    try {
                                        // Menggunakan temporaryUrl untuk AWS S3
                                        $fileUrl = Storage::disk('s3')->temporaryUrl(
                                            $filePath, now()->addMinutes(30)
                                        );
                                    } catch (\Exception $e) {
                                        $fileUrl = null;
                                    }
                                }
                                $ext = $filePath ? strtolower(pathinfo($filePath, PATHINFO_EXTENSION)) : '';
                            @endphp

                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <strong>{{ $persyaratan->nama_persyaratan }}</strong>

                                    @if((int)$persyaratan->wajib === 1)
                                        <span class="badge badge-danger ml-2">Wajib</span>
                                    @endif

                                    @if($fileUrl)
                                        <div class="small text-success mt-1"><i class="fas fa-check-circle"></i> File Terunggah ({{ strtoupper($ext) }})</div>
                                    @else
                                        <div class="small text-danger mt-1"><i class="fas fa-times-circle"></i> Belum ada file</div>
                                    @endif
                                </div>

                                <div class="d-flex align-items-center" style="gap:6px;">
                                    @if($fileUrl)
                                        <button type="button"
                                                class="btn btn-sm btn-primary btn-preview shadow-sm"
                                                data-toggle="modal"
                                                data-target="#modalPreview"
                                                data-url="{{ $fileUrl }}"
                                                data-ext="{{ $ext }}"
                                                data-title="{{ $persyaratan->nama_persyaratan }}">
                                            <i class="fas fa-eye mr-1"></i> Preview
                                        </button>

                                        <a href="{{ $fileUrl }}"
                                           target="_blank"
                                           class="btn btn-sm btn-outline-secondary shadow-sm">
                                            <i class="fas fa-external-link-alt mr-1"></i> Buka
                                        </a>
                                    @else
                                        <span class="badge badge-warning px-3 py-2">Belum Upload</span>
                                    @endif
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <div class="alert alert-info mt-2 mb-0">
                        <i class="fas fa-info-circle mr-1"></i> Tidak ada persyaratan dokumen untuk layanan ini.
                    </div>
                @endif


                {{-- ========================= --}}
                {{-- ACTION BAR (SETUJUI / TOLAK) --}}
                {{-- ========================= --}}
                @if(($pengajuan->status ?? '') === 'Menunggu Diproses')
                    <div class="mt-5 pt-3 border-top d-flex justify-content-end align-items-center flex-wrap" style="gap:10px;">
                        <div class="d-flex" style="gap:8px;">
                            <button type="button" class="btn btn-danger px-4" data-toggle="modal" data-target="#modalReject">
                                <i class="fas fa-times mr-1"></i> Tolak
                            </button>
                            
                            <button type="button" class="btn btn-success px-4" data-toggle="modal" data-target="#modalApprove">
                                <i class="fas fa-check mr-1"></i> Setujui
                            </button>
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </section>
</div>

{{-- ========================= --}}
{{-- KUMPULAN MODAL --}}
{{-- ========================= --}}

<div class="modal fade" id="modalPreview" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">

            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title" id="previewTitle">Preview Dokumen</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body bg-light" style="height:80vh">
                <iframe id="previewFrame"
                        src=""
                        width="100%"
                        height="100%"
                        style="border:none; display:none; background-color: white;">
                </iframe>

                <div class="text-center" style="height:100%; display:none;" id="previewImageWrap">
                    <img id="previewImage"
                         src=""
                         alt="Preview"
                         class="img-fluid shadow-sm border"
                         style="max-height:100%; object-fit: contain;" />
                </div>

                <div id="previewFallback" class="alert alert-info text-center" style="display:none; margin-top: 20%;">
                    <i class="fas fa-file-download fa-3x mb-3 text-secondary"></i><br>
                    Preview tidak tersedia untuk tipe file ini.<br>Silakan buka file di tab baru untuk melihatnya.
                </div>
            </div>

            <div class="modal-footer">
                <a id="openLink" href="#" target="_blank" class="btn btn-primary">
                    <i class="fas fa-external-link-alt mr-1"></i> Buka di Tab Baru
                </a>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="modalApprove" tabindex="-1" role="dialog" aria-labelledby="modalApproveLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('pengajuan.approve', $pengajuan->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title" id="modalApproveLabel"><i class="fas fa-check-circle mr-2"></i> Konfirmasi Persetujuan</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="mb-0">Apakah Anda yakin semua berkas sudah benar dan ingin menyetujui pengajuan layanan <strong>{{ $pengajuan->layanan->nama_layanan ?? 'ini' }}</strong> dari <strong>{{ $pengajuan->user->penduduk->nama_lengkap ?? 'pemohon' }}</strong>?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success"><i class="fas fa-check mr-1"></i> Ya, Setujui Pengajuan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalReject" tabindex="-1" role="dialog" aria-labelledby="modalRejectLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('pengajuan.reject', $pengajuan->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="modalRejectLabel"><i class="fas fa-exclamation-triangle mr-2"></i> Konfirmasi Penolakan</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menolak pengajuan ini?</p>
                    
                    <div class="form-group">
                        <label for="keterangan_tolak">Alasan Penolakan <span class="text-danger">*</span></label>
                        <textarea name="keterangan" id="keterangan_tolak" rows="3" class="form-control" placeholder="Berikan alasan (contoh: KTP buram, Form F-1.15 belum ditandatangani...)" required></textarea>
                        <small class="text-muted">Alasan ini akan dilihat oleh pemohon agar mereka dapat memperbaikinya.</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger"><i class="fas fa-times mr-1"></i> Ya, Tolak Pengajuan</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- SCRIPT --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    var titleEl = document.getElementById('previewTitle');
    var frame = document.getElementById('previewFrame');
    var imgWrap = document.getElementById('previewImageWrap');
    var img = document.getElementById('previewImage');
    var fallback = document.getElementById('previewFallback');
    var openLink = document.getElementById('openLink');

    function resetPreview() {
        frame.style.display = 'none';
        frame.src = '';
        imgWrap.style.display = 'none';
        img.src = '';
        fallback.style.display = 'none';
        openLink.href = '#';
    }

    document.querySelectorAll('.btn-preview').forEach(function (btn) {
        btn.addEventListener('click', function () {
            resetPreview();

            var url = this.getAttribute('data-url');
            var ext = (this.getAttribute('data-ext') || '').toLowerCase();
            var t = this.getAttribute('data-title') || 'Preview Dokumen';

            titleEl.textContent = 'Preview: ' + t;
            openLink.href = url;

            if (['jpg','jpeg','png','webp','gif'].includes(ext)) {
                imgWrap.style.display = 'flex';
                imgWrap.style.alignItems = 'center';
                imgWrap.style.justifyContent = 'center';
                img.src = url;
                return;
            }

            if (ext === 'pdf') {
                frame.style.display = 'block';
                frame.src = url;
                return;
            }

            fallback.style.display = 'block';
        });
    });

    $('#modalPreview').on('hidden.bs.modal', function () {
        resetPreview();
    });
});
</script>
@endsection