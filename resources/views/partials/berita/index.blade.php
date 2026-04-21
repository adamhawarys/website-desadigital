<div class="row g-0">
  <div class="col-12">
    <div class="row g-4 berita-list">

      @foreach ($berita as $item)
        <div class="col-12 col-md-6 col-lg-4">
          <article class="h-100">
            <div class="berita-img">
              <img src="{{ Storage::disk('s3')->url($item->gambar) }}"
                   class="img-fluid w-100"
                   alt="{{ $item->judul }}">
            </div>

            <p class="berita-date py-2 mb-1">
              <i class="fas fa-clock"></i>
              <time>{{ $item->tanggal_publikasi }}</time>
            </p>

            <h6 class="berita-title mb-0">
              <a href="{{ route('berita.detail', $item->slug) }}">{{ $item->judul }}</a>
            </h6>
          </article>
        </div>
      @endforeach

    </div>
  </div>
</div>
