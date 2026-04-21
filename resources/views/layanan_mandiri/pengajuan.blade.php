<title>Pengajuan Surat | Layanan Mandiri Desa Bengkel</title>
@extends('layanan_mandiri.layout.app')

@section('section')

<div class="page-title">
  <div class="container text-center">
    <h1>FORM PENGAJUAN SURAT</h1>
    <p class="mb-0">{{ $layanan->nama_layanan }}</p>
  </div>
</div>

<section class="section">
  <div class="container">

    {{-- ALERT ERROR --}}
    @if ($errors->any())
      <div class="alert alert-danger">
        <ul class="mb-0">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    @if(session('success'))
      <div class="alert alert-success">
        {{ session('success') }}
      </div>
    @endif

    <div class="card shadow-sm">
      <div class="card-body">

        {{-- INFORMASI LAYANAN --}}
        <div class="mb-4">
          <h5>{{ $layanan->nama_layanan }}</h5>
          <p class="text-muted mb-0">
            {{ $layanan->deskripsi }}
          </p>
        </div>

        <hr>

        <form action="{{ route('layanan_mandiri.store') }}"
              method="POST"
              enctype="multipart/form-data">
          @csrf

          <input type="hidden" name="layanan_id" value="{{ $layanan->id }}">

          {{-- DATA PEMOHON --}}
          <div class="mb-4">
            <h6 class="fw-semibold">Data Pemohon</h6>

            @php
              $penduduk = auth()->user()->penduduk;
            @endphp

            <div class="row">
              <div class="col-md-6 mb-3">
                <label class="form-label">Nama</label>
                <input type="text"
                       class="form-control"
                       value="{{ auth()->user()->name }}"
                       readonly>
              </div>

              <div class="col-md-6 mb-3">
                <label class="form-label">Email</label>
                <input type="text"
                       class="form-control"
                       value="{{ auth()->user()->email }}"
                       readonly>
              </div>

              <div class="col-md-6 mb-3">
                <label class="form-label">NIK</label>
                <input type="text"
                       class="form-control"
                       value="{{ $penduduk->nik ?? '-' }}"
                       readonly>
                @if(!$penduduk)
                  <small class="text-danger">
                    Data kependudukan belum terdaftar.
                    <a href="{{ route('edit_profil') }}">Lengkapi profil</a>
                  </small>
                @endif
              </div>

              <div class="col-md-6 mb-3">
                <label class="form-label">No. HP</label>
                <input type="text"
                       class="form-control"
                       value="{{ auth()->user()->no_hp ?? '-' }}"
                       readonly>
              </div>

            </div>
          </div>

          <hr>

          {{-- KEPERLUAN --}}
          <div class="mb-4">
            <label class="form-label fw-semibold">
              Keperluan <span class="text-danger">*</span>
            </label>

                @if(strtolower($layanan->kode_layanan) == 'sktm')
                    <div class="alert alert-light border mb-2 py-2">
                        <small>
                            <strong>Keperluan SKTM (contoh):</strong><br>
                            • Pengajuan bantuan pendidikan<br>
                            • Beasiswa<br>
                            • Pengobatan / rumah sakit<br>
                            • Bantuan sosial
                        </small>
                    </div>
                    
                @elseif(strtolower($layanan->kode_layanan) == 'skd')
                    <div class="alert alert-light border mb-2 py-2">
                        <small>
                            <strong>Keperluan SKD (contoh):</strong><br>
                            • Pembuatan rekening bank<br>
                            • Pendaftaran sekolah<br>
                            • Melamar pekerjaan<br>
                            • Keperluan administrasi lainnya
                        </small>
                    </div>

                @elseif(strtolower($layanan->kode_layanan) == 'sku')
                    <div class="alert alert-light border mb-2 py-2">
                        <small>
                            <strong>Keperluan SKU (contoh):</strong><br>
                            • Pengajuan kredit / pinjaman bank<br>
                            • Pendaftaran UMKM<br>
                            • Perizinan usaha<br>
                            • Keperluan administrasi usaha lainnya
                        </small>
                    </div>
                
                @elseif(strtolower($layanan->kode_layanan) == 'sr')
                    <div class="alert alert-light border mb-2 py-2">
                        <small>
                            <strong>Keperluan Surat Rekomendasi (contoh):</strong><br>
                            • Melamar pekerjaan<br>
                            • Pengajuan beasiswa<br>
                            • Pengajuan bantuan sosial<br>
                            • Keperluan administrasi ke instansi tertentu<br>
                            • Keperluan kegiatan atau pelatihan
                        </small>
                    </div>

                @elseif(strtolower($layanan->kode_layanan) == 'sppkk')
                    <div class="alert alert-light border mb-2 py-2">
                        <small>
                            <strong>Keperluan Surat Pengantar Kartu Keluarga (KK):</strong><br>
                            • Pembuatan Kartu Keluarga baru<br>
                            • Penambahan anggota keluarga (kelahiran)<br>
                            • Pengurangan anggota keluarga (kematian/pindah)<br>
                            • Perubahan data (pendidikan/pekerjaan)<br>
                            • Kartu Keluarga hilang atau rusak
                        </small>
                    </div>
                @endif

               

            <textarea name="keperluan"
                      class="form-control @error('keperluan') is-invalid @enderror"
                      rows="4"
                      required>{{ old('keperluan') }}</textarea>

            @error('keperluan')
              <div class="invalid-feedback">
                {{ $message }}
              </div>
            @enderror
          </div>

          <hr>

          {{-- FIELD DINAMIS (DETAIL LAYANAN) --}}
          <h6 class="mb-3">Data Tambahan</h6>

          @forelse($layanan->detailLayanan as $field)

          @php
            $wajib = (int) $field->wajib === 1;
            $placeholder = '';

            if(strtolower($layanan->kode_layanan) == 'sr') {
                if(str_contains(strtolower($field->keterangan), 'tujuan')) {
                    $placeholder = 'Contoh: PT Telkom Indonesia / Universitas Bumigora';
                } elseif(str_contains(strtolower($field->keterangan), 'jenis')) 
                    $placeholder = 'Contoh: Kerja / Beasiswa / Usaha';
                
            }

            if(strtolower($layanan->kode_layanan) == 'skd') {
                if(str_contains(strtolower($field->keterangan), 'lama')) {
                    $placeholder = 'Contoh: 2 tahun';
                } elseif(str_contains(strtolower($field->keterangan), 'status')) {
                    $placeholder = 'Contoh: Milik sendiri / Kontrak / Menumpang';
                }
            }
            if(strtolower($layanan->kode_layanan) == 'sppkk') {
                if(str_contains(strtolower($field->keterangan), 'alasan')) {
                    $placeholder = 'Contoh: Pembuatan KK baru, pindah domisili, atau KK rusak.';
                } 
            }
          @endphp

            <div class="mb-3">
              <label class="form-label fw-semibold">
                {{ $field->keterangan }}
                @if($wajib)
                  <span class="text-danger">*</span>
                @endif
              </label>

             @if(str_contains(strtolower($field->keterangan), 'alamat domisili'))
                <div class="mb-2"> <small class="text-muted">
                        Isi jika pindah alamat, pecah KK, atau terdapat perubahan domisili.
                    </small>
                </div>
            @endif

              @if(strtolower($layanan->kode_layanan) == 'sr')
                <small class="text-muted">
                  Isi sesuai kebutuhan surat rekomendasi
                </small>
              @endif

              @if($field->tipe_input == 'textarea')
                <textarea name="detail[{{ $field->id }}]"
                          class="form-control"
                          rows="3"
                          placeholder="{{ $placeholder }}"
                          @if($wajib) required @endif>{{ old('detail.' . $field->id) }}</textarea>

              @elseif($field->tipe_input == 'number')
                <input type="number"
                       name="detail[{{ $field->id }}]"
                       class="form-control"
                       value="{{ old('detail.' . $field->id) }}"
                       @if($wajib) required @endif>

              @elseif($field->tipe_input == 'date')
                <input type="date"
                       name="detail[{{ $field->id }}]"
                       class="form-control"
                       value="{{ old('detail.' . $field->id) }}"
                       @if($wajib) required @endif>

              @else
                <input type="text"
                      name="detail[{{ $field->id }}]"
                      class="form-control"
                      value="{{ old('detail.' . $field->id) }}"
                      placeholder="{{ $placeholder }}"
                      @if($wajib) required @endif>
              @endif

              @error('detail.' . $field->id)
                <div class="text-danger small">
                  {{ $message }}
                </div>
              @enderror
            </div>

          @empty
            <div class="alert alert-info">
              Tidak ada field tambahan untuk layanan ini.
            </div>
          @endforelse

          <hr>

          {{-- PERSYARATAN --}}
          <h6 class="mb-3">Upload Persyaratan</h6>

          @forelse($layanan->persyaratan as $item)

            @php
              $wajib = (int) $item->wajib === 1;
            @endphp

            <div class="mb-3">
              <label class="form-label fw-semibold">
                {{ $item->nama_persyaratan }}
                @if($wajib)
                  <span class="text-danger">*</span>
                @endif
              </label>

            @if(str_contains(strtolower($item->nama_persyaratan), 'lama'))
                <div class="mb-2"> <small class="text-muted">
                        Jika untuk perubahan data atau penambahan anggota.
                    </small>
                </div>
            @elseif(str_contains(strtolower($item->nama_persyaratan), 'akta'))
                <div class="mb-2"> <small class="text-muted">
                        Jika untuk penambahan anggota atau membuat KK baru.
                    </small>
                </div>
            @endif

              <input type="file"
                     name="berkas[{{ $item->id }}]"
                     class="form-control @error('berkas.' . $item->id) is-invalid @enderror"
                     @if($wajib) required @endif>

              @error('berkas.' . $item->id)
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
              @enderror

              <small class="text-muted">
                Format: PDF/JPG/PNG (maks 2MB)
              </small>
            </div>

          @empty
            <div class="alert alert-info">
              Tidak ada persyaratan untuk layanan ini.
            </div>
          @endforelse

          <div class="text-end mt-4">
            <a href="{{ route('layanan_mandiri') }}"
               class="btn btn-outline-secondary">
              Kembali
            </a>

            <button type="submit"
                    class="btn btn-primary">
              Kirim Pengajuan
            </button>
          </div>

        </form>

      </div>
    </div>

  </div>
</section>

@endsection