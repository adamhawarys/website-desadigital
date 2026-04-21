<title>Dashboard | Statistik</title>
@extends('layout.master')

@section('content')
 <div class="content-wrapper" style="min-height: 1302.4px;">
    <section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Statistik</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="dashboard">Dashboard</a></li>
              <li class="breadcrumb-item active">Statistik</li>
            </ol>
          </div>
        </div>
  </div>
</section>

<section class="content">
  <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Jumlah Penduduk Berdasarkan Dusun</h3>
                </div>

                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="text-center align-middle">No</th>
                                <th class="text-center align-middle">Nama Dusun</th>
                                <th class="text-center align-middle">Nama Kepala Dusun</th>
                                <th class="text-center align-middle">Laki-laki</th>
                                <th class="text-center align-middle">Perempuan</th>
                                <th class="text-center align-middle">Jumlah Penduduk</th>
                                <th class="text-center align-middle"><i class="fas fa-cog"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($data as $item)
                                <tr>
                                    <td class="text-center align-middle">{{ $loop->iteration }}</td>
                                    <td class="text-center align-middle">{{ $item->nama_dusun }}</td>
                                    <td class="text-center align-middle">{{ $item->nama_kepala_dusun }}</td>
                                    <td class="text-center align-middle">{{ $item->jumlah_laki_laki }}</td>
                                    <td class="text-center align-middle">{{ $item->jumlah_perempuan }}</td>

                                    {{-- HITUNG OTOMATIS --}}
                                    <td class="text-center align-middle">
                                        {{ $item->jumlah_laki_laki + $item->jumlah_perempuan }}
                                    </td>

                                    <td class="text-center">
                                        <a href="{{ route('statistik.edit', $item->id) }}" class="btn btn-sm btn-warning">
                                          <i class="fas fa-edit"></i>
                                        </a>
                                        <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#exampleModal{{ $item->id }}">
                                          <i class="fas fa-trash"></i>
                                        </button>
                                        @include('admin.statistik.modal')
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">
                                        Data statistik belum tersedia
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
  <div class="container-fluid">
    <div class="row">
        <div class="col-md-6">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Jumlah Penduduk Berdasarkan Usia</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      
                      <th>Rentang Usia</th>
                      <th>Jumlah</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>0-15 Tahun</td>
                      <td>2,270</td>
                    </tr>
                    <tr>
                      <td>15-30 Tahun</td>
                      <td>2,637</td>
                    </tr>
                    <tr>
                      <td>31-60 Tahun</td>
                      <td>4,122</td>
                    </tr>
                    <tr>
                      <td>61-keatas</td>
                      <td>852</td>
                    </tr>
                   
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Jumlah KK</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <table class="table">
                  <thead>
                    <tr>
                      
                      <th>Keterangan</th>
                      <th>Jumlah</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>Kepala Keluarga</td>
                      <td>2,979</td>
                    </tr>
                   
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Jumlah Penduduk Berdasarkan Pendidikan</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      
                      <th>Jenjang Pendidikan</th>
                      <th>Jumlah</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>Tidak Sekolah</td>
                      <td>1,816</td>
                    </tr>
                    <tr>
                      <td>SD</td>
                      <td>3,168</td>
                    </tr>
                    <tr>
                      <td>SMP</td>
                      <td>1,763</td>
                    </tr>
                    <tr>
                      <td>SMA</td>
                      <td>2,706</td>
                    </tr>
                    <tr>
                      <td>D1</td>
                      <td>4</td>
                    </tr>
                    <tr>
                      <td>D2</td>
                      <td>0</td>
                    </tr>
                    <tr>
                      <td>D3</td>
                      <td>1</td>
                    </tr>
                    <tr>
                      <td>D4</td>
                      <td>4</td>
                    </tr>
                    <tr>
                      <td>S1</td>
                      <td>23</td>
                    </tr>
                    <tr>
                      <td>S2</td>
                      <td>3</td>
                    </tr>
                    <tr>
                      <td>S3</td>
                      <td>0</td>
                    </tr>
                   
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
    </div>
    </div>
  </div>
</section>
  </div>

@endsection
