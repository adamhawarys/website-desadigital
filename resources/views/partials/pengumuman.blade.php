<div class="faq-container">

    @forelse ($pengumuman as $item)

<div class="faq-item">

    <div class="faq-header">
        <h3>{{ $item->judul }}</h3>

        <div class="faq-toggle">
            <i class="bi bi-chevron-right"></i>
        </div>
    </div>

    <div class="faq-content">
        <p>
            <time class="faq-meta fw-bold">
                {{ $item->tanggal_mulai }} - {{ $item->tanggal_selesai }} | {{ ucfirst($item->status) }}
            </time>
            <br>
            {{ $item->deskripsi }}
        </p>
    </div>

</div>
    @empty

        <div class="text-center py-4">
            <div class="alert alert-info">
                Belum ada pengumuman yang tersedia.
            </div>
        </div>

    @endforelse

</div>