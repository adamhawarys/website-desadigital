<!-- Modal -->
<div class="modal fade" id="exampleModal{{ $item->id }}" tabindex="-1" >
<!-- Vertically centered scrollable modal -->
<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title" id="exampleModalLabel">Hapus Data?</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" class="text-white">&times;</span>
        </button>
      </div>
      <div class="modal-body text-left">
          <div class="row mb-2">
              <div class="col-6">
                  Nama Dusun
              </div>
              <div class="col-6">
                  : {{ $item->nama_dusun}}
              </div>
          </div>
          <div class="row mb-2">
              <div class="col-6">
                  Nama Kepala Dusun
              </div>
              <div class="col-6">
                  : {{ $item->nama_kepala_dusun }}
              </div>
          </div>
          <div class="row mb-2">
              <div class="col-6">
                  Laki-laki
              </div>
              <div class="col-6">
                  : {{ $item->jumlah_laki_laki }}
              </div>
          </div>
          <div class="row mb-2">
              <div class="col-6">
                  Perempuan 
              </div>
              <div class="col-6">
                  : {{ $item->jumlah_perempuan }}
              </div>
          </div>
          <div class="row mb-2">
              <div class="col-6">
                  Jumlah Penduduk
              </div>
              <div class="col-6">
                  : {{ $item->jumlah_laki_laki + $item->jumlah_perempuan }}
              </div>
          </div>
          

        
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">
            <i class="fas fa-times"></i>
            Tutup</button>

          <form action="{{route('statistik.destroy', $item->id)}}" method="post">
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