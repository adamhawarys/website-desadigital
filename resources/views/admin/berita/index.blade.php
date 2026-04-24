<title>Dashboard | Berita</title>
@extends('layout.master')

@section('content')
<div class="content-wrapper" style="min-height: 1002.4px;">
      <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Berita</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="dashboard">Dashboard</a></li>
              <li class="breadcrumb-item active">Berita</li>
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
                        <a href="{{ route('berita.create') }}" class="btn btn-sm btn-primary">
                          <i class="fas fa-plus mr-2"></i>
                          Upload Berita
                        </a>
                    </div>

                  </div>
                  <div class="col-sm-6">
                    <div class="card-tools float-right">
                      <form action="{{ route('berita.index') }}" method="GET">
                    <div class="input-group input-group-sm" style="width: 300px;">
                      <input type="text" name="table_search" class="form-control float-right" placeholder="Search" value="{{ request('table_search') }}">
  
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
              <!-- /.card-header -->
              <div class="card-body">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th class="text-center align-middle">No</th>
                      <th class="text-center align-middle">Gambar</th>
                      <th class="text-center align-middle">Judul</th>
                      <th class="text-center align-middle">Slug</th>
                      <th class="text-center align-middle">Konten</th>
                      <th class="text-center align-middle">Penulis</th>
                      <th class="text-center align-middle">Status</th>
                      <th class="text-center align-middle">Tanggal Publikasi</th>
                      <th class="text-center align-middle"><i class="fas fa-cog"></i></th>
                      
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($berita as $item)
                      <tr>

                      <td class="text-center align-middle">
                          {{ $berita->firstItem() + $loop->index }}
                      </td>

                      <td class="text-center align-middle">
                          <img src="{{ Storage::disk('s3')->url($item->gambar ?? 'images.png') }}"
                              class="img-fluid"
                              style="width:100px;"
                              alt="{{ $item->judul }}">
                      </td>

                      <td>{{ $item->judul }}</td>

                      <td>{{ $item->slug }}</td>

                      <td>{!! $item->excerpt !!}</td>

                      <td>
                      @if ($item->penulis->role == 'Admin')
                      <span class="badge badge-danger">
                      {{ $item->penulis->role }}
                      </span>
                      @endif

                      @if ($item->penulis->role == 'Petugas')
                      <span class="badge badge-info">
                      {{ $item->penulis->role }}
                      </span>
                      @endif
                      </td>

                      <td>
                      @if ($item->status == 'published')
                      <span class="badge badge-success">{{ $item->status }}</span>
                      @endif

                      @if ($item->status == 'draft')
                      <span class="badge badge-warning">{{ $item->status }}</span>
                      @endif

                      @if ($item->status == 'archived')
                      <span class="badge badge-primary">{{ $item->status }}</span>
                      @endif
                      </td>

                      <td>{{ $item->tanggal_publikasi }}</td>

                      <td class="text-center align-middle">

                      <a href="{{ route('berita.edit', $item->id) }}"
                      class="btn btn-sm btn-warning mb-1">
                      <i class="fas fa-edit"></i>
                      </a>

                      <button class="btn btn-sm btn-danger"
                      data-toggle="modal"
                      data-target="#exampleModal{{ $item->id }}">
                      <i class="fas fa-trash"></i>
                      </button>

                      @include('admin.berita.modal')

                      </td>

                      </tr>
                    @endforeach
                  </tbody>
                </table>
      
              <!-- /.card-body -->
              
              
            </div>
            <div class="card-footer clearfix">
             
                {{ $berita->links('pagination::bootstrap-4') }}
              </div>
            
      </section>
     
</div>

@endsection
