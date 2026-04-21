<title>Dashboard | Data Pengajuan</title>
@extends('layout.master')

@section('content')
<div class="content-wrapper">

    {{-- HEADER --}}
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Data Pengajuan</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('dashboard') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active">
                            Data Pengajuan
                        </li>
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
                <div class="row">

                     <div class="col-sm-6">
                        <a href="{{ route('pengajuan.create') }}" 
                           class="btn btn-sm btn-primary">
                            <i class="fas fa-plus mr-2"></i>
                            Buat Pengajuan
                        </a>
                    </div>

                    <div class="col-sm-6">
                        <div class="card-tools float-right">
                            <form method="GET">
                                <div class="input-group input-group-sm" style="width: 300px;">
                                    <input type="text"
                                           name="search"
                                           class="form-control float-right"
                                           placeholder="Search"
                                           value="{{ request('search') }}">

                                    <div class="input-group-append">
                                        <button type="submit"
                                                class="btn btn-default">
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

                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th class="text-center align-middle">No</th>
                            <th class="text-center align-middle">Nama Pemohon</th>
                            <th class="text-center align-middle">Layanan</th>
                            <th class="text-center align-middle">Tanggal Pengajuan</th>
                            <th class="text-center align-middle">Status</th>
                            <th class="text-center align-middle">
                                <i class="fas fa-cog"></i>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pengajuan as $index => $item)
                            <tr>

                                <td class="text-center align-middle">
                                    {{ $pengajuan->firstItem() + $index }}
                                </td>

                                <td class="align-middle">
                                    {{ $item->user->name ?? '-' }}
                                </td>

                                <td class="align-middle">
                                    {{ $item->layanan->nama_layanan ?? '-' }}
                                </td>

                                <td class="text-center align-middle">
                                    {{ \Carbon\Carbon::parse($item->tanggal_pengajuan)->format('d-m-Y') }}
                                </td>

                                {{-- STATUS --}}
                                <td class="text-center align-middle">
                                    @if($item->status == 'Menunggu Diproses')
                                        <span class="badge badge-warning">
                                            Menunggu Diproses
                                        </span>
                                    @elseif($item->status == 'Disetujui')
                                        <span class="badge badge-success">
                                            Disetujui
                                        </span>
                                    @elseif($item->status == 'Ditolak')
                                        <span class="badge badge-danger">
                                            Ditolak
                                        </span>
                                    @else
                                        <span class="badge badge-secondary">
                                            -
                                        </span>
                                    @endif
                                </td>

                                {{-- ACTION --}}
                                <td class="text-center align-middle">
                                    <div class="d-flex justify-content-center" style="gap:6px;">

                                        {{-- DETAIL --}}
                                        <a href="{{ route('pengajuan.detail', $item->id) }}"
                                        class="btn btn-sm btn-info"
                                        title="Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>

                                        {{-- HAPUS --}}
                                        <button type="button"
                                            class="btn btn-sm btn-danger btn-hapus"
                                            data-id="{{ $item->id }}"
                                            data-nama="{{ $item->user->name ?? '-' }}"
                                            data-layanan="{{ $item->layanan->nama_layanan ?? '-' }}"
                                            data-tanggal="{{ \Carbon\Carbon::parse($item->tanggal_pengajuan)->format('d-m-Y') }}"
                                            data-status="{{ $item->status ?? '-' }}"
                                            data-keperluan="{{ $item->keperluan ?? '-' }}"
                                            data-toggle="modal"
                                            data-target="#modalHapus"
                                            title="Hapus">
                                        <i class="fas fa-trash"></i>
                                        </button>

                                    </div>
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">
                                    Belum ada data pengajuan
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

            </div>

            {{-- PAGINATION --}}
            <div class="card-footer clearfix">
                {{ $pengajuan->links('pagination::bootstrap-4') }}
            </div>

        </div>
    </section>

</div>

{{-- MODAL HAPUS --}}
<div class="modal fade" id="modalHapus" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header bg-danger">
                <h5 class="modal-title text-white">
                    Konfirmasi Hapus Pengajuan
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>

            <form id="formHapus" method="POST">
                @csrf
                @method('DELETE')

                <div class="modal-body">

                    <div class="alert alert-danger">
                        Anda yakin ingin menghapus pengajuan berikut?
                    </div>

                    <div class="border rounded p-3" style="background:#f8f9fa;">

                        <div class="row mb-2">
                            <div class="col-md-6">
                                <small class="text-muted d-block">Nama Pemohon</small>
                                <strong id="m_nama">-</strong>
                            </div>

                            <div class="col-md-6">
                                <small class="text-muted d-block">Layanan</small>
                                <strong id="m_layanan">-</strong>
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-md-6">
                                <small class="text-muted d-block">Tanggal</small>
                                <strong id="m_tanggal">-</strong>
                            </div>

                            <div class="col-md-6">
                                <small class="text-muted d-block">Status</small>
                                <strong id="m_status">-</strong>
                            </div>
                        </div>

                        <div>
                            <small class="text-muted d-block">Keperluan</small>
                            <div class="border rounded p-2 bg-white" id="m_keperluan">
                                -
                            </div>
                        </div>

                    </div>

                    <p class="mt-3 text-danger small">
                        Data yang sudah dihapus tidak dapat dikembalikan.
                    </p>

                </div>

                <div class="modal-footer">
                    <button type="button"
                            class="btn btn-secondary"
                            data-dismiss="modal">
                        Batal
                    </button>

                    <button type="submit"
                            class="btn btn-danger">
                        <i class="fas fa-trash mr-1"></i> Hapus
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const form = document.getElementById('formHapus');

    const mNama = document.getElementById('m_nama');
    const mLayanan = document.getElementById('m_layanan');
    const mTanggal = document.getElementById('m_tanggal');
    const mStatus = document.getElementById('m_status');
    const mKeperluan = document.getElementById('m_keperluan');

    document.querySelectorAll('.btn-hapus').forEach(btn => {
        btn.addEventListener('click', function () {

            const id = this.dataset.id;

            mNama.textContent = this.dataset.nama || '-';
            mLayanan.textContent = this.dataset.layanan || '-';
            mTanggal.textContent = this.dataset.tanggal || '-';
            mStatus.textContent = this.dataset.status || '-';
            mKeperluan.textContent = this.dataset.keperluan || '-';

            form.action = "{{ url('dashboard/pengajuan') }}/" + id;
        });
    });

});
</script>

@endsection