<title>Profil | Layanan Mandiri Desa Bengkel</title>

@extends('layanan_mandiri.layout.app')

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
    </div><!-- End Page Title -->
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
            <div class="text-white fw-semibold">
              Edit Biodata Penduduk
            </div>

            <a href="{{ route('profil') }}" class="btn btn-light">
              <i class="fas fa-arrow-left mr-2"></i> Kembali
            </a>
          </div>

          <form action="{{ route('edit_data.update') }}" method="POST">
            @csrf

            <div class="card-body p-4">

              {{-- ALERT GLOBAL (opsional) --}}
              @if(session('success'))
                <div class="alert alert-success">
                  {{ session('success') }}
                </div>
              @endif

              @if(session('error'))
                <div class="alert alert-danger">
                  {{ session('error') }}
                </div>
              @endif

              {{-- 🔍 CARI NIK --}}
              <div class="mb-4">
                <label class="form-label fw-bold">Cari NIK</label>
                <div class="input-group">
                  <input type="text" id="cari_nik" class="form-control" placeholder="Masukkan NIK (16 digit)">
                  <button type="button" class="btn btn-primary" onclick="cariNik()">
                    <i class="fas fa-search me-1"></i> Cari
                  </button>
                </div>

                {{-- NOTIFIKASI HASIL PENCARIAN --}}
                <div id="nik_alert" class="alert mt-3 d-none mb-0"></div>
              </div>

              <div class="row g-3">
                {{-- ===== KIRI ===== --}}
                <div class="col-md-6">
                  <div class="form-group mb-3">
                    <label class="form-label">NIK</label>
                    <input type="text" name="nik" id="nik" class="form-control"
                      value="{{ old('nik', $penduduk->nik) }}">
                    @error('nik') <small class="text-danger">{{ $message }}</small> @enderror
                  </div>

                  <div class="form-group mb-3">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" id="nama_lengkap" class="form-control"
                      value="{{ old('nama_lengkap', $penduduk->nama_lengkap) }}">
                    @error('nama_lengkap') <small class="text-danger">{{ $message }}</small> @enderror
                  </div>

                  <div class="form-group mb-3">
                    <label class="form-label">Jenis Kelamin</label>
                    <select name="jenis_kelamin" id="jenis_kelamin" class="form-control">
                      <option value="" disabled selected>-- Pilih --</option>
                      <option value="L" {{ old('jenis_kelamin', $penduduk->jenis_kelamin) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                      <option value="P" {{ old('jenis_kelamin', $penduduk->jenis_kelamin) == 'P' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                    @error('jenis_kelamin') <small class="text-danger">{{ $message }}</small> @enderror
                  </div>

                  <div class="form-group mb-3">
                    <label class="form-label">No KK</label>
                    <input type="text" name="kk" id="kk" class="form-control"
                      value="{{ old('kk', $penduduk->kk) }}">
                    @error('kk') <small class="text-danger">{{ $message }}</small> @enderror
                  </div>

                  <div class="form-group mb-3">
                    <label class="form-label">Tempat Lahir</label>
                    <input type="text" name="tempat_lahir" id="tempat_lahir" class="form-control"
                      value="{{ old('tempat_lahir', $penduduk->tempat_lahir) }}">
                    @error('tempat_lahir') <small class="text-danger">{{ $message }}</small> @enderror
                  </div>

                  <div class="form-group mb-3">
                    <label class="form-label">Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="form-control"
                      value="{{ old('tanggal_lahir', optional($penduduk->tanggal_lahir)->format('Y-m-d')) }}">
                    @error('tanggal_lahir') <small class="text-danger">{{ $message }}</small> @enderror
                  </div>

                  <div class="form-group mb-3">
                    <label class="form-label">Alamat</label>
                    <input type="text" name="alamat" id="alamat" class="form-control"
                      value="{{ old('alamat', $penduduk->alamat) }}">
                    @error('alamat') <small class="text-danger">{{ $message }}</small> @enderror
                  </div>

                  <div class="row g-3">
                    <div class="col-md-4">
                      <div class="form-group mb-3">
                        <label class="form-label">RT</label>
                        <input type="text" name="rt" id="rt" class="form-control"
                          value="{{ old('rt', $penduduk->rt) }}">
                        @error('rt') <small class="text-danger">{{ $message }}</small> @enderror
                      </div>
                    </div>

                    <div class="col-md-8">
                      <div class="form-group mb-3">
                        <label class="form-label">Dusun</label>
                        <input type="text" name="dusun" id="dusun" class="form-control"
                          value="{{ old('dusun', $penduduk->dusun) }}">
                        @error('dusun') <small class="text-danger">{{ $message }}</small> @enderror
                      </div>
                    </div>
                  </div>

                  <div class="form-group mb-3">
                    <label class="form-label">Desa</label>
                    <input type="text" name="desa" id="desa" class="form-control"
                      value="{{ old('desa', $penduduk->desa) }}">
                    @error('desa') <small class="text-danger">{{ $message }}</small> @enderror
                  </div>

                  <div class="form-group mb-3">
                    <label class="form-label">Kecamatan</label>
                    <input type="text" name="kecamatan" id="kecamatan" class="form-control"
                      value="{{ old('kecamatan', $penduduk->kecamatan) }}">
                    @error('kecamatan') <small class="text-danger">{{ $message }}</small> @enderror
                  </div>
                </div>

                {{-- ===== KANAN ===== --}}
                <div class="col-md-6">
                  <div class="form-group mb-3">
                    <label class="form-label">Agama</label>
                    <input type="text" name="agama" id="agama" class="form-control"
                      value="{{ old('agama', $penduduk->agama) }}">
                    @error('agama') <small class="text-danger">{{ $message }}</small> @enderror
                  </div>

                  <div class="form-group mb-3">
                    <label class="form-label">Pendidikan</label>
                    <input type="text" name="pendidikan" id="pendidikan" class="form-control"
                      value="{{ old('pendidikan', $penduduk->pendidikan) }}">
                    @error('pendidikan') <small class="text-danger">{{ $message }}</small> @enderror
                  </div>

                  <div class="form-group mb-3">
                    <label class="form-label">Kewarganegaraan</label>
                    <input type="text" name="kewarganegaraan" id="kewarganegaraan" class="form-control"
                      value="{{ old('kewarganegaraan', 'Indonesia') }}">
                    @error('kewarganegaraan') <small class="text-danger">{{ $message }}</small> @enderror
                  </div>

                  <div class="form-group mb-3">
                    <label class="form-label">Status Perkawinan</label>
                    <input type="text" name="status_perkawinan" id="status_perkawinan" class="form-control"
                      value="{{ old('status_perkawinan', $penduduk->status_perkawinan) }}">
                    @error('status_perkawinan') <small class="text-danger">{{ $message }}</small> @enderror
                  </div>

                  <div class="form-group mb-3">
                    <label class="form-label">Golongan Darah</label>
                    <input type="text" name="gol_darah" id="gol_darah" class="form-control"
                      value="{{ old('gol_darah', $penduduk->gol_darah) }}">
                    @error('gol_darah') <small class="text-danger">{{ $message }}</small> @enderror
                  </div>

                  <div class="form-group mb-3">
                    <label class="form-label">SHDK</label>
                    <input type="text" name="shdk" id="shdk" class="form-control"
                      value="{{ old('shdk', $penduduk->shdk) }}">
                    @error('shdk') <small class="text-danger">{{ $message }}</small> @enderror
                  </div>

                  <div class="form-group mb-3">
                    <label class="form-label">Pekerjaan</label>
                    <input type="text" name="pekerjaan" id="pekerjaan" class="form-control"
                      value="{{ old('pekerjaan', $penduduk->pekerjaan) }}">
                    @error('pekerjaan') <small class="text-danger">{{ $message }}</small> @enderror
                  </div>

                  <div class="form-group mb-3">
                    <label class="form-label">Ayah</label>
                    <input type="text" name="ayah" id="ayah" class="form-control"
                      value="{{ old('ayah', $penduduk->ayah) }}">
                    @error('ayah') <small class="text-danger">{{ $message }}</small> @enderror
                  </div>

                  <div class="form-group mb-0">
                    <label class="form-label">Ibu</label>
                    <input type="text" name="ibu" id="ibu" class="form-control"
                      value="{{ old('ibu', $penduduk->ibu) }}">
                    @error('ibu') <small class="text-danger">{{ $message }}</small> @enderror
                  </div>
                </div>
              </div>

            </div>

            {{-- FOOTER --}}
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
function cariNik() {
  const nik = document.getElementById('cari_nik').value.trim();
  const alertBox = document.getElementById('nik_alert');

  // reset alert
  alertBox.className = 'alert mt-3 d-none mb-0';
  alertBox.innerText = '';

  // validasi panjang
  if (nik.length !== 16) {
    alertBox.classList.remove('d-none');
    alertBox.classList.add('alert-danger');
    alertBox.innerText = 'NIK harus terdiri dari 16 digit.';
    return;
  }

  fetch("{{ route('cari.nik') }}", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
      "X-CSRF-TOKEN": "{{ csrf_token() }}"
    },
    body: JSON.stringify({ nik })
  })
  .then(res => res.json())
  .then(res => {

    // kalau response error (dari controller Anda)
    if (res.status === 'error') {
      alertBox.classList.remove('d-none');
      alertBox.classList.add('alert-danger');
      alertBox.innerText = res.message || 'Data NIK tidak ditemukan di database.';
      return;
    }

    // kalau sukses
    if (res.status === 'success') {
      alertBox.classList.remove('d-none');
      alertBox.classList.add('alert-success');
      alertBox.innerText = 'Data ditemukan dan berhasil dimuat.';

      const d = res.data || {};

      document.querySelector('[name=nik]').value = d.nik ?? '';
      document.querySelector('[name=nama_lengkap]').value = d.nama_lengkap ?? '';
      document.querySelector('[name=jenis_kelamin]').value = d.jenis_kelamin ?? '';
      document.querySelector('[name=kk]').value = d.kk ?? '';
      document.querySelector('[name=tempat_lahir]').value = d.tempat_lahir ?? '';
      document.querySelector('[name=tanggal_lahir]').value = d.tanggal_lahir ?? '';
      document.querySelector('[name=alamat]').value = d.alamat ?? '';
      document.querySelector('[name=rt]').value = d.rt ?? '';
      document.querySelector('[name=dusun]').value = d.dusun ?? '';
      document.querySelector('[name=desa]').value = d.desa ?? '';
      document.querySelector('[name=kecamatan]').value = d.kecamatan ?? '';
      document.querySelector('[name=agama]').value = d.agama ?? '';
      document.querySelector('[name=pendidikan]').value = d.pendidikan ?? '';
      document.querySelector('[name=kewarganegaraan]').value = d.kewarganegaraan ?? '';
      document.querySelector('[name=status_perkawinan]').value = d.status_perkawinan ?? '';
      document.querySelector('[name=gol_darah]').value = d.gol_darah ?? '';
      document.querySelector('[name=shdk]').value = d.shdk ?? '';
      document.querySelector('[name=pekerjaan]').value = d.pekerjaan ?? '';
      document.querySelector('[name=ayah]').value = d.ayah ?? '';
      document.querySelector('[name=ibu]').value = d.ibu ?? '';
    } else {
      // fallback jika struktur response tidak sesuai
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