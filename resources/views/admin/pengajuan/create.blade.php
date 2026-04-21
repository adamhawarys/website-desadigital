<title>Dashboard | Tambah Pengajuan</title>
@extends('layout.master')

@section('content')
<div class="content-wrapper">

  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6"><h1>Tambah Pengajuan</h1></div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('pengajuan.index') }}">Data Pengajuan</a></li>
            <li class="breadcrumb-item active">Tambah Pengajuan</li>
          </ol>
        </div>
      </div>
    </div>
  </section>

  <section class="content">
    <div class="card">

      <div class="card-header d-flex align-items-center justify-content-between">
        <h3 class="card-title mb-0">Form Tambah Pengajuan (Admin)</h3>
        <a href="{{ route('pengajuan.index') }}" class="btn btn-sm btn-secondary ml-auto">
          <i class="fas fa-arrow-left mr-1"></i> Kembali
        </a>
      </div>

      <form action="{{ route('pengajuan.store') }}" method="POST" autocomplete="off">
        @csrf

        <div class="card-body">

          @if ($errors->any())
            <div class="alert alert-danger">
              <ul class="mb-0">
                @foreach ($errors->all() as $e) <li>{{ $e }}</li> @endforeach
              </ul>
            </div>
          @endif

          {{-- MODE --}}
          <input type="hidden" name="pemohon_mode" id="pemohon_mode" value="{{ old('pemohon_mode','manual') }}">
          <input type="hidden" name="penduduk_id" id="penduduk_id" value="{{ old('penduduk_id') }}">

          {{-- ===================== --}}
          {{-- CARI NIK --}}
          {{-- ===================== --}}
          <div class="form-group">
            <label class="font-weight-bold">Cari NIK Pemohon</label>
            <div class="input-group">
              <input type="text" id="cari_nik" class="form-control" placeholder="Masukkan 16 digit NIK">
              <div class="input-group-append">
                <button type="button" class="btn btn-primary" id="btnCariNik">
                  <i class="fas fa-search mr-1"></i> Cari
                </button>
              </div>
            </div>
            <small id="nik_msg" class="d-block mt-1"></small>
          </div>

          {{-- ===================== --}}
          {{-- DATA PEMOHON (HASIL CARI) --}}
          {{-- ===================== --}}
          <div id="boxFound" class="border rounded p-3 mb-3 d-none" style="background:#f8fbff;">
            <div class="d-flex justify-content-between align-items-center flex-wrap" style="gap:8px;">
              <div>
                <div class="font-weight-bold">Data Pemohon (Dari Database)</div>
                <div class="text-muted small">Field terkunci karena data ditemukan.</div>
              </div>
              <button type="button" class="btn btn-sm btn-outline-secondary" id="btnGantiManual">
                Isi Manual
              </button>
            </div>

            <hr class="my-3">

            <div class="row">
              <div class="col-md-6 mb-2">
                <small class="text-muted d-block">Nama Lengkap</small>
                <div class="font-weight-bold" id="f_nama">-</div>
              </div>
              <div class="col-md-6 mb-2">
                <small class="text-muted d-block">NIK</small>
                <div class="font-weight-bold" id="f_nik">-</div>
              </div>
              <div class="col-12">
                <small class="text-muted d-block">Alamat</small>
                <div id="f_alamat">-</div>
              </div>
            </div>
          </div>

          {{-- ===================== --}}
          {{-- DATA PEMOHON MANUAL --}}
          {{-- ===================== --}}
          <div id="boxManual" class="border rounded p-3 mb-3" style="background:#fff;">
            <div class="d-flex justify-content-between align-items-center flex-wrap" style="gap:8px;">
              <div>
                <div class="font-weight-bold">Data Pemohon (Manual)</div>
                <div class="text-muted small">Isi jika NIK tidak ditemukan.</div>
              </div>
              <button type="button" class="btn btn-sm btn-outline-secondary d-none" id="btnKembaliFound">
                Kembali ke Data Ditemukan
              </button>
            </div>

            <hr class="my-3">

            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>NIK <span class="text-danger">*</span></label>
                  <input type="text" name="pemohon_nik" id="pemohon_nik"
                         class="form-control"
                         value="{{ old('pemohon_nik') }}"
                         placeholder="16 digit">
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <label>Nama Lengkap <span class="text-danger">*</span></label>
                  <input type="text" name="pemohon_nama_lengkap" id="pemohon_nama_lengkap"
                         class="form-control"
                         value="{{ old('pemohon_nama_lengkap') }}"
                         placeholder="Nama sesuai KTP">
                </div>
              </div>

              <div class="col-md-12">
                <div class="form-group">
                  <label>Alamat</label>
                  <input type="text" name="pemohon_alamat" id="pemohon_alamat"
                         class="form-control"
                         value="{{ old('pemohon_alamat') }}">
                </div>
              </div>

              <div class="col-md-3">
                <div class="form-group">
                  <label>RT</label>
                  <input type="text" name="pemohon_rt" id="pemohon_rt"
                         class="form-control"
                         value="{{ old('pemohon_rt') }}">
                </div>
              </div>

              <div class="col-md-3">
                <div class="form-group">
                  <label>Dusun</label>
                  <input type="text" name="pemohon_dusun" id="pemohon_dusun"
                         class="form-control"
                         value="{{ old('pemohon_dusun') }}">
                </div>
              </div>

              <div class="col-md-3">
                <div class="form-group">
                  <label>Desa</label>
                  <input type="text" name="pemohon_desa" id="pemohon_desa"
                         class="form-control"
                         value="{{ old('pemohon_desa') }}">
                </div>
              </div>

              <div class="col-md-3">
                <div class="form-group">
                  <label>Kecamatan</label>
                  <input type="text" name="pemohon_kecamatan" id="pemohon_kecamatan"
                         class="form-control"
                         value="{{ old('pemohon_kecamatan') }}">
                </div>
              </div>
            </div>
          </div>

          <hr>

          {{-- ===================== --}}
          {{-- LAYANAN --}}
          {{-- ===================== --}}
          <div class="form-group">
            <label class="font-weight-bold">Layanan <span class="text-danger">*</span></label>
            <select name="layanan_id" id="layanan_id" class="form-control" required>
              <option value="">-- Pilih Layanan --</option>
              @foreach($layanan as $l)
                <option value="{{ $l->id }}" {{ old('layanan_id') == $l->id ? 'selected' : '' }}>
                  {{ $l->nama_layanan }}
                </option>
              @endforeach
            </select>
          </div>

          {{-- KEPERLUAN --}}
          <div class="form-group">
            <label class="font-weight-bold">Keperluan <span class="text-danger">*</span></label>
            <textarea name="keperluan" rows="4" class="form-control" required>{{ old('keperluan') }}</textarea>
          </div>

          <hr>

          {{-- DETAIL LAYANAN --}}
          <h5 class="mb-2"><strong>Detail Layanan</strong></h5>
          <div id="detailWrap">
            <div class="alert alert-info mb-0">Pilih layanan untuk menampilkan detail.</div>
          </div>

        </div>

        <div class="card-footer d-flex justify-content-end" style="gap:8px;">
          
          <button type="submit" class="btn btn-primary">
            <i class="fas fa-save mr-1"></i> Simpan
          </button>
        </div>
      </form>

    </div>
  </section>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
  const modeEl = document.getElementById('pemohon_mode');
  const pendudukIdEl = document.getElementById('penduduk_id');

  const nikMsg = document.getElementById('nik_msg');
  const cariNik = document.getElementById('cari_nik');
  const btnCari = document.getElementById('btnCariNik');

  const boxFound = document.getElementById('boxFound');
  const boxManual = document.getElementById('boxManual');

  const btnGantiManual = document.getElementById('btnGantiManual');
  const btnKembaliFound = document.getElementById('btnKembaliFound');

  const fNama = document.getElementById('f_nama');
  const fNik  = document.getElementById('f_nik');
  const fAlamat = document.getElementById('f_alamat');

  function setModeFound(p) {
    modeEl.value = 'found';
    pendudukIdEl.value = p.id;

    boxFound.classList.remove('d-none');
    boxManual.classList.add('d-none');
    btnKembaliFound.classList.add('d-none');

    fNama.textContent = p.nama_lengkap || '-';
    fNik.textContent  = p.nik || '-';

    const alamat = [
      p.alamat || '',
      p.dusun ? ('Dusun ' + p.dusun) : '',
      p.rt ? ('RT ' + p.rt) : '',
      p.desa ? ('Desa ' + p.desa) : '',
      p.kecamatan ? ('Kec. ' + p.kecamatan) : '',
    ].filter(Boolean).join(', ');
    fAlamat.textContent = alamat || '-';
  }

  function setModeManual(prefillNik = '') {
    modeEl.value = 'manual';
    pendudukIdEl.value = '';

    boxFound.classList.add('d-none');
    boxManual.classList.remove('d-none');

    // tampilkan tombol "kembali" hanya kalau sebelumnya found
    btnKembaliFound.classList.remove('d-none');

    if (prefillNik) {
      document.getElementById('pemohon_nik').value = prefillNik;
    }
  }

  btnCari.addEventListener('click', function(){
    nikMsg.className = 'd-block mt-1';
    nikMsg.textContent = '';

    const nik = (cariNik.value || '').trim();
    if (nik.length !== 16) {
      nikMsg.classList.add('text-danger');
      nikMsg.textContent = 'NIK harus 16 digit.';
      return;
    }

    fetch("{{ route('pengajuan.cari_nik') }}", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        "X-CSRF-TOKEN": "{{ csrf_token() }}"
      },
      body: JSON.stringify({ nik })
    })
    .then(async (res) => {
      const data = await res.json().catch(() => ({}));
      if (!res.ok) throw data;
      return data;
    })
    .then(res => {
      if (res.status === 'found') {
        nikMsg.classList.add('text-success');
        nikMsg.textContent = 'Data penduduk ditemukan.';
        setModeFound(res.data);
      } else {
        nikMsg.classList.add('text-danger');
        nikMsg.textContent = res.message || 'NIK tidak ditemukan.';
        setModeManual(nik);
      }
    })
    .catch(err => {
      nikMsg.classList.add('text-danger');
      nikMsg.textContent = (err && err.message) ? err.message : 'NIK tidak ditemukan. Silakan isi manual.';
      setModeManual(nik);
    });
  });

  btnGantiManual.addEventListener('click', function(){
    setModeManual();
  });

  btnKembaliFound.addEventListener('click', function(){
    // kembali found hanya kalau ada pendudukId yang tersimpan (kasus: user klik manual setelah found)
    const pid = pendudukIdEl.value;
    if (!pid) return;
    // tidak refetch; tetap tampil found box dengan data sebelumnya
    boxFound.classList.remove('d-none');
    boxManual.classList.add('d-none');
    modeEl.value = 'found';
  });

  // ============ DETAIL LAYANAN DINAMIS ============
  const layananSelect = document.getElementById('layanan_id');
  const detailWrap = document.getElementById('detailWrap');

  function renderDetail(fields){
    if (!fields || fields.length === 0) {
      detailWrap.innerHTML = `<div class="alert alert-info mb-0">Tidak ada detail layanan.</div>`;
      return;
    }

    let html = '';
    fields.forEach(f => {
      const wajib = parseInt(f.wajib) === 1;
      const req = wajib ? 'required' : '';
      const star = wajib ? ' <span class="text-danger">*</span>' : '';

      let input = '';
      const name = `detail[${f.id}]`;

      if (f.tipe_input === 'textarea') {
        input = `<textarea name="${name}" class="form-control" rows="3" ${req}></textarea>`;
      } else if (f.tipe_input === 'number') {
        input = `<input type="number" name="${name}" class="form-control" ${req}>`;
      } else if (f.tipe_input === 'date') {
        input = `<input type="date" name="${name}" class="form-control" ${req}>`;
      } else {
        input = `<input type="text" name="${name}" class="form-control" ${req}>`;
      }

      html += `
        <div class="form-group">
          <label class="font-weight-bold">${f.keterangan}${star}</label>
          ${input}
        </div>
      `;
    });

    detailWrap.innerHTML = html;
  }

  function loadDetail(){
    const id = layananSelect.value;
    if (!id) {
      detailWrap.innerHTML = `<div class="alert alert-info mb-0">Pilih layanan untuk menampilkan detail.</div>`;
      return;
    }
    detailWrap.innerHTML = `<div class="alert alert-secondary mb-0">Memuat detail layanan...</div>`;

    fetch("{{ url('dashboard/pengajuan/layanan') }}/" + id + "/detail-layanan")
      .then(r => r.json())
      .then(res => {
        if (res.status !== 'success') {
          detailWrap.innerHTML = `<div class="alert alert-danger mb-0">Gagal memuat detail layanan.</div>`;
          return;
        }
        renderDetail(res.data);
      })
      .catch(() => {
        detailWrap.innerHTML = `<div class="alert alert-danger mb-0">Gagal memuat detail layanan.</div>`;
      });
  }

  layananSelect.addEventListener('change', loadDetail);

  // kalau sebelumnya ada layanan terpilih (old)
  @if(old('layanan_id'))
    loadDetail();
  @endif
});
</script>
@endsection