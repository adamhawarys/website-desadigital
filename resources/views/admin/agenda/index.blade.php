<title>Dashboard | Agenda</title>
@extends('layout.master')

@section('content')
<div class="content-wrapper" style="min-height: 1302.4px;">
    
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Agenda</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="dashboard">Dashboard</a></li>
          <li class="breadcrumb-item active">Agenda</li>
        </ol>
      </div>
    </div>
  </div>
</section>

<section class="content">
  <div class="card">
    <div class="card-header">
      <div class="row mb-2">
        <div class="col-sm-6">
          <div class="mb-1 mr-2">
            <a href="{{ route('agenda.create') }}" class="btn btn-sm btn-primary">
              <i class="fas fa-plus mr-2"></i>
              Upload Agenda
            </a>
          </div>
        </div>

        <div class="col-sm-6">
          <div class="card-tools float-right">
            <div class="input-group input-group-sm" style="width: 300px;">
              <input type="text" name="table_search" class="form-control float-right" placeholder="Search">
              <div class="input-group-append">
                <button type="submit" class="btn btn-default">
                  <i class="fas fa-search"></i>
                </button>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>

    <div class="card-body table-responsive p-0">
      <table class="table table-bordered table-striped mb-0">
        <thead>
          <tr>
            <th>No</th>
            <th>Judul</th>
            <th>Tanggal</th>
            <th>Lokasi</th>
            <th>Detail</th>
            <th class="text-center align-middle"><i class="fas fa-cog"></i></th>
          </tr>
        </thead>

        <tbody>
          @forelse ($agenda as $item)
          <tr>
            <td>{{ $agenda->firstItem() + $loop->index }}</td>
            <td>{{ $item->judul }}</td>
            <td>{{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d F Y') }}</td>
            <td>{{ $item->lokasi }}</td>
            <td>{{ $item->detail }}</td>
            <td class="text-center">

              <!-- Edit -->
              <a href="{{ route('agenda.edit', $item->id) }}" class="btn btn-warning btn-sm">
                <i class="fas fa-edit"></i>
              </a>

              <!-- Delete Button (Trigger Modal) -->
              <button 
                class="btn btn-danger btn-sm btn-delete"
                data-id="{{ $item->id }}"
                data-judul="{{ $item->judul }}"
                data-toggle="modal"
                data-target="#modalDelete">
                <i class="fas fa-trash"></i>
              </button>

            </td>
          </tr>
          @empty
          <tr>
            <td colspan="6" class="text-center text-muted">Belum ada data agenda</td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <div class="card-footer clearfix">
      {{ $agenda->links('pagination::bootstrap-4') }}
    </div>
  </div>
</section>

</div>


<!-- MODAL DELETE -->
<div class="modal fade" id="modalDelete" tabindex="-1">
  <div class="modal-dialog">
    <form method="POST" id="formDelete">
      @csrf
      @method('DELETE')

      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Hapus Agenda</h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <div class="modal-body">
          <p>Yakin ingin menghapus agenda berikut?</p>
          <strong id="judulAgenda"></strong>
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
    const buttons = document.querySelectorAll('.btn-delete');
    const form = document.getElementById('formDelete');
    const judul = document.getElementById('judulAgenda');

    buttons.forEach(button => {
        button.addEventListener('click', function () {
            const id = this.getAttribute('data-id');
            const nama = this.getAttribute('data-judul');

            form.action = `/dashboard/agenda/${id}`;
            judul.textContent = nama;
        });
    });
});
</script>

@endsection