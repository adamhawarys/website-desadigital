<div class="faq-container">

          @forelse($agenda as $agenda)
          <div class="agenda-item d-flex align-items-start mb-4">
            
            <div class="date-box text-center text-white p-2" style="background-color: #1a73e8; min-width: 70px; border-radius: 4px;">
              <div style="font-size: 0.7rem; text-transform: uppercase;">{{ $agenda->tanggal->translatedFormat('M Y') }}</div>
              <div style="font-size: 1.5rem; font-weight: bold; line-height: 1;">{{ $agenda->tanggal->format('d') }}</div>
            </div>
            
            <div class="ms-3">
              <h6 class="mb-1" style="font-weight: bold; text-transform: uppercase; color: #555;">
                {{ $agenda->judul }}
              </h6>
              <p style="font-size: 0.85rem; color: #777; margin-bottom: 0;">
                <i class="bi bi-geo-alt-fill text-danger"></i> Lokasi: {{ $agenda->lokasi }}
              </p>
            </div>

          </div>
          @empty
          <div class="text-center py-4">
            <div class="alert alert-info">
                Belum ada agenda kegiatan yang dijadwalkan.
            </div>
        </div>
          @endforelse
        



</div>