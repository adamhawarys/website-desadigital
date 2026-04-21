<title>Dashboard | Perangkat Desa</title>
@extends('layout.master')

@section('content')
<div class="content-wrapper" style="min-height: 2002.4px;">
      <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Perangkat Desa</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="dashboard">Dashboard</a></li>
              <li class="breadcrumb-item active">Perangkat Desa</li>
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
                        <a href="{{ route('pegawai.create') }}" class="btn btn-sm btn-primary">
                          <i class="fas fa-plus mr-2"></i>
                          Tambah Perangkat Desa
                        </a>
                    </div>

                  </div>
                  <div class="col-sm-6">
                    <div class="card-tools float-right">
                <form action="{{ route('pegawai.index') }}" method="GET">
                    <div class="input-group input-group-sm" style="width: 300px;">
                      <input type="text" name="table_search" class="form-control float-right" placeholder="Search"  value="{{ request('table_search') }}">
  
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
                      <th class="text-center align-middle">Foto</th>
                      <th class="text-center align-middle">Nama Pejabat</th>
                      <th class="text-center align-middle">Jabatan</th>
                      <th class="text-center align-middle">Tempat Tanggal Lahir</th>
                      <th class="text-center align-middle">Jenis Kelamin</th>
                      <th class="text-center align-middle">Pendidikan</th>
                      <th class="text-center align-middle">Nomor SK</th>
                      <th class="text-center align-middle">Tanggal SK</th>
                      <th class="text-center align-middle">Alamat</th>
                      <th class="text-center align-middle"><i class="fas fa-cog"></i></th>
                      
                    </tr>
                  </thead>
                  <tbody>
                      @foreach ($pegawai as $item)
                    <tr>
                      <td class="text-center align-middle">{{ $pegawai->firstItem() + $loop->index }}</td>
                      <td><img src="{{ Storage::disk('s3')->url($item->foto ?: 'images.png') }}"class="img-fluid" style="width:100px;" alt="{{ $item->nama_pejabat }}"></td>
                      <td>{{ $item->nama_pejabat }}</td>
                      <td>{{ $item->jabatan }}</</td>
                      <td>{{ $item->tempat_lahir}}, {{ $item->tanggal_lahir }}</td>
                      <td>{{ $item->jenis_kelamin}}</td>
                      <td>{{ $item->pendidikan }}</td>
                      <td>{{ $item->nomor_sk }}</td>
                      <td>{{ $item->tanggal_sk }}</td>
                      <td>{{ $item->alamat}}</td>
                      <td class="text-center align-middle">
                        <div class="mb-2 mr-2">
                          <a href="{{ route('pegawai.edit', $item->id) }}" class="btn btn-sm btn-warning">
                          <i class="fas fa-edit"></i>
                        </a>
                        </div>
                        <div class="mb-1 mr-2">
                          <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#exampleModal{{ $item->id }}">
                          <i class="fas fa-trash"></i>
                        </button>
                        @include('admin.pegawai.modal')
                        </div>
                        
                        
                      </td>
                      
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
              <div class="card-footer clearfix">
                 {{ $pegawai->links('pagination::bootstrap-4') }}
              </div>
            </div>
      </section>
</div>

@endsection
