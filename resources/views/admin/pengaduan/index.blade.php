<title>Dashboard | Data Pengaduan</title>
@extends('layout.master')

@section('content')
<div class="content-wrapper" style="min-height: 1002.4px;">

    {{-- HEADER --}}
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Data Pengaduan</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ url('dashboard') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active">Data Pengaduan</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    {{-- CONTENT --}}
    <section class="content">
        <div class="card">

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
                            <th class="text-center align-middle">Nama</th>
                            <th class="text-center align-middle">Email</th>
                            <th class="text-center align-middle">Judul</th>
                            <th class="text-center align-middle">Status</th>
                            <th class="text-center align-middle">Balasan</th>
                            <th class="text-center align-middle">Tanggal</th>
                            <th class="text-center align-middle"><i class="fas fa-cog"></i></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pengaduans as $item)
                            <tr>
                                <td class="text-center align-middle">{{ $loop->iteration }}</td>
                                <td class="align-middle">{{ $item->nama }}</td>
                                <td class="align-middle">{{ $item->email }}</td>
                                <td class="align-middle">{{ $item->judul }}</td>
                                <td class="text-center align-middle">
                                    @if($item->status == 'menunggu')
                                        <span class="badge badge-warning">Menunggu</span>
                                    @elseif($item->status == 'diproses')
                                        <span class="badge badge-info">Diproses</span>
                                    @else
                                        <span class="badge badge-success">Selesai</span>
                                    @endif
                                </td>
                                <td class="text-center align-middle">
                                    <span class="badge badge-secondary">
                                        <i class="fas fa-comment mr-1"></i>
                                        {{ $item->balasanThread->count() }}
                                    </span>
                                </td>
                                <td class="text-center align-middle">
                                    {{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('d F Y') }}
                                </td>
                                <td class="text-center align-middle">

                                    {{-- TOMBOL DETAIL --}}
                                    <button class="btn btn-sm btn-primary"
                                            data-toggle="modal"
                                            data-target="#modalDetail{{ $item->id }}">
                                        <i class="fas fa-eye"></i>
                                    </button>

                                    {{-- MODAL DETAIL --}}
                                    <div class="modal fade" id="modalDetail{{ $item->id }}" tabindex="-1">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">

                                                <div class="modal-header">
                                                    <h5 class="modal-title">Detail Pengaduan</h5>
                                                    <button type="button" class="close" data-dismiss="modal">
                                                        <span>&times;</span>
                                                    </button>
                                                </div>

                                                <div class="modal-body">

                                                    {{-- INFO PENGADUAN --}}
                                                    <table class="table table-borderless">
                                                        <tr>
                                                            <td style="width:150px"><strong>Nama</strong></td>
                                                            <td>: {{ $item->nama }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td><strong>Email</strong></td>
                                                            <td>: {{ $item->email }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td><strong>Judul</strong></td>
                                                            <td>: {{ $item->judul }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td><strong>Status</strong></td>
                                                            <td>:
                                                                @if($item->status == 'menunggu')
                                                                    <span class="badge badge-warning">Menunggu</span>
                                                                @elseif($item->status == 'diproses')
                                                                    <span class="badge badge-info">Diproses</span>
                                                                @else
                                                                    <span class="badge badge-success">Selesai</span>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td><strong>Tanggal</strong></td>
                                                            <td>: {{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('d F Y') }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td><strong>Isi Pengaduan</strong></td>
                                                            <td>: {{ $item->isi }}</td>
                                                        </tr>
                                                        @if($item->foto)
                                                            <tr>
                                                                <td><strong>Foto/Bukti</strong></td>
                                                                <td>
                                                                    <a href="{{ Storage::disk('s3')->temporaryUrl($item->foto, now()->addMinutes(5)) }}"
                                                                       target="_blank">
                                                                        <img src="{{ Storage::disk('s3')->temporaryUrl($item->foto, now()->addMinutes(5)) }}"
                                                                             style="max-width:200px; border-radius:4px">
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                        @endif
                                                    </table>

                                                    <hr>

                                                    {{-- UBAH STATUS --}}
                                                    <form action="{{ route('pengaduan.status', $item->id) }}" method="POST" class="d-flex mb-3" style="gap:10px">
                                                        @csrf
                                                        <select name="status" class="form-control" style="width:200px">
                                                            <option value="menunggu" {{ $item->status == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                                                            <option value="diproses" {{ $item->status == 'diproses' ? 'selected' : '' }}>Diproses</option>
                                                            <option value="selesai"  {{ $item->status == 'selesai'  ? 'selected' : '' }}>Selesai</option>
                                                        </select>
                                                        <button type="submit" class="btn btn-primary">Simpan Status</button>
                                                    </form>

                                                    <hr>

                                                    {{-- THREAD BALASAN --}}
                                                    <h6 class="mb-3">
                                                        <strong>Balasan ({{ $item->balasanThread->count() }})</strong>
                                                    </h6>

                                                    @forelse($item->balasanThread as $b)
                                                        <div class="d-flex gap-2 mb-3">
                                                            <div class="flex-shrink-0">
                                                                <div class="rounded-circle bg-success d-flex align-items-center justify-content-center"
                                                                     style="width:36px;height:36px;">
                                                                    <i class="fas fa-user-shield text-white" style="font-size:14px;"></i>
                                                                </div>
                                                            </div>
                                                            <div class="flex-grow-1">
                                                                <div class="font-weight-bold">{{ $b->user->name ?? '-' }}</div>
                                                                <div class="text-muted small mb-1">
                                                                    {{ \Carbon\Carbon::parse($b->created_at)->translatedFormat('d F Y H:i') }}
                                                                </div>
                                                                <div class="p-2 bg-light rounded border-left border-success" style="border-left-width:3px!important;">
                                                                    {!! nl2br(e($b->isi)) !!}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @empty
                                                        <div class="text-muted small mb-3">Belum ada balasan.</div>
                                                    @endforelse

                                                    <hr>

                                                    {{-- FORM BALAS --}}
                                                    <form action="{{ route('pengaduan.balas', $item->id) }}" method="POST">
                                                        @csrf
                                                        <div class="form-group">
                                                            <label><strong>Tulis Balasan</strong></label>
                                                            <textarea name="balasan"
                                                                      class="form-control"
                                                                      rows="3"
                                                                      placeholder="Tulis balasan..."></textarea>
                                                        </div>
                                                        <button type="submit" class="btn btn-primary">
                                                            <i class="fas fa-reply mr-1"></i> Kirim Balasan
                                                        </button>
                                                    </form>

                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                    {{-- TOMBOL HAPUS --}}
                                    <button class="btn btn-sm btn-danger"
                                            data-toggle="modal"
                                            data-target="#modalHapus{{ $item->id }}">
                                        <i class="fas fa-trash"></i>
                                    </button>

                                    {{-- MODAL HAPUS --}}
                                    <div class="modal fade" id="modalHapus{{ $item->id }}" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Konfirmasi Hapus</h5>
                                                    <button type="button" class="close" data-dismiss="modal">
                                                        <span>&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    Apakah Anda yakin ingin menghapus pengaduan dari
                                                    <strong>{{ $item->nama }}</strong>?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                    <form action="{{ route('pengaduan.destroy', $item->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">Hapus</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">Belum ada data pengaduan</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                {{ $pengaduans->links('pagination::bootstrap-4') }}

            </div>

        </div>
    </section>

</div>
@endsection