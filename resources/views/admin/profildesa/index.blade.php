<title>Dashboard | Profil Desa</title>
@extends('layout.master')

@section('content')
<div class="content-wrapper" style="min-height: 902.4px;">
    <!-- Content Header (Page header) -->
    <section class="content-header" >
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Profil Desa</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="dashboard">Dashboard</a></li>
              <li class="breadcrumb-item active">Profil Desa</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="card">
              <div class="card-header">
                <div class="row mb-2">
              
                  {{-- <div class="col-sm-6">
                    <div class="mb-1 mr-2">
                        <a href="{{ route('profil_desa.create') }}" class="btn btn-sm btn-primary">
                          <i class="fas fa-plus mr-2"></i>
                          Tambah Data
                        </a>
                    </div>

                  </div> --}}
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
              <!-- /.card-header -->
              <div class="card-body">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th class="text-center align-middle">No</th>
                      <th class="text-center align-middle">Nama Desa</th>
                      <th class="text-center align-middle">Alamat Desa</th>
                      <th class="text-center align-middle">Kode Pos</th>
                      <th class="text-center align-middle">Kades</th>
                      <th class="text-center align-middle">Sekdes</th>
                      <th class="text-center align-middle">Logo</th>
                      <th class="text-center align-middle"><i class="fas fa-cog"></i></th>
                      
                    </tr>
                  </thead>
                  <tbody>
                      @if($profil)
                      <tr>
                        <td class="text-center align-middle">1</td>
                        <td class="align-middle">{{ $profil->nama_desa }}</td>
                        <td class="align-middle">{{ $profil->alamat }}</td>
                        <td class="text-center align-middle">{{ $profil->kode_pos }}</td>
                        <td class="align-middle">{{ $profil->kades }}</td>
                        <td class="align-middle">{{ $profil->sekdes }}</td>
                        <td class="text-center align-middle">
                          @if($profil->logo)
                            <img src="{{ Storage::disk('s3')->url($profil->logo) }}"
                                style="width:80px; height:80px; object-fit:contain;"
                                alt="Logo {{ $profil->nama_desa }}">
                          @else
                            <span class="text-muted">Belum ada</span>
                          @endif
                        </td>
                        <td class="text-center align-middle">
                          <a href="{{ route('profil_desa.edit', $profil->id) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i>
                          </a>
                        </td>
                      </tr>
                      @else
                      <tr>
                        <td colspan="8" class="text-center text-muted">Profil desa belum diisi</td>
                      </tr>
                      @endif

                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
              
            </div>
      @include('partials.profil-desa')

    </section>
    <!-- /.content -->

  </div>
@endsection