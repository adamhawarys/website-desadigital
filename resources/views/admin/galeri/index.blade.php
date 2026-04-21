<title>Dashboard | Galeri</title>
@extends('layout.master')

@section('content')
<div class="content-wrapper" style="min-height: 1002.4px;">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Galeri</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="dashboard">Dashboard</a></li>
              <li class="breadcrumb-item active">Galeri</li>
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
                  <a href="{{ route('galeri.create') }}" class="btn btn-sm btn-primary">
                    <i class="fas fa-plus mr-2"></i>
                    Upload Foto
                  </a>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="card-tools float-right">
                <form action="{{ route('galeri.index') }}" method="GET">
                  <div class="input-group input-group-sm" style="width: 300px;">
                    <input type="text" name="table_search" class="form-control float-right" placeholder="Cari Judul Foto..." value="{{ request('table_search') }}">
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
        <div class="card-body">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th class="text-center align-middle" width="5%">No</th>
                <th class="text-center align-middle" width="15%">Foto</th>
                <th class="text-center align-middle" width="20%">Judul</th>
                <th class="text-center align-middle" width="35%">Deskripsi</th>
                <th class="text-center align-middle" width="10%">Status</th>
                <th class="text-center align-middle" width="15%"><i class="fas fa-cog"></i></th>
              </tr>
            </thead>
            <tbody>
              @foreach ($galeri as $item)
                <tr>
                  <td class="text-center align-middle">
                      {{ $galeri->firstItem() + $loop->index }}
                  </td>

                  <td class="text-center align-middle">
                      @if ($item->foto)
                          <img src="{{ Storage::disk('s3')->url($item->foto) }}"
                              class="img-fluid rounded"
                              style="width:100px; height:auto; object-fit:cover;"
                              alt="{{ $item->judul }}">
                      @else
                          <span class="text-danger">No Image</span>
                      @endif
                  </td>

                  <td class="align-middle">
                      {{ $item->judul ?? '-' }}
                  </td>

                  <td class="align-middle">
                      {{ $item->deskripsi ? \Illuminate\Support\Str::limit($item->deskripsi, 60) : '-' }}
                  </td>

                  <td class="text-center align-middle">
                      @if ($item->status == 'aktif')
                          <span class="badge badge-success"><i class="fas fa-check-circle"></i> Aktif</span>
                      @else
                          <span class="badge badge-danger"><i class="fas fa-times-circle"></i> Nonaktif</span>
                      @endif
                  </td>

                  <td class="text-center align-middle">
                      <a href="{{ route('galeri.edit', $item->id) }}" class="btn btn-sm btn-warning mb-1">
                          <i class="fas fa-edit"></i>
                      </a>

                      <button class="btn btn-sm btn-danger mb-1"
                              data-toggle="modal"
                              data-target="#exampleModal{{ $item->id }}">
                          <i class="fas fa-trash"></i>
                      </button>

                      @include('admin.galeri.modal') 
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        <div class="card-footer clearfix">
            {{ $galeri->links('pagination::bootstrap-4') }}
        </div>
      </div>
    </section>
</div>
@endsection