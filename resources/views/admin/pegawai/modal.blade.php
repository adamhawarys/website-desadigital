<!-- Modal -->
<div class="modal fade" id="exampleModal{{ $item->id }}" tabindex="-1" >
<!-- Vertically centered scrollable modal -->
<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title" id="exampleModalLabel">Hapus Data Perangkat Desa ?</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" class="text-white">&times;</span>
        </button>
      </div>
      <div class="modal-body text-left">
          <div class="row mb-2">
              <div class="col-6">
                  Nama Pejabat
              </div>
              <div class="col-6">
                  : {{ $item->nama_pejabat }}
              </div>
          </div>
          <div class="row mb-2">
              <div class="col-6">
                  Jabatan
              </div>
              <div class="col-6">
                  : {{ $item->jabatan }}
              </div>
          </div>
          <div class="row mb-2">
              <div class="col-6">
                  Tempat Tanggal Lahir
              </div>
              <div class="col-6">
                  : {{ $item->tempat_lahir}}, {{ $item->tanggal_lahir }}
              </div>
          </div>
          <div class="row mb-2">
              <div class="col-6">
                  Jenis Kelamin
              </div>
              <div class="col-6">
                  : {{ $item->jenis_kelamin}}
              </div>
          </div>
          <div class="row mb-2">
              <div class="col-6">
                  Pendidikan
              </div>
              <div class="col-6">
                  : {{ $item->pendidikan}}
              </div>
          </div>
          <div class="row mb-2">
              <div class="col-6">
                  Nomor SK
              </div>
              <div class="col-6">
                  : {{ $item->nomor_sk}}
              </div>
          </div>
          <div class="row mb-2">
              <div class="col-6">
                  Tanggal SK
              </div>
              <div class="col-6">
                  : {{ $item->tanggal_sk}}
              </div>
          </div>
          <div class="row mb-2">
              <div class="col-6">
                  Amalat
              </div>
              <div class="col-6">
                  : {{ $item->alamat}}
              </div>
          </div>

        
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">
            <i class="fas fa-times"></i>
            Tutup</button>

          <form action="{{route('pegawai.destroy', $item->id)}}" method="post">
            @csrf
            @method('delete')
            <button type="submit" class="btn btn-danger btn-sm">
            <i class="fas fa-times"></i>
            Hapus</button>
            </form>
      </div>
    </div>
  </div>
</div>