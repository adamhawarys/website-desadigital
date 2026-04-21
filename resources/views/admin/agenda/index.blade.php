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
            <td>{{ $item->lokasi}}</td>
            <td>{{ $item->detail}}</td>
            <td class="text-center">
              <a href="" class="btn btn-warning btn-sm">
                <i class="fas fa-edit"></i>
              </a>
              <form action="" method="POST" class="d-inline" onsubmit="return confirm('Hapus agenda ini?')">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger btn-sm">
                  <i class="fas fa-trash"></i>
                </button>
              </form>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="5" class="text-center text-muted">Belum ada data agenda</td>
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

@endsection
