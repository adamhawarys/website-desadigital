<title>Dashboard | Data Pengaduan</title>
@extends('layout.master')

@section('content')
<div class="content-wrapper" style="min-height: 1002.4px;">

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Data Pengaduan</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Data Pengaduan</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="card">
            <div class="card-body">

                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
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
                                    <button class="btn btn-sm btn-primary btn-detail"
                                            data-id="{{ $item->id }}"
                                            data-nama="{{ $item->nama }}"
                                            data-email="{{ $item->email }}"
                                            data-judul="{{ $item->judul }}"
                                            data-status="{{ $item->status }}"
                                            data-tanggal="{{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('d F Y') }}"
                                            data-isi="{{ $item->isi }}"
                                            data-toggle="modal"
                                            data-target="#modalDetail">
                                        <i class="fas fa-eye"></i>
                                    </button>

                                    {{-- TOMBOL HAPUS --}}
                                    <button class="btn btn-sm btn-danger btn-hapus"
                                            data-id="{{ $item->id }}"
                                            data-nama="{{ $item->nama }}"
                                            data-toggle="modal"
                                            data-target="#modalHapus">
                                        <i class="fas fa-trash"></i>
                                    </button>

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


{{-- MODAL DETAIL --}}
<div class="modal fade" id="modalDetail" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Detail Pengaduan</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>

            <div class="modal-body">

                {{-- INFO PENGADUAN --}}
                <table class="table table-borderless">
                    <tr>
                        <td style="width:150px"><strong>Nama</strong></td>
                        <td>: <span id="detail-nama"></span></td>
                    </tr>
                    <tr>
                        <td><strong>Email</strong></td>
                        <td>: <span id="detail-email"></span></td>
                    </tr>
                    <tr>
                        <td><strong>Judul</strong></td>
                        <td>: <span id="detail-judul"></span></td>
                    </tr>
                    <tr>
                        <td><strong>Status</strong></td>
                        <td>: <span id="detail-status-badge"></span></td>
                    </tr>
                    <tr>
                        <td><strong>Tanggal</strong></td>
                        <td>: <span id="detail-tanggal"></span></td>
                    </tr>
                    <tr>
                        <td><strong>Isi Pengaduan</strong></td>
                        <td>: <span id="detail-isi"></span></td>
                    </tr>
                </table>

                <hr>

                {{-- UBAH STATUS --}}
                <form id="formStatus" method="POST" class="d-flex mb-3" style="gap:10px">
                    @csrf
                    <select name="status" id="selectStatus" class="form-control" style="width:200px">
                        <option value="menunggu">Menunggu</option>
                        <option value="diproses">Diproses</option>
                        <option value="selesai">Selesai</option>
                    </select>
                    <button type="submit" class="btn btn-primary">Simpan Status</button>
                </form>

                <hr>

                {{-- THREAD BALASAN --}}
                <h6 class="mb-3"><strong>Balasan</strong></h6>
                <div id="thread-balasan" class="mb-3">
                    {{-- diisi via JavaScript --}}
                </div>

                <hr>

                {{-- FORM BALAS --}}
                <form id="formBalas" method="POST">
                    @csrf
                    <div class="form-group">
                        <label><strong>Tulis Balasan</strong></label>
                        <textarea name="balasan" class="form-control" rows="3" placeholder="Tulis balasan..."></textarea>
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


{{-- MODAL HAPUS --}}
<div class="modal fade" id="modalHapus" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Konfirmasi Hapus</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                Apakah Anda yakin ingin menghapus pengaduan dari
                <strong id="hapus-nama"></strong>?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <form id="formHapus" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>


{{-- SCRIPT --}}
<script>
document.addEventListener('DOMContentLoaded', function () {

    // Data balasan per pengaduan (dari blade)
    const balasanData = {
        @foreach($pengaduans as $item)
        {{ $item->id }}: {
            balasan: [
                @foreach($item->balasanThread as $b)
                {
                    nama: "{{ addslashes($b->user->name ?? '-') }}",
                    tanggal: "{{ \Carbon\Carbon::parse($b->created_at)->translatedFormat('d F Y H:i') }}",
                    isi: "{{ addslashes($b->isi) }}"
                },
                @endforeach
            ],
            routeStatus: "{{ route('pengaduan.status', $item->id) }}",
            routeBalas: "{{ route('pengaduan.balas', $item->id) }}",
            status: "{{ $item->status }}"
        },
        @endforeach
    };

    // TOMBOL DETAIL
    document.querySelectorAll('.btn-detail').forEach(function (btn) {
        btn.addEventListener('click', function () {
            const id     = this.getAttribute('data-id');
            const data   = balasanData[id];
            const status = this.getAttribute('data-status');

            document.getElementById('detail-nama').textContent    = this.getAttribute('data-nama');
            document.getElementById('detail-email').textContent   = this.getAttribute('data-email');
            document.getElementById('detail-judul').textContent   = this.getAttribute('data-judul');
            document.getElementById('detail-tanggal').textContent = this.getAttribute('data-tanggal');
            document.getElementById('detail-isi').textContent     = this.getAttribute('data-isi');

            // Badge status
            const badgeMap = {
                'menunggu': '<span class="badge badge-warning">Menunggu</span>',
                'diproses': '<span class="badge badge-info">Diproses</span>',
                'selesai':  '<span class="badge badge-success">Selesai</span>',
            };
            document.getElementById('detail-status-badge').innerHTML = badgeMap[status] || status;

            // Select status
            document.getElementById('selectStatus').value = status;

            // Route form
            document.getElementById('formStatus').action = data.routeStatus;
            document.getElementById('formBalas').action  = data.routeBalas;

            // Thread balasan
            const threadEl = document.getElementById('thread-balasan');
            if (data.balasan.length === 0) {
                threadEl.innerHTML = '<div class="text-muted small">Belum ada balasan.</div>';
            } else {
                threadEl.innerHTML = data.balasan.map(b => `
                    <div class="d-flex gap-2 mb-3">
                        <div class="flex-shrink-0">
                            <div class="rounded-circle bg-success d-flex align-items-center justify-content-center"
                                 style="width:36px;height:36px;">
                                <i class="fas fa-user-shield text-white" style="font-size:14px;"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <div class="font-weight-bold">${b.nama}</div>
                            <div class="text-muted small mb-1">${b.tanggal}</div>
                            <div class="p-2 bg-light rounded border-left border-success" style="border-left-width:3px!important;">
                                ${b.isi.replace(/\n/g, '<br>')}
                            </div>
                        </div>
                    </div>
                `).join('');
            }
        });
    });

    // TOMBOL HAPUS
    document.querySelectorAll('.btn-hapus').forEach(function (btn) {
        btn.addEventListener('click', function () {
            const id   = this.getAttribute('data-id');
            const nama = this.getAttribute('data-nama');

            document.getElementById('hapus-nama').textContent = nama;
            document.getElementById('formHapus').action = `/dashboard/pengaduan/${id}`;
        });
    });

});
</script>

@endsection