<title>Dashboard | Data Penduduk</title>
@extends('layout.master')

@section('content')
<div class="content-wrapper" style="min-height: 1002.4px;">
      <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Data Penduduk</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="dashboard">Dashboard</a></li>
              <li class="breadcrumb-item active">Data Penduduk</li>
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
                        <a href="{{ route('penduduk.create') }}" class="btn btn-sm btn-primary">
                          <i class="fas fa-plus mr-2"></i>
                          Tambah Data Penduduk
                        </a>
                    </div>

                  </div>
                  <div class="col-sm-6">
                    <div class="card-tools float-right">
                      <form action="{{ route('penduduk.index') }}" method="GET">
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
                <table class="table table-bordered text-uppercase">

                  <thead>
                    <tr>
                      <th class="text-center align-middle">No</th>
                      <th class="text-center align-middle">NIK</th>
                      <th class="text-center align-middle">No KK</th>
                      <th class="text-center align-middle">Nama</th>
                      <th class="text-center align-middle">Jenis Kelamin</th>
                      <th class="text-center align-middle">Tempat tanggal Lahir</th>
                      <th class="text-center align-middle">Agama</th>
                      <th class="text-center align-middle">Pendidikan</th>
                      <th class="text-center align-middle"><i class="fas fa-cog"></i></th>
                      
                    </tr>
                  </thead>
                  <tbody>
                    @forelse ($penduduk as $item)
                      <tr>
                        <td class="text-center align-middle">{{ $penduduk->firstItem() + $loop->index }}</td>
                        <td class="text-center align-middle">{{ $item->nik }}</td>
                        <td class="text-center align-middle">{{ $item->kk }}</td>
                        <td class="text-center align-middle">{{ $item->nama_lengkap }}</td>
                        <td class="text-center align-middle">{{ $item->jenis_kelamin }}</td>
                        <td class="text-center align-middle">{{ $item->tempat_lahir}}, {{ $item->tanggal_lahir ? $item->tanggal_lahir->format('d-m-Y') : '-' }}</td>
                        <td class="text-center align-middle">{{ $item->agama }}</td>
                        <td class="text-center align-middle">{{ $item->pendidikan }}</td>
                        <td class="text-center align-middle">
                          <div class="mb-2 mr-2">
                            <a href="{{ route('penduduk.edit', $item->id) }}" class="btn btn-sm btn-warning">
                              <i class="fas fa-edit"></i>
                            </a>
                          </div>
                          <div class="mb-1 mr-2">
                            <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#exampleModal{{ $item->id }}">
                              <i class="fas fa-trash"></i>
                            </button>
                            @include('admin.penduduk.modal')
                          </div>
                        </td>
                      </tr>
                    @empty
                      <tr>
                        <td colspan="9" class="text-center text-danger">
                          @if(request('table_search'))
                            Data penduduk tidak ditemukan untuk: <strong>{{ request('table_search') }}</strong>
                          @else
                            Belum ada data penduduk
                          @endif
                        </td>
                      </tr>
                    @endforelse
                </tbody>

                </table>
      
              <!-- /.card-body -->
              
              
            </div>
            <div class="card-footer clearfix">
             
                {{ $penduduk->links('pagination::bootstrap-4') }}
              </div>
            
      </section>
     
</div>

@endsection
