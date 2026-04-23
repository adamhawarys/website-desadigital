<title>Biodata | Layanan Mandiri Desa Bengkel</title>

@extends('layanan_mandiri.layout.app')

@php
$agamaOptions          = ['Islam','Kristen','Katolik','Hindu','Buddha','Konghucu'];
$pendidikanOptions     = ['Tidak/Belum Sekolah','Belum Tamat SD','Tamat SD','SLTP','SLTA','D1/D2','D3','S1','S2','S3'];
$statusKawinOptions    = ['Belum Kawin','Kawin','Cerai Hidup','Cerai Mati'];
$golDarahOptions       = ['A','B','AB','O','-'];
$shdkOptions           = ['Kepala Keluarga','Istri','Anak','Menantu','Cucu','Orang Tua','Mertua','Famili Lain','Pembantu','Lainnya'];
@endphp

@section('section')
    <div class="page-title" data-aos="fade">
      <nav class="breadcrumbs">
        <div class="container">
          <ol>
            <li><a href="">Beranda</a></li>
            <li><a href="{{ route('profil') }}">Profil</a></li>
            <li class="current">Edit Biodata</li>
          </ol>
        </div>
      </nav>
    </div>

<section id="profil" class="profil section light">
  <div class="container" data-aos="fade-up">
    <div class="row g-4">

      {{-- SIDEBAR --}}
      <div class="col-lg-3">
        @include('layanan_mandiri.sidebar')
      </div>

      {{-- CONTENT --}}
      <div class="col-lg-9">
        <div class="card shadow-sm border-0">

          {{-- HEADER --}}
          <div class="card-header bg-primary d-flex align-items-center justify-content-between">
            <div class="text-white fw-semibold">Edit Biodata Penduduk</div>
            <a href="{{ route('profil') }}" class="btn btn-light">
              <i class="fas fa-arrow-left mr-2"></i> Kembali
            </a>
          </div>

          <form action="{{ route('edit_data.update') }}" method="POST">
            @csrf

            <div class="card-body p-4">

              @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
              @endif
              @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
              @endif

              {{-- CARI NIK --}}
              <div class="mb-4">
                <label class="form-label fw-bold">Cari NIK</label>
                <div class="input-group">
                  <input type="text" id="cari_nik" class="form-control" placeholder="Masukkan NIK (16 digit)">
                  <button type="button" class="btn btn-primary" onclick="cariNik()">
                    <i class="fas fa-search me-1"></i> Cari
                  </button>
                </div>
                <div id="nik_alert" class="alert mt-3 d-none mb-0"></div>
              </div>

              <div class="row g-3">

                {{-- ===== KIRI ===== --}}
                <div class="col-md-6">

                  <div class="form-group mb-3">
                    <label class="form-label">NIK</label>
                    <input type="text" name="nik" id="nik" maxlength="16" class="form-control"
                      value="{{ old('nik', $penduduk->nik) }}">
                    @error('nik')<small class="text-danger">{{ $message }}</small>@enderror
                  </div>

                  <div class="form-group mb-3">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" id="nama_lengkap" maxlength="100" class="form-control"
                      value="{{ old('nama_lengkap', $penduduk->nama_lengkap) }}">
                    @error('nama_lengkap')<small class="text-danger">{{ $message }}</small>@enderror
                  </div>

                  <div class="form-group mb-3">
                    <label class="form-label">Jenis Kelamin</label>
                    <select name="jenis_kelamin" id="jenis_kelamin" class="form-control">
                      <option value="" disabled>-- Pilih --</option>
                      <option value="L" {{ old('jenis_kelamin', $penduduk->jenis_kelamin) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                      <option value="P" {{ old('jenis_kelamin', $penduduk->jenis_kelamin) == 'P' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                    @error('jenis_kelamin')<small class="text-danger">{{ $message }}</small>@enderror
                  </div>

                  <div class="form-group mb-3">
                    <label class="form-label">No KK</label>
                    <input type="text" name="kk" id="kk" maxlength="16" class="form-control"
                      value="{{ old('kk', $penduduk->kk) }}">
                  </div>

                  <div class="form-group mb-3">
                    <label class="form-label">Tempat Lahir</label>
                    <input type="text" name="tempat_lahir" id="tempat_lahir" maxlength="50" class="form-control"
                      value="{{ old('tempat_lahir', $penduduk->tempat_lahir) }}">
                  </div>

                  <div class="form-group mb-3">
                    <label class="form-label">Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="form-control"
                      value="{{ old('tanggal_lahir', optional($penduduk->tanggal_lahir)->format('Y-m-d')) }}">
                  </div>

                  <div class="form-group mb-3">
                    <label class="form-label">Alamat</label>
                    <textarea name="alamat" id="alamat" class="form-control" rows="3">{{ old('alamat', $penduduk->alamat) }}</textarea>
                  </div>

                  <div class="row g-3">
                    <div class="col-md-4">
                      <div class="form-group mb-3">
                        <label class="form-label">RT</label>
                        <input type="text" name="rt" id="rt" maxlength="3" class="form-control"
                          value="{{ old('rt', $penduduk->rt) }}">
                      </div>
                    </div>
                    <div class="col-md-8">
                      <div class="form-group mb-3">
                        <label class="form-label">Dusun</label>
                        <input type="text" name="dusun" id="dusun" maxlength="50" class="form-control"
                          value="{{ old('dusun', $penduduk->dusun) }}">
                      </div>
                    </div>
                  </div>

                  <div class="form-group mb-3">
                    <label class="form-label">Desa</label>
                    <input type="text" name="desa" id="desa" maxlength="50" class="form-control"
                      value="{{ old('desa', $penduduk->desa) }}">
                  </div>

                  <div class="form-group mb-3">
                    <label class="form-label">Kecamatan</label>
                    <input type="text" name="kecamatan" id="kecamatan" maxlength="50" class="form-control"
                      value="{{ old('kecamatan', $penduduk->kecamatan) }}">
                  </div>

                </div>

                {{-- ===== KANAN ===== --}}
                <div class="col-md-6">

                  <div class="form-group mb-3">
                    <label class="form-label">Agama</label>
                    <select name="agama" id="agama" class="form-control">
                      <option value="">-- Pilih --</option>
                      @foreach($agamaOptions as $opt)
                        <option value="{{ $opt }}" {{ old('agama', $penduduk->agama) == $opt ? 'selected' : '' }}>
                          {{ $opt }}
                        </option>
                      @endforeach
                    </select>
                  </div>

                  <div class="form-group mb-3">
                    <label class="form-label">Pendidikan</label>
                    <select name="pendidikan" id="pendidikan" class="form-control">
                      <option value="">-- Pilih --</option>
                      @foreach($pendidikanOptions as $opt)
                        <option value="{{ $opt }}" {{ old('pendidikan', $penduduk->pendidikan) == $opt ? 'selected' : '' }}>
                          {{ $opt }}
                        </option>
                      @endforeach
                    </select>
                  </div>

                  <div class="form-group mb-3">
                    <label class="form-label">Kewarganegaraan</label>
                    <input type="text" name="kewarganegaraan" id="kewarganegaraan" maxlength="30" class="form-control"
                      value="{{ old('kewarganegaraan', $penduduk->kewarganegaraan ?? 'Indonesia') }}">
                  </div>

                  <div class="form-group mb-3">
                    <label class="form-label">Status Perkawinan</label>
                    <select name="status_perkawinan" id="status_perkawinan" class="form-control">
                      <option value="">-- Pilih --</option>
                      @foreach($statusKawinOptions as $opt)
                        <option value="{{ $opt }}" {{ old('status_perkawinan', $penduduk->status_perkawinan) == $opt ? 'selected' : '' }}>
                          {{ $opt }}
                        </option>
                      @endforeach
                    </select>
                  </div>

                  <div class="form-group mb-3">
                    <label class="form-label">Golongan Darah</label>
                    <select name="gol_darah" id="gol_darah" class="form-control">
                      <option value="">-- Pilih --</option>
                      @foreach($golDarahOptions as $opt)
                        <option value="{{ $opt }}" {{ old('gol_darah', $penduduk->gol_darah) == $opt ? 'selected' : '' }}>
                          {{ $opt }}
                        </option>
                      @endforeach
                    </select>
                  </div>

                  <div class="form-group mb-3">
                    <label class="form-label">SHDK</label>
                    <select name="shdk" id="shdk" class="form-control">
                      <option value="">-- Pilih --</option>
                      @foreach($shdkOptions as $opt)
                        <option value="{{ $opt }}" {{ old('shdk', $penduduk->shdk) == $opt ? 'selected' : '' }}>
                          {{ $opt }}
                        </option>
                      @endforeach
                    </select>
                  </div>

                  <div class="form-group mb-3">
                    <label class="form-label">Pekerjaan</label>
                    <input type="text" name="pekerjaan" id="pekerjaan" maxlength="50" class="form-control"
                      value="{{ old('pekerjaan', $penduduk->pekerjaan) }}">
                  </div>

                  <div class="form-group mb-3">
                    <label class="form-label">Nama Ayah</label>
                    <input type="text" name="ayah" id="ayah" maxlength="100" class="form-control"
                      value="{{ old('ayah', $penduduk->ayah) }}">
                  </div>

                  <div class="form-group mb-0">
                    <label class="form-label">Nama Ibu</label>
                    <input type="text" name="ibu" id="ibu" maxlength="100" class="form-control"
                      value="{{ old('ibu', $penduduk->ibu) }}">
                  </div>

                </div>
              </div>

            </div>

            <div class="card-footer bg-white d-flex justify-content-end p-3">
              <button type="submit" class="btn btn-primary">
                <i class="fas fa-save me-1"></i> Simpan
              </button>
            </div>

          </form>
        </div>
      </div>

    </div>
  </div>
</section>

<script>
// Daftar pilihan enum — sama persis dengan database
const enumOptions = {
  agama:           ['Islam','Kristen','Katolik','Hindu','Buddha','Konghucu'],
  pendidikan:      ['Tidak/Belum Sekolah','Belum Tamat SD','Tamat SD','SLTP','SLTA','D1/D2','D3','S1','S2','S3'],
  status_perkawinan: ['Belum Kawin','Kawin','Cerai Hidup','Cerai Mati'],
  gol_darah:       ['A','B','AB','O','-'],
  shdk:            ['Kepala Keluarga','Istri','Anak','Menantu','Cucu','Orang Tua','Mertua','Famili Lain','Pembantu','Lainnya'],
};

// Set nilai <select> dengan aman
function setSelect(name, value) {
  const el = document.querySelector('[name=' + name + ']');
  if (!el) return;
  const opt = [...el.options].find(o => o.value === value);
  el.value = opt ? value : '';
}

function setVal(name, value) {
  const el = document.querySelector('[name=' + name + ']');
  if (el) el.value = value ?? '';
}

function cariNik() {
  const nik      = document.getElementById('cari_nik').value.trim();
  const alertBox = document.getElementById('nik_alert');

  alertBox.className  = 'alert mt-3 d-none mb-0';
  alertBox.innerText  = '';

  if (nik.length !== 16) {
    alertBox.classList.remove('d-none');
    alertBox.classList.add('alert-danger');
    alertBox.innerText = 'NIK harus terdiri dari 16 digit.';
    return;
  }

  fetch("{{ route('cari.nik') }}", {
    method:  'POST',
    headers: {
      'Content-Type':  'application/json',
      'X-CSRF-TOKEN':  '{{ csrf_token() }}'
    },
    body: JSON.stringify({ nik })
  })
  .then(r => r.json())
  .then(res => {
    if (res.status === 'error') {
      alertBox.classList.remove('d-none');
      alertBox.classList.add('alert-danger');
      alertBox.innerText = res.message || 'Data NIK tidak ditemukan di database.';
      return;
    }

    if (res.status === 'success') {
      alertBox.classList.remove('d-none');
      alertBox.classList.add('alert-success');
      alertBox.innerText = 'Data ditemukan dan berhasil dimuat.';

      const d = res.data || {};

      // Input biasa
      setVal('nik',            d.nik);
      setVal('nama_lengkap',   d.nama_lengkap);
      setVal('kk',             d.kk);
      setVal('tempat_lahir',   d.tempat_lahir);
      setVal('tanggal_lahir',  d.tanggal_lahir);
      setVal('alamat',         d.alamat);
      setVal('rt',             d.rt);
      setVal('dusun',          d.dusun);
      setVal('desa',           d.desa);
      setVal('kecamatan',      d.kecamatan);
      setVal('kewarganegaraan',d.kewarganegaraan);
      setVal('pekerjaan',      d.pekerjaan);
      setVal('ayah',           d.ayah);
      setVal('ibu',            d.ibu);

      // Select enum
      setSelect('jenis_kelamin',      d.jenis_kelamin);
      setSelect('agama',              d.agama);
      setSelect('pendidikan',         d.pendidikan);
      setSelect('status_perkawinan',  d.status_perkawinan);
      setSelect('gol_darah',          d.gol_darah);
      setSelect('shdk',               d.shdk);
    } else {
      alertBox.classList.remove('d-none');
      alertBox.classList.add('alert-danger');
      alertBox.innerText = 'Response tidak valid dari server.';
    }
  })
  .catch(() => {
    alertBox.classList.remove('d-none');
    alertBox.classList.add('alert-danger');
    alertBox.innerText = 'Terjadi kesalahan server. Silakan coba kembali.';
  });
}
</script>

@endsection