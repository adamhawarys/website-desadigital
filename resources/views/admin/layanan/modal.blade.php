<div class="modal fade" id="exampleModal{{ $item->id }}" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">

      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title" id="#exampleModal">Hapus Data Layanan ?</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" class="text-white">&times;</span>
        </button>
      </div>

      <div class="modal-body text-left">

        <div class="row mb-2">
            <div class="col-6">Nama Layanan</div>
            <div class="col-6">: {{ $item->nama_layanan }}</div>
        </div>

        <div class="row mb-2">
            <div class="col-6">Kode</div>
            <div class="col-6">
                : 
                    {{ $item->kode_layanan }}
                  
            </div>
        </div>

        {{-- <div class="row mb-2">
            <div class="col-6">Status</div>
            <div class="col-6">
                :
                @if($item->status == 'aktif')
                    <span class="badge badge-success">Aktif</span>
                @else
                    <span class="badge badge-danger">Nonaktif</span>
                @endif
            </div>
        </div> --}}

      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">
           <i class="fas fa-times"></i>
            Tutup
        </button>

        <form action="{{ route('layanan.destroy', $item->id) }}" method="post">
            @csrf
            @method('delete')
            <button type="submit" class="btn btn-danger btn-sm">
                <i class="fas fa-times"></i>
                Hapus
            </button>
        </form>
      </div>

    </div>
  </div>
</div>