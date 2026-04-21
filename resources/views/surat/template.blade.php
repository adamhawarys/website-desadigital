<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Keterangan</title>
<style>
    /* Reset margin untuk area surat */
    .kertas-surat {
        font-family: 'Times New Roman', Times, serif;
        width: 100%;
        margin: 0;
        padding: 0;
    }

    /* ====== KOP SURAT ====== */
    .kop-surat {
        width: 100%;
        border-bottom: 3px solid black; /* Garis bawah tebal */
        margin-bottom: 15px;
        padding-bottom: 10px;
    }
    .tabel-kop {
        width: 100%;
        border-collapse: collapse;
    }
    .tabel-kop td {
        vertical-align: middle;
    }
    
    /* Perubahan pembagian 3 kolom */
    .kolom-logo-kiri {
        width: 15%; 
        text-align: left;
    }
    .kolom-logo-kanan {
        width: 15%; 
        text-align: right; /* Tarik logo ke kanan */
    }
    .kolom-teks {
        width: 70%; /* Diperkecil agar proporsional */
        text-align: center;
    }
    
    .kolom-logo-kiri img, .kolom-logo-kanan img {
        width: 80px; /* Sesuaikan ukuran logo */
        height: auto;
    }
    
    .pemerintah { font-size: 16px; font-weight: normal; line-height: 1.2; }
    .nama-desa { font-size: 22px; font-weight: bold; line-height: 1.2; margin-top: 5px; }
    .alamat { font-size: 12px; margin-top: 5px; font-style: italic;}

    /* ====== ISI SURAT ====== */
    .isi-surat {
        width: 100%;
        text-align: justify;
        line-height: 1.5;
        font-size: 14px;
    }
    /* Mematikan margin liar dari Summernote/WYSIWYG */
    .isi-surat p {
        margin-top: 0;
        margin-bottom: 10px;
        padding: 0;
    }

    /* ====== TANDA TANGAN ====== */
    .ttd-container {
        width: 100%;
        margin-top: 40px;
    }
    .ttd-box {
        float: right; /* Tarik TTD ke pojok kanan */
        width: 300px;
        text-align: center;
    }
    .nama-kades {
        margin-top: 60px; /* Ruang untuk tanda tangan basah/stempel */
        font-weight: bold;
        text-decoration: underline;
    }
    /* Clearfix untuk float */
    .clearfix::after {
        content: "";
        clear: both;
        display: table;
    }
</style>
</head>
<body>

<div class="kertas-surat">
    {{-- ====== KOP SURAT ====== --}}
    <div class="kop-surat">
        <table class="tabel-kop">
            <tr>
                <td class="kolom-logo-kiri">
                    @if(!empty($logoKabBase64))
                        <img src="{{ $logoKabBase64 }}" alt="Logo Kabupaten">
                    @else
                        Logo Kabupaten
                    @endif
                </td>
                
                <td class="kolom-teks">
                    <div class="pemerintah">PEMERINTAH KABUPATEN LOMBOK BARAT <br> KECAMATAN LABUAPI</div>
                    <div class="nama-desa">DESA {{ strtoupper($profil->nama_desa ?? 'NAMA DESA') }}</div>
                    <div class="alamat">
                        {{ $profil->alamat ?? '-' }}
                        @if($profil && $profil->kode_pos)
                            &nbsp;&mdash;&nbsp; Kode Pos: {{ $profil->kode_pos }}
                        @endif
                    </div>
                </td>
                
                <td class="kolom-logo-kanan">
                    @if(!empty($logoBase64))
                        <img src="{{ $logoBase64 }}" alt="Logo Desa">
                    @endif
                </td>
            </tr>
        </table>
    </div>

    {{-- ====== ISI SURAT ====== --}}
    <div class="isi-surat">
        {!! $template !!}
    </div>

    {{-- ====== TANDA TANGAN ====== --}}
    <div class="ttd-container clearfix">
        <div class="ttd-box">
            <div>{{ $profil->nama_desa ?? 'Bengkel' }}, {{ $tanggalDisetujui }}</div>
            <div class="jabatan">Kepala Desa {{ $profil->nama_desa ?? 'Bengkel' }}</div>
            <div class="nama-kades">{{ $profil->kades ?? 'NAMA KEPALA DESA' }}</div>
        </div>
    </div>
</div>

</body>
</html>