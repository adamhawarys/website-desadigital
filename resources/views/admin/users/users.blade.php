<title>Dashboard | Data Users</title>
@extends('layout.master')

@section('content')
<div class="content-wrapper" style="min-height: 902.4px;">
    <!-- Content Header (Page header) -->
    <section class="content-header" >
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Data Users</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="dashboard">Dashboard</a></li>
              <li class="breadcrumb-item active">Data Users</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="card">
        <div class="card-header bg-light">
          <div class="mb-1 mr-2">
            <a href="{{ route('users.create') }}" class="btn btn-sm btn-primary">
              <i class="fas fa-plus mr-2"></i>
              Tambah Data
            </a>
          </div>
          
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th class="text-center">No</th>
                  <th>Nama</th>
                  <th>Email</th>
                  <th>Role</th>
                  <th>Status</th>
                  <th>Konfirmasi SNS</th>
                  <th class="text-center"><i class="fas fa-cog"></i></th>
                </tr>
              </thead>
              <tbody>
                @foreach ($users as $item)
                    <tr>
                      <td class="text-center">{{ $users->firstItem() + $loop->index }}</td>
                      <td>{{ $item->name }}</td>
                      <td>{{ $item->email }}</td>
                      <td>
                        @if ($item->role == 'Admin')
                          <span class="badge badge-danger">
                            {{ $item->role }}
                          </span>
                        @endif

                        @if ($item->role == 'Petugas')
                          <span class="badge badge-info">
                            {{ $item->role }}
                          </span>
                        @endif

                        @if ($item->role == 'Warga')
                          <span class="badge badge-success">
                            {{ $item->role }}
                          </span>
                        @endif
                    </td>
                      <td>
                        @if ($item->status == 'Verify')
                          <span class="badge badge-warning">
                            {{ $item->status }}
                          </span>
                        @endif

                        @if ($item->status == 'Active')
                          <span class="badge badge-success">
                            {{ $item->status }}
                          </span>
                        @endif

                        @if ($item->status == 'Banned')
                          <span class="badge badge-danger">
                            {{ $item->status }}
                          </span>
                        @endif
                    </td>

                    <td>
                        @if ($item->sns_confirmed == 1)
                            <span class="badge badge-success">Confirmed</span>
                        @else
                            <span class="badge badge-secondary">Pending</span>
                        @endif
                    </td>
                      
                      <td class="text-center">
                        <a href="{{route('users.edit', $item->id)}}" class="btn btn-sm btn-warning">
                          <i class="fas fa-edit"></i>
                        </a>
                        <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#exampleModal{{ $item->id }}">
                          <i class="fas fa-trash"></i>
                        </button>
                        @include('admin.users.modal')
                      </td>
                    </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
        <!-- /.card-body -->
        <div class="card-footer clearfix">
                {{ $users->links('pagination::bootstrap-4') }}
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