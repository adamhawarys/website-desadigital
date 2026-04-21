<title>Kelola Detail Layanan | {{$layanan->nama_layanan }}</title>
@extends('layout.master')

@section('content')
<div class="content-wrapper">

      {{-- HEADER --}}
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Detail Layanan - {{ $layanan->nama_layanan }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ url('dashboard') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active">Detail Layanan - {{ $layanan->nama_layanan }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

  <section class="content">
    <div class="card">

      <div class="card-header bg-primary d-flex justify-content-between align-items-center">
        <a href="{{ route('layanan.index') }}" class="btn btn-success btn-sm">
          <i class="fas fa-arrow-left"></i> Kembali
        </a>
      </div>

      <div class="card-body">

        {{-- Flash message --}}
        @if(session('success'))
          <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
          <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        {{-- Form Tambah Field --}}
        <form action="{{ route('detail-layanan.store') }}" method="post">
          @csrf

          <input type="hidden" name="layanan_id" value="{{ $layanan->id }}">

          <div class="row">
            <div class="col-md-4">
              <input type="text"
                     name="keterangan"
                     class="form-control @error('keterangan') is-invalid @enderror"
                     placeholder="Nama Field (Contoh: Nama Usaha)"
                     value="{{ old('keterangan') }}"
                     required>
              @error('keterangan') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-3">
              <select name="tipe_input" class="form-control @error('tipe_input') is-invalid @enderror">
                <option value="text" {{ old('tipe_input')=='text' ? 'selected' : '' }}>Text</option>
                <option value="textarea" {{ old('tipe_input')=='textarea' ? 'selected' : '' }}>Textarea</option>
                <option value="number" {{ old('tipe_input')=='number' ? 'selected' : '' }}>Number</option>
                <option value="date" {{ old('tipe_input')=='date' ? 'selected' : '' }}>Date</option>
              </select>
              @error('tipe_input') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-2">
              <select name="wajib" class="form-control @error('wajib') is-invalid @enderror">
                <option value="1" {{ old('wajib')=='1' ? 'selected' : '' }}>Wajib</option>
                <option value="0" {{ old('wajib')=='0' ? 'selected' : '' }}>Tidak Wajib</option>
              </select>
              @error('wajib') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-3">
              <button class="btn btn-primary btn-block">
                <i class="fas fa-plus"></i> Tambah
              </button>
            </div>
          </div>
        </form>

        <hr>

        {{-- Tabel Field --}}
        <table class="table table-bordered mt-3">
          <thead>
            <tr>
              <th style="width:70px;">No</th>
              <th>Nama Field</th>
              <th style="width:140px;">Tipe Input</th>
              <th style="width:120px;">Wajib</th>
              <th style="width:140px;">Aksi</th>
            </tr>
          </thead>

          <tbody>
            @forelse($detail as $item)
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->keterangan }}</td>
                <td>{{ ucfirst($item->tipe_input) }}</td>
                <td>
                  @if($item->wajib)
                    <span class="badge badge-success">Ya</span>
                  @else
                    <span class="badge badge-secondary">Tidak</span>
                  @endif
                </td>
                <td class="d-flex" style="gap:6px;">
                  {{-- BUTTON EDIT (modal) --}}
                  <button type="button"
                          class="btn btn-warning btn-sm"
                          data-toggle="modal"
                          data-target="#modalEdit{{ $item->id }}">
                    <i class="fas fa-edit"></i>
                  </button>

                  {{-- BUTTON DELETE (modal confirm) --}}
                  <button type="button"
                          class="btn btn-danger btn-sm"
                          data-toggle="modal"
                          data-target="#modalDelete{{ $item->id }}">
                    <i class="fas fa-trash"></i>
                  </button>
                </td>
              </tr>

              {{-- MODAL EDIT --}}
              <div class="modal fade" id="modalEdit{{ $item->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">

                    <div class="modal-header">
                      <h5 class="modal-title">Edit Detail Field</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>

                    <form action="{{ route('detail-layanan.update', $item->id) }}" method="post">
                      @csrf
                      

                      <div class="modal-body">

                        <div class="form-group">
                          <label>Nama Field</label>
                          <input type="text" name="keterangan" class="form-control" value="{{ $item->keterangan }}" required>
                        </div>

                        <div class="form-group">
                          <label>Tipe Input</label>
                          <select name="tipe_input" class="form-control" required>
                            <option value="text" {{ $item->tipe_input=='text' ? 'selected' : '' }}>Text</option>
                            <option value="textarea" {{ $item->tipe_input=='textarea' ? 'selected' : '' }}>Textarea</option>
                            <option value="number" {{ $item->tipe_input=='number' ? 'selected' : '' }}>Number</option>
                            <option value="date" {{ $item->tipe_input=='date' ? 'selected' : '' }}>Date</option>
                          </select>
                        </div>

                        <div class="form-group">
                          <label>Wajib</label>
                          <select name="wajib" class="form-control" required>
                            <option value="1" {{ $item->wajib ? 'selected' : '' }}>Wajib</option>
                            <option value="0" {{ !$item->wajib ? 'selected' : '' }}>Tidak Wajib</option>
                          </select>
                        </div>

                      </div>

                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-warning">
                          <i class="fas fa-save"></i> Simpan
                        </button>
                      </div>
                    </form>

                  </div>
                </div>
              </div>

              {{-- MODAL DELETE --}}
              <div class="modal fade" id="modalDelete{{ $item->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                  <div class="modal-content">

                    <div class="modal-header bg-danger">
                      <h5 class="modal-title">Konfirmasi Hapus</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>

                    <div class="modal-body">
                      <p class="mb-1">Anda yakin ingin menghapus field ini?</p>
                      <div class="p-2 bg-light rounded">
                        <strong>{{ $item->keterangan }}</strong><br>
                        <small class="text-muted">Tipe: {{ ucfirst($item->tipe_input) }} | Wajib: {{ $item->wajib ? 'Ya' : 'Tidak' }}</small>
                      </div>
                      <small class="text-danger d-block mt-2">
                        Data yang dihapus tidak bisa dikembalikan.
                      </small>
                    </div>

                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>

                      <form action="{{ route('detail-layanan.destroy', $item->id) }}" method="post" class="m-0">
                        @csrf
                        @method('delete')
                        <button type="submit" class="btn btn-danger">
                          <i class="fas fa-trash"></i> Ya, Hapus
                        </button>
                      </form>

                    </div>

                  </div>
                </div>
              </div>

            @empty
              <tr>
                <td colspan="5" class="text-center">Belum ada detail field</td>
              </tr>
            @endforelse
          </tbody>
        </table>

      </div>
    </div>
  </section>

</div>
@endsection