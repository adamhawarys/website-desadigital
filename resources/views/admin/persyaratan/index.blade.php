<title>Kelola Persyaratan | {{ $layanan->nama_layanan }}</title>
@extends('layout.master')

@section('content')
<div class="content-wrapper">

        {{-- HEADER --}}
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Persyaratan - {{ $layanan->nama_layanan }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ url('dashboard') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active">Persyaratan - {{ $layanan->nama_layanan }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="card">
            <div class="card-header bg-primary">
                <a href="{{ route('layanan.index') }}" class="btn btn-success btn-sm">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>

            <div class="card-body">
                {{-- Form Tambah --}}
                <form action="{{ route('persyaratan.store', $layanan->id) }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-md-4">
                            <input type="text" name="nama_persyaratan" class="form-control" placeholder="Nama Persyaratan" required>
                        </div>
                        <div class="col-md-3">
                            <select name="tipe" class="form-control">
                                <option value="file">File Upload</option>
                                <option value="text">Input Text</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select name="wajib" class="form-control">
                                <option value="1">Wajib</option>
                                <option value="0">Tidak Wajib</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <button class="btn btn-primary btn-block">
                                <i class="fas fa-plus"></i> Tambah
                            </button>
                        </div>
                    </div>
                </form>

                <hr>

                {{-- Tabel --}}
                <table class="table table-bordered mt-3">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Tipe</th>
                            <th>Wajib</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($persyaratan as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->nama_persyaratan }}</td>
                            <td>{{ $item->tipe }}</td>
                            <td>
                                @if($item->wajib)
                                    <span class="badge badge-success">Ya</span>
                                @else
                                    <span class="badge badge-secondary">Tidak</span>
                                @endif
                            </td>
                            <td>
                                <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modalEdit{{ $item->id }}">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modalDelete{{ $item->id }}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>

                        {{-- MODAL EDIT --}}
                        <div class="modal fade" id="modalEdit{{ $item->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <form action="{{ route('persyaratan.update', $item->id) }}" method="post">
                                        @csrf 
                                        <div class="modal-header">
                                            <h5 class="modal-title">Edit Persyaratan</h5>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label>Nama Persyaratan</label>
                                                <input type="text" name="nama_persyaratan" class="form-control" value="{{ $item->nama_persyaratan }}" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Tipe</label>
                                                <select name="tipe" class="form-control">
                                                    <option value="file" {{ $item->tipe == 'file' ? 'selected' : '' }}>File Upload</option>
                                                    <option value="text" {{ $item->tipe == 'text' ? 'selected' : '' }}>Input Text</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Wajib</label>
                                                <select name="wajib" class="form-control">
                                                    <option value="1" {{ $item->wajib ? 'selected' : '' }}>Wajib</option>
                                                    <option value="0" {{ !$item->wajib ? 'selected' : '' }}>Tidak Wajib</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-warning">Simpan Perubahan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        {{-- MODAL DELETE --}}
                        <div class="modal fade" id="modalDelete{{ $item->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header bg-danger">
                                        <h5 class="modal-title">Konfirmasi Hapus</h5>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>
                                    <div class="modal-body">
                                        Apakah Anda yakin ingin menghapus persyaratan <strong>{{ $item->nama_persyaratan }}</strong>?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                        <form action="{{ route('persyaratan.destroy', $item->id) }}" method="post">
                                            @csrf @method('delete')
                                            <button type="submit" class="btn btn-danger">Ya, Hapus</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">Belum ada persyaratan</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>
@endsection