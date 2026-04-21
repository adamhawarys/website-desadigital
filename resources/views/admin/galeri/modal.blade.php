<div class="modal fade" id="exampleModal{{ $item->id }}" tabindex="-1" >
<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title" id="exampleModalLabel">Hapus Foto Galeri ?</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" class="text-white">&times;</span>
        </button>
      </div>
      <div class="modal-body text-left">

        <div class="row mb-2">
            <div class="col-6">
                Foto
            </div>
            <div class="col-6">
                : 
                @if ($item->foto)
                    <img src="{{ Storage::disk('s3')->url($item->foto) }}" class="img-thumbnail mt-1" style="max-width: 120px;" alt="{{ $item->judul }}">
                @else
                    <span class="text-danger">Tidak ada foto</span>
                @endif
            </div>
        </div>

        <div class="row mb-2">
            <div class="col-6">
                Judul
            </div>
            <div class="col-6">
                : {{ $item->judul ?? '-' }}
            </div>
        </div>

        <div class="row mb-2">
            <div class="col-6">
                Deskripsi
            </div>
            <div class="col-6">
                : {{ $item->deskripsi ? \Illuminate\Support\Str::limit($item->deskripsi, 50) : '-' }}
            </div>
        </div>
        
        <div class="row mb-2">
            <div class="col-6">
                Status
            </div>
            <div class="col-6">
                : 
                @if ($item->status == 'aktif')
                  <span class="badge badge-success">
                    Aktif
                  </span>
                @elseif($item->status == 'nonaktif')
                  <span class="badge badge-danger">
                    Nonaktif
                  </span>
                @endif
            </div>
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">
            <i class="fas fa-times"></i>
            Tutup
        </button>

        <form action="{{ route('galeri.destroy', $item->id) }}" method="post">
            @csrf
            @method('delete')
            <button type="submit" class="btn btn-danger btn-sm">
                <i class="fas fa-trash"></i>
                Hapus
            </button>
        </form>
      </div>
    </div>
  </div>
</div>