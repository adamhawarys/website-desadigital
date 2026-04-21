{{-- MODAL PENGADUAN --}}
<div class="modal fade" id="modalPengaduan" tabindex="-1" aria-labelledby="modalPengaduanLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="modalPengaduanLabel">Form Pengaduan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form action="{{ route('pengaduan.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="modal-body">

                    {{-- @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif --}}

                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nama <span class="text-danger">*</span></label>
                        <input type="text"
                               name="nama"
                               class="form-control @error('nama') is-invalid @enderror"
                               value="{{ old('nama', Auth::check() ? Auth::user()->name : '') }}"
                               {{ Auth::check() ? 'readonly' : '' }}
                               placeholder="Masukkan nama lengkap">
                        @error('nama')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Email <span class="text-danger">*</span></label>
                        <input type="email"
                               name="email"
                               class="form-control @error('email') is-invalid @enderror"
                               value="{{ old('email', Auth::check() ? Auth::user()->email : '') }}"
                               {{ Auth::check() ? 'readonly' : '' }}
                               placeholder="Masukkan email">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Judul Pengaduan <span class="text-danger">*</span></label>
                        <input type="text"
                               name="judul"
                               class="form-control @error('judul') is-invalid @enderror"
                               value="{{ old('judul') }}"
                               placeholder="Masukkan judul pengaduan">
                        @error('judul')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Isi Pengaduan <span class="text-danger">*</span></label>
                        <textarea name="isi"
                                  class="form-control @error('isi') is-invalid @enderror"
                                  rows="5"
                                  placeholder="Tuliskan pengaduan Anda secara lengkap...">{{ old('isi') }}</textarea>
                        @error('isi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Foto/Bukti <span class="text-muted">(opsional)</span>
                        </label>
                        <input type="file"
                               name="foto"
                               class="form-control @error('foto') is-invalid @enderror"
                               accept="image/*">
                        <small class="text-muted">Format: JPG/PNG (maks 2MB)</small>
                        @error('foto')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Kirim Pengaduan</button>
                </div>

            </form>

        </div>
    </div>
</div>

@if($errors->hasAny(['nama', 'email', 'judul', 'isi', 'foto']))
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var modal = new bootstrap.Modal(document.getElementById('modalPengaduan'));
            modal.show();
        });
    </script>
@endif