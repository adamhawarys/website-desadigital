<div class="row"> 
  @forelse($galeri as $item)
    <div class="col-md-6 mb-4">
      
      <div class="card border-0 shadow-sm rounded overflow-hidden">
        
        <a href="{{ Storage::disk('s3')->url($item->foto) }}" 
           class="glightbox" 
           data-gallery="images-gallery"
           data-title="{{ $item->judul }}" 
           data-description="{{ $item->deskripsi }}"
           data-glightbox="descPosition: right;"> 
           <img src="{{ Storage::disk('s3')->url($item->foto) }}" 
               class="card-img-top w-100" 
               alt="{{ $item->judul ?? 'Galeri Desa' }}"
               style="height: 250px; object-fit: cover;">
               
        </a>
        
      </div>
      
    </div>
  @empty
    <div class="col-12 text-center py-5">
        <h5 class="text-muted">Belum ada foto di galeri.</h5>
    </div>
  @endforelse
</div>

<div class="mt-4 d-flex justify-content-center">
    {{ $galeri->links('pagination::bootstrap-4') }}
</div>