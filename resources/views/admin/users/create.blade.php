<title>Dashboard | Tambah Data Users</title>
@extends('layout.master')

@section('content')
<div class="content-wrapper" style="min-height: 502.4px;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Tambah Data Users</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="users">Data Users</a></li>
              <li class="breadcrumb-item active">Tambah Data Users</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="card">
        <div class="card-header bg-primary">
         
            <a href="{{ route('users.users') }}" class="btn btn-sm btn-success">
              <i class="fas fa-arrow-left mr-2"></i>
              Kembali
            </a>
          
        </div>
        <div class="card-body">

          <form action="store" method="post">
            @csrf
          <div class="row mb-2">
            <div class="col-xl-6 mb-2"   >
              <label class="form-label">
                <span class="text-danger">*</span>
                Nama :
              </label>
              <input type="text" name="name" class="form-control @error('name') is-invalid
              @enderror" value="{{ old('name') }}">
              @error('name')
                <small class="text-danger">{{ $message }}</small>
              @enderror
            </div>
            <div class="col-xl-6">
              <label class="form-label">
                <span class="text-danger">*</span>
                Email :
              </label>
              <input type="email" name="email" class="form-control @error('email') is-invalid
              @enderror" value="{{ old('email') }}">
              @error('email')
                <small class="text-danger">{{ $message }}</small>
              @enderror
            </div>
          </div>
          <div class="row mb-2">
            <div class="col-xl-12">
              <label class="form-label">
                <span class="text-danger">*</span>
                Role :
              </label>
              <select name="role" class="form-control @error('role') is-invalid
              @enderror">
                <option selected disabled>-- Pilih Role --</option>
                
                <option value="Admin">Admin</option>
                <option value="Petugas">Petugas</option>
                <option value="Warga">Warga</option>
              </select>
              @error('role')
                <small class="text-danger">{{ $message }}</small>
              @enderror
            </div> 
          </div>
          <div class="row mb-2">
            <div class="col-xl-6 mb-2">
              <label class="form-label">
                <span class="text-danger">*</span>
                Password :
              </label>
              <input type="password" name="password" class="form-control @error('password') is-invalid
              @enderror">
              @error('password')
                <small class="text-danger">{{ $message }}</small>
              @enderror
            </div>
            <div class="col-xl-6">
              <label class="form-label">
                <span class="text-danger">*</span>
                Konfirmasi Password :
              </label>
              <input type="password" name="password_confirmation" class="form-control @error('password') is-invalid
              @enderror">
            </div>
          </div>
        
          <div>
          <button type="submit" class="btn btn-sm btn-primary">
            <i class="fas fa-save mr-2"></i>
            Simpan
          </button>
        </div>
        </form>
        </div>
        
        <!-- /.card-body -->
        <div class="card-footer ">
                
              </div>
        <!-- /.card-footer-->
      </div>
      <!-- /.card -->

    </section>
    <!-- /.content -->

    {{-- create modal --}}
    
    {{-- create modal --}}
  </div>
@endsection