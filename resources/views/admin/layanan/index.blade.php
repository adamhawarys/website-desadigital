<title>Dashboard | Data Layanan</title>
@extends('layout.master')

@section('content')
<div class="content-wrapper" style="min-height: 1002.4px;">

    {{-- HEADER --}}
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Data Layanan</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ url('dashboard') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active"> Data Layanan</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    {{-- CONTENT --}}
    <section class="content">
        <div class="card">

            {{-- CARD HEADER --}}
            <div class="card-header">
                <div class="row mb-2">

                    <div class="col-sm-6">
                        <a href="{{ route('layanan.create') }}" 
                           class="btn btn-sm btn-primary">
                            <i class="fas fa-plus mr-2"></i>
                            Tambah Layanan
                        </a>
                    </div>

                    <div class="col-sm-6">
                        <div class="card-tools float-right">
                            <form action="{{ route('layanan.index') }}" method="GET">
                                <div class="input-group input-group-sm" style="width: 300px;">
                                    <input type="text" 
                                           name="search" 
                                           class="form-control float-right" 
                                           placeholder="Search"
                                           value="{{ request('search') }}">

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

            {{-- CARD BODY --}}
            <div class="card-body">

                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th class="text-center align-middle">No</th>
                            <th class="text-center align-middle">Nama Layanan</th>
                            <th class="text-center align-middle">Kode</th>
                            <th class="text-center align-middle">Deskripsi</th>
                            <th class="text-center align-middle">Template Surat</th>
                            <th class="text-center align-middle">
                                <i class="fas fa-cog"></i>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($layanan as $item)
                            <tr>
                                <td class="text-center align-middle">
                                    {{ $item->id }}
                                </td>

                                <td>{{ $item->nama_layanan }}</td>
                                <td class="text-center align-middle">{{ $item->kode_layanan }}</td>
                                <td class="text-center align-middle">{{ $item->deskripsi }}</td>
                                <td class="text-center align-middle">
                                    @if($item->template_surat)
                                        <a href="{{ route('layanan.preview', $item->id) }}"
                                           class="btn btn-sm btn-success"
                                           target="_blank">
                                            <i class="fas fa-file-pdf mr-1"></i> Preview
                                        </a>
                                    @else
                                        <span class="badge badge-warning">Belum diisi</span>
                                    @endif
                                </td>

                                <td class="text-center align-middle">
                                    <a href="{{ route('persyaratan.index', $item->id) }}"
                                        class="btn btn-info btn-sm">
                                        <i class="fas fa-list"></i>
                                    </a>

                                    <a href="{{ route('detail-layanan.index', $item->id) }}"
                                        class="btn btn-secondary btn-sm">
                                        <i class="fas fa-layer-group"></i>
                                    </a>

                                    <a href="{{ route('layanan.edit', $item->id) }}"
                                       class="btn btn-sm btn-warning mb-1">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <button class="btn btn-sm btn-danger"
                                        data-toggle="modal"
                                        data-target="#exampleModal{{ $item->id }}">
                                        <i class="fas fa-trash"></i>
                                    </button>

                                    @include('admin.layanan.modal')

                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">
                                    Belum ada data layanan
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

            </div>

            {{-- PAGINATION
            <div class="card-footer clearfix">
                {{ $layanan->links('pagination::bootstrap-4') }}
            </div> --}}

        </div>
    </section>

</div>
@endsection