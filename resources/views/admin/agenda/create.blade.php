@extends('layout.master')

@section('content')
 <div class="content-wrapper" style="min-height: 1302.4px;">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Upload Agenda</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="dashboard">Dashboard</a></li>
              <li class="breadcrumb-item active">Upload Agenda</li>
            </ol>
          </div>
        </div>
        </div>
    </section>

    <section class="content">
      <div class="card">
        <div class="card-header bg-primary">
          <a href="{{ route('agenda.index') }}" class="btn btn-success btn-sm">
            <i class="fas fa-arrow-left mr-2"></i>Kembali
          </a>
        </div>
        <form action="{{ route('agenda.store') }}" method="POST">
          @csrf
          <div class="card-body">
            <div class="form-group">
              <label>Judul</label>
              <input type="text" name="judul" class="form-control" required value="{{ old('judul') }}">
            </div>

            <div class="form-group">
              <label>Tanggal</label>
              <input type="date" name="tanggal" class="form-control" required value="{{ old('tanggal') }}">
            </div>

            <div class="form-group">
              <label>Lokasi</label>
              <input type="text" name="lokasi" class="form-control" required value="{{ old('lokasi') }}" placeholder="Contoh: Kantor Desa">
            </div>
            <div class="form-group">
              <label>Detail</label>
              <textarea name="detail" class="form-control" rows="3">{{ old('detail') }}</textarea>
            </div>
          </div>

          <div class="card-footer text-right">
            <button class="btn btn-primary">
              <i class="fas fa-save mr-2"></i>Simpan
            </button>
          </div>
        </form>
      </div>
    </section>
 </div>
@endsection