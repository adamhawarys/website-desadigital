<!-- Modal -->
<div class="modal fade" id="exampleModal{{ $item->id }}" tabindex="-1" >
<!-- Vertically centered scrollable modal -->
<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title" id="exampleModalLabel">Hapus Berita ?</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" class="text-white">&times;</span>
        </button>
      </div>
      <div class="modal-body text-left">

        <div class="row mb-2">
            <div class="col-6">
                Gambar
            </div>
            <div class="col-6">
                : <img src="{{ Storage::disk('s3')->url($item->gambar) }}" class="img-thumbnail" alt="{{ $item->judul }}">
            </div>
        </div>

        <div class="row mb-2">
            <div class="col-6">
                Judul
            </div>
            <div class="col-6">
                : {{ $item->judul }}
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-6">
                Slug
            </div>
            <div class="col-6">
                : {{ $item->slug }}
            </div>
        </div>

        <div class="row mb-2">
            <div class="col-6">
                Penulis
            </div>
            <div class="col-6">
                :@if ( $item->penulis->name == 'Administrator')
                <span class="badge badge-danger">
                    {{ $item->penulis->name}}
                </span>
                @endif 
                @if ( $item->penulis->name == 'Petugas')
                <span class="badge badge-info">
                    {{ $item->penulis->name}}
                </span>
                @endif 
                
            </div>
            
        </div>
        
        <div class="row mb-2">
            <div class="col-6">
                Status
            </div>
            <div class="col-6">
                : @if ($item->status == 'draft')
                  <span class="badge badge-warning">
                    {{ $item->status }}
                  </span>

                  @elseif($item->status == 'published')
                  <span class="badge badge-success">
                    {{ $item->status }}
                  </span>

                  @elseif($item->status == 'archived')
                  <span class="badge badge-danger">
                    {{ $item->status }}
                  </span>
                @endif
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-6">
                Tanggal Publikasi
            </div>
            <div class="col-6">
                : {{ $item->tanggal_publikasi }}
            </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">
            <i class="fas fa-times"></i>
            Tutup</button>

          <form action="{{route('berita.destroy', $item->id)}}" method="post">
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