<div class="sidebar">

  {{-- Search --}}
<div class="sidebar-item search-form">
  <h3 class="sidebar-title">Cari Berita</h3>

  <form action="" method="GET" class="mt-3 d-flex align-items-center gap-2">
    <input
      type="text"
      name="table_search"
      value="{{ request('table_search') }}"
      placeholder="Cari berita..."
      maxlength="25"
      class="form-control"
      style="border-radius: 50px;"
    >

    <button
      type="submit"
      class="btn btn-primary"
      style="border-radius: 50px; padding: 10px 16px;"
      aria-label="Cari"
    >
      <i class="bi bi-search"></i>
    </button>
  </form>
</div>


  {{-- Recent Posts --}}
  <div class="sidebar-item recent-posts">
    <h3 class="sidebar-title">Berita Terkini</h3>

    <div class="mt-3">
      @forelse($beritaTerbaru as $item)
        <div class="post-item clearfix">
          <img src="{{ Storage::disk('s3')->url($item->gambar) }}" alt="{{ $item->judul }}">

          <div>
            <h4 class="mb-0">
              <a href="{{ route('berita.detail', $item->slug) }}">
                {{ $item->judul }}
              </a>
            </h4>
            <time>{{ $item->tanggal_publikasi }}</time>
          </div>
        </div>
      @empty
        <p class="text-muted mb-0">Belum ada berita.</p>
      @endforelse
    </div>
  </div>

</div>
