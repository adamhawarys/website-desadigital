<div class="row">
    <div class="agenda-list">
        @forelse ($agenda as $item)
        <article class="agenda-card p-4">

            <div class="agenda-header">
                <div style="flex: 1">
                    <h2 class="agenda-title mb-2">
                        <a href="#">{{ strtoupper($item->judul) }}</a>
                    </h2>

                    <div class="agenda-meta d-flex flex-column gap-2">
                        <div>
                            <i class="bi bi-clock"></i>
                            {{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d F Y') }}
                        </div>
                        <div>
                            <i class="bi bi-geo-alt"></i>
                            Lokasi: <span class="fw-medium text-dark">{{ $item->lokasi }}</span>
                        </div>
                    </div>
                </div>

                <div class="faq-toggle">
                    <i class="bi bi-chevron-right"></i>
                </div>
            </div>

            <div class="agenda-detail">
                <p class="text-muted mb-0" style="font-size: 15px; line-height: 1.6;">
                    {{ $item->detail }}
                </p>
            </div>

        </article>
        @empty
        <div class="text-center py-5" style="background: #ffffff; border-radius: 10px; box-shadow: 0 8px 25px rgba(0,0,0,0.04);">
            <i class="bi bi-calendar-x fs-1 text-muted mb-3 d-block"></i>
            <p class="text-muted">Belum ada data agenda.</p>
        </div>
        @endforelse
    </div>
</div>