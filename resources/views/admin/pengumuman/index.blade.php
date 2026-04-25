<title>Dashboard | Pengumuman</title>
@extends('layout.master')

@section('content')
<div class="content-wrapper" style="min-height: 1002.4px;">
  <!-- Content Header -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Pengumuman</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Pengumuman</li>
          </ol>
        </div>
      </div>
    </div>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="card">
      <div class="card-header">
        <div class="row mb-2">

          <div class="col-sm-6">
            <a href="{{ route('pengumuman.create') }}" class="btn btn-sm btn-primary">
              <i class="fas fa-plus mr-2"></i>
              Tambah Pengumuman
            </a>
          </div>

          <div class="col-sm-6">
            <div class="card-tools float-right">
              <form action="{{ route('pengumuman.index') }}" method="GET">
                <div class="input-group input-group-sm" style="width: 300px;">
                  <input type="text"
                         name="table_search"
                         class="form-control float-right"
                         placeholder="Search"
                         value="{{ request('table_search') }}">
                  <div class="input-group-append">
                    <button type="submit" class="btn btn-default">
                      <i class="fas fa-search"></i>
                    </button>
                  </div>
                </div>
              </form>
            </div>
          </div>

        </div>
      </div>

      <!-- Card Body -->
      <div class="card-body">
        <table class="table table-bordered">
          <thead>
            <tr>
              <th class="text-center align-middle">No</th>
              <th class="text-center align-middle">Judul</th>
              <th class="text-center align-middle">Kategori</th>
              <th class="text-center align-middle">Deskripsi</th>
              <th class="text-center align-middle">Status</th>
              <th class="text-center align-middle">Tanggal</th>
              <th class="text-center align-middle"><i class="fas fa-cog"></i></th>
            </tr>
          </thead>
          <tbody>
            @forelse ($pengumuman as $item)
            <tr>
              <td class="text-center align-middle">
                {{ $pengumuman->firstItem() + $loop->index }}
              </td>

              <td>{{ $item->judul }}</td>

              <td class="text-center">
                {{ $item->kategori ?? '-' }}
              </td>

              <td>{!! Str::limit($item->deskripsi, 100) !!}</td>

              <td class="text-center">
                @if ($item->status == 'aktif')
                  <span class="badge badge-success">Aktif</span>
                @else
                  <span class="badge badge-danger">Berakhir</span>
                @endif
              </td>

              <td class="text-center">
                {{ $item->tanggal_mulai }} - {{ $item->tanggal_selesai }}
              </td>

              <td class="text-center align-middle">
                <a href="{{ route('pengumuman.edit', $item->id) }}" class="btn btn-sm btn-warning mb-1">
                  <i class="fas fa-edit"></i>
                </a>

                <button
                  class="btn btn-sm btn-danger mb-1 btn-delete-pengumuman"
                  data-id="{{ $item->id }}"
                  data-judul="{{ $item->judul }}"
                  data-toggle="modal"
                  data-target="#modalHapusPengumuman">
                  <i class="fas fa-trash"></i>
                </button>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="7" class="text-center">Belum ada pengumuman</td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      <!-- Card Footer -->
      <div class="card-footer clearfix">
        {{ $pengumuman->links('pagination::bootstrap-4') }}
      </div>
    </div>
  </section>
</div>


<!-- MODAL DELETE -->
<div class="modal fade" id="modalHapusPengumuman" tabindex="-1">
  <div class="modal-dialog">
    <form method="POST" id="formHapusPengumuman">
      @csrf
      @method('DELETE')

      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Hapus Pengumuman</h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <div class="modal-body">
          <p>Yakin ingin menghapus pengumuman berikut?</p>
          <strong id="judulPengumuman"></strong>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-danger">Hapus</button>
        </div>
      </div>
    </form>
  </div>
</div>


<!-- SCRIPT -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const buttons = document.querySelectorAll('.btn-delete-pengumuman');
    const form    = document.getElementById('formHapusPengumuman');
    const judul   = document.getElementById('judulPengumuman');

    buttons.forEach(button => {
        button.addEventListener('click', function () {
            const id   = this.getAttribute('data-id');
            const nama = this.getAttribute('data-judul');

            form.action = `/dashboard/pengumuman/${id}`;
            judul.textContent = nama;
        });
    });
});
</script>

@endsection