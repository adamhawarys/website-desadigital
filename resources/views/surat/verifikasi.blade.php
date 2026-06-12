<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Surat - Desa Digital</title>
</head>
<body style="font-family: Arial; max-width: 600px; margin: 40px auto; padding: 20px;">

@if($valid)
    <div style="border: 2px solid #2d6a4f; border-radius: 8px; padding: 24px;">
        <h2 style="color: #2d6a4f;">✓ Surat Valid</h2>
        <p style="color: #555;">Surat ini adalah dokumen resmi yang diterbitkan oleh Desa Bengkel.</p>
        <hr>
        <table style="width:100%; border-collapse: collapse;">
            <tr>
                <td style="color:#666; padding:8px; width:40%;">Nomor Surat</td>
                <td style="padding:8px;"><strong>{{ $pengajuan->nomor_surat }}</strong></td>
            </tr>
            <tr>
                <td style="color:#666; padding:8px;">Nama Pemohon</td>
                <td style="padding:8px;">
                    {{ $pengajuan->penduduk->nama_lengkap 
                        ?? $pengajuan->user?->penduduk?->nama_lengkap 
                        ?? '-' }}
                </td>
            </tr>
            <tr>
                <td style="color:#666; padding:8px;">Jenis Surat</td>
                <td style="padding:8px;">{{ $pengajuan->layanan->nama_layanan ?? '-' }}</td>
            </tr>
            <tr>
                <td style="color:#666; padding:8px;">Tanggal Disetujui</td>
                <td style="padding:8px;">
                    {{ \Carbon\Carbon::parse($pengajuan->tanggal_disetujui)->translatedFormat('d F Y') }}
                </td>
            </tr>
        </table>
    </div>
@else
    <div style="border: 2px solid #e63946; border-radius: 8px; padding: 24px;">
        <h2 style="color: #e63946;">✗ Surat Tidak Valid</h2>
        <p style="color: #555;">Surat ini tidak ditemukan atau telah dimanipulasi.</p>
    </div>
@endif

</body>
</html>