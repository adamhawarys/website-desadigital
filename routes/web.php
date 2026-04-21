<?php

use App\Http\Controllers\AgendaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DetailLayananController;
use App\Http\Controllers\GaleriController;
use App\Http\Controllers\LayananMandiriController;
use App\Http\Controllers\LayananSuratController;
use App\Http\Controllers\PendudukController;
use App\Http\Controllers\PengajuanController;
use App\Http\Controllers\PengumumanController;
use App\Http\Controllers\PerangkatDesaController;
use App\Http\Controllers\PersyaratanController;
use App\Http\Controllers\PortalController;
use App\Http\Controllers\ProfilDesaController;
use App\Http\Controllers\SejarahDesaController;
use App\Http\Controllers\StatistikController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\VerifikasiController;
use App\Http\Controllers\VisiMisiController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NotifikasiController;
use App\Http\Controllers\PengaduanController;
use App\Http\Controllers\SnsWebhookController;


// PORTAL
// Route::get('/', function () {
//     return view('welcome');})->name('welcome');

Route::get('/', [PortalController::class, 'welcome'])->name('welcome');


// BERITA
Route::get('/berita', [PortalController::class, 'berita'])
    ->name('berita');
Route::get('/berita/detail/{slug}', [BeritaController::class, 'detail']
    )->name('berita.detail');
// BERITA END

// AGENDA
Route::get('/agenda', [PortalController::class, 'agenda'])
    ->name('agenda');
// AGENDA END

// GALERI
Route::get('/galeri', [PortalController::class, 'galeri'])
    ->name('galeri');
// GALERI END

// LAYANAN
Route::get('/layanan/detail/{slug}', [PortalController::class, 'layanan_detail'])->name('layanan.detail');
// LAYANAN END

Route::get('/visi-misi', [PortalController::class, 'visimisi'])
    ->name('visimisi');
Route::get('/sejarah-desa', [PortalController::class, 'sejarah'])
    ->name('sejarah');
Route::get('/perangkat-desa', [PortalController::class, 'pegawai'])
    ->name('pegawai');
Route::get('/pengumuman', [PortalController::class, 'pengumuman'])
    ->name('pengumuman');


// ORGANISASI
Route::get('/struktur-organisasi', [PortalController::class, 'organisasi'])
    ->name('organisasi');
Route::get('/struktur-organisasi/detail/{id}', [PortalController::class, 'organisasiDetail'])
    ->name('organisasi.detail');
// ORGANISASI END

// Route::get('/statistik', [PortalController::class, 'statistik'])
//     ->name('statistik');

Route::get('/layanan', [PortalController::class, 'layanan'])
    ->name('layanan');

// PORTAL END

Route::middleware(['guest', 'prevent-back-history'])->group(function () {

    Route::get('/login-admin', [AuthController::class, 'showLoginAdmin'])
        ->name('login_admin');

    Route::post('/login-admin', [AuthController::class, 'login_admin'])
        ->name('login_admin.post');

    Route::get('/login-layanan-mandiri', [AuthController::class, 'showLoginUser'])
        ->name('login_user');

    Route::post('/login-layanan-mandiri', [AuthController::class, 'login_user'])
        ->name('login_user.post');

    Route::get('/register', fn () => view('auth.register'))
        ->name('register');

    Route::post('/register', [AuthController::class, 'register'])
        ->name('register.post');
});

Route::get('/auth/google', [AuthController::class, 'google_redirect'])->name('google_redirect');
Route::get('/auth/google/callback', [AuthController::class, 'google_callback'])->name('google_callback');

Route::post('/sns/webhook', [SnsWebhookController::class, 'handle'])
    ->name('sns.webhook');
    

// Lupa Password
Route::get('/lupa-password', [VerifikasiController::class, 'lupaPassword'])->name('lupa_password');
Route::post('/lupa-password', [VerifikasiController::class, 'kirimOtpLupaPassword'])->name('lupa_password.kirim');
Route::get('/lupa-password/otp/{unique_id}', [VerifikasiController::class, 'showOtpLupaPassword'])->name('lupa_password.otp');
Route::put('/lupa-password/otp/{unique_id}', [VerifikasiController::class, 'verifyOtpLupaPassword'])->name('lupa_password.verify');
Route::get('/lupa-password/baru/{unique_id}', [VerifikasiController::class, 'showResetPassword'])->name('lupa_password.reset');
Route::post('/lupa-password/baru/{unique_id}', [VerifikasiController::class, 'resetPassword'])->name('lupa_password.simpan');

Route::group(['middleware' => ['auth', 'check_role:Warga']], function() {
    Route::get('/verify', [VerifikasiController::class, 'index'])->name('verifikasi.index');
    Route::post('/verify', [VerifikasiController::class, 'store'])->name('verifikasi.index');
    Route::get('/verify/{unique_id}', [VerifikasiController::class, 'show'])->name('verifikasi.show');
    Route::put('/verify/{unique_id}', [VerifikasiController::class, 'update'])->name('verifikasi.update');
});

Route::group(['middleware' => ['auth', 'check_role:Warga', 'check_status', 'prevent-back-history']], function () {
    Route::get('layanan-mandiri', [LayananMandiriController::class, 'index'])
        ->name('layanan_mandiri');

    Route::get('layanan-mandiri/profil', [LayananMandiriController::class, 'profil'])
        ->name('profil');
    Route::get('layanan-mandiri/edit-profil',[LayananMandiriController::class, 'editProfil'])
        ->name('layanan_mandiri.edit_profil');

    Route::post('layanan-mandiri/update-profil',[LayananMandiriController::class, 'updateProfil'])
        ->name('update_profil');


    Route::get('layanan-mandiri/edit-biodata', [LayananMandiriController::class, 'editData'])
        ->name('edit_data');

    Route::post('layanan-mandiri/edit-biodata', [LayananMandiriController::class, 'updateData'])
        ->name('edit_data.update');
    Route::get('layanan-mandiri/reset-password', [LayananMandiriController::class, 'resetForm'])
    ->name('reset_password');
    Route::post('layanan-mandiri/reset-password', [LayananMandiriController::class, 'resetProses'])
    ->name('reset_password.proses');
     Route::post('/layanan-mandiri/cari-nik', [LayananMandiriController::class, 'cariNik'])
        ->name('cari.nik');
     Route::get('/layanan-mandiri/daftar-layanan', [LayananMandiriController::class, 'daftarLayanan'])
        ->name('layanan_mandiri.layanan');
     Route::get('/layanan-mandiri/pengajuan-surat/{id}', [LayananMandiriController::class, 'create'])
        ->name('layanan_mandiri.pengajuan.create');
    Route::post('/layanan-mandiri/pengajuan-surat', [LayananMandiriController::class, 'store'])
        ->name('layanan_mandiri.store');
    Route::get('/layanan-mandiri/preview-surat/{id}', [LayananMandiriController::class, 'previewSurat'])
        ->name('layanan_mandiri.preview_surat');
    Route::get('/layanan-mandiri/download-surat/{id}', [LayananMandiriController::class, 'downloadSurat'])
    ->name('layanan_mandiri.download_surat');
    // Route::get('/layanan-mandiri/riwayat/{id}', [LayananMandiriController::class, 'riwayatShow'])
    //     ->name('layanan_mandiri.riwayat.show');
});

Route::group(['middleware' => ['auth', 'check_role:Admin,Petugas', 'prevent-back-history']], function(){

    Route::get('/dashboard', [DashboardController::class,'index'])->name('dashboard');

   
    // BERITA
    
    Route::prefix('dashboard/berita')->group(function(){
        Route::get('/', [BeritaController::class, 'index'])->name('berita.index');
        Route::get('/create', [BeritaController::class, 'create'])->name('berita.create');
        Route::post('/', [BeritaController::class, 'store'])->name('berita.store');
        Route::get('/{id}/edit', [BeritaController::class, 'edit'])->name('berita.edit');
        Route::put('/{id}', [BeritaController::class, 'update'])->name('berita.update');
        Route::delete('/{id}', [BeritaController::class, 'destroy'])->name('berita.destroy');
    });

    // AGENDA

    Route::prefix('dashboard/agenda')->group(function(){
        Route::get('/', [AgendaController::class, 'index'])->name('agenda.index');
        Route::get('/create', [AgendaController::class, 'create'])->name('agenda.create');
        Route::post('/', [AgendaController::class, 'store'])->name('agenda.store');
    });

    // DATA PENDUDUK
    Route::prefix('dashboard/data-penduduk')->group(function(){
        Route::get('/', [PendudukController::class, 'index'])->name('penduduk.index');
        Route::get('/upload', [PendudukController::class, 'create'])->name('penduduk.create');
        Route::post('/', [PendudukController::class, 'store'])->name('penduduk.store');
        Route::get('/{id}/edit', [PendudukController::class, 'edit'])->name('penduduk.edit');
        Route::post('/{id}', [PendudukController::class, 'update'])->name('penduduk.update');
        Route::delete('/{id}', [PendudukController::class, 'destroy'])->name('penduduk.destroy');
    });

    // STATISTIK
    Route::prefix('dashboard/statistik')->group(function(){
        Route::get('/',[StatistikController::class,'index'])->name('statistik.index');
        Route::get('/{id}/edit',[StatistikController::class,'edit'])->name('statistik.edit');
        Route::post('/{id}',[StatistikController::class,'update'])->name('statistik.update');
        Route::delete('/{id}',[StatistikController::class,'destroy'])->name('statistik.destroy');
    });
   
    // PENGUMUMAN
    Route::prefix('/dashboard/pengumuman')->group(function(){
        Route::get('/', [PengumumanController::class, 'index'])->name('pengumuman.index');
        Route::get('/upload', [PengumumanController::class, 'create'])->name('pengumuman.create');
        Route::post('/', [PengumumanController::class, 'store'])->name('pengumuman.store');
        Route::get('/{id}/edit', [PengumumanController::class, 'edit'])->name('pengumuman.edit');
        Route::post('/{id}', [PengumumanController::class, 'update'])->name('pengumuman.update');
    });

    // LAYANAN SURAT
    
    Route::prefix('dashboard/layanan')->group(function(){
        Route::get('/', [LayananSuratController::class, 'index'])->name('layanan.index');
        Route::get('/create', [LayananSuratController::class, 'create'])->name('layanan.create');
        Route::post('/', [LayananSuratController::class, 'store'])->name('layanan.store');
        Route::get('/{layanan}/edit', [LayananSuratController::class, 'edit'])->name('layanan.edit');
        Route::post('/{layanan}', [LayananSuratController::class, 'update'])->name('layanan.update');
        Route::delete('/{id}', [LayananSuratController::class, 'destroy'])->name('layanan.destroy');
        Route::get('/{layanan}/preview', [LayananSuratController::class, 'preview'])->name('layanan.preview');
    });

    // DETAIL LAYANAN
    Route::prefix('dashboard/detail-layanan')->group(function () {
    Route::get('/{layanan}', [DetailLayananController::class, 'index'])
        ->name('detail-layanan.index');

    Route::post('/store', [DetailLayananController::class, 'store'])
        ->name('detail-layanan.store');

    Route::post('/{id}', [DetailLayananController::class, 'update'])
        ->name('detail-layanan.update');

    Route::delete('/{id}', [DetailLayananController::class, 'destroy'])
        ->name('detail-layanan.destroy');
});
    
    // PERSYARATAN
    
    Route::get('/dashboard/layanan/{layanan}/persyaratan',
        [PersyaratanController::class, 'index'])
        ->name('persyaratan.index');

    Route::post('/dashboard/layanan/{layanan}/persyaratan',
        [PersyaratanController::class, 'store'])
        ->name('persyaratan.store');
    
    Route::post('/dashboard/persyaratan/{id}', [PersyaratanController::class, 'update'])
    ->name('persyaratan.update');

    Route::delete('/dashboard/persyaratan/{id}',
        [PersyaratanController::class, 'destroy'])
        ->name('persyaratan.destroy');

    
    
    // PENGAJUAN ADMIN
    
    Route::prefix('dashboard/pengajuan')->group(function(){

        Route::get('/', [PengajuanController::class, 'adminIndex'])
            ->name('pengajuan.index');

        Route::get('/create', [PengajuanController::class, 'adminCreate'])
            ->name('pengajuan.create');

        Route::post('/', [PengajuanController::class, 'adminStore'])
            ->name('pengajuan.store');

        Route::get('/{id}', [PengajuanController::class, 'show'])
            ->name('pengajuan.detail');

        Route::put('/{id}/approve', [PengajuanController::class, 'approve'])
            ->name('pengajuan.approve');
        Route::put('/{id}/reject', [PengajuanController::class, 'reject'])
            ->name('pengajuan.reject');

        Route::get('/layanan-mandiri/surat/{id}/download', [PengajuanController::class, 'downloadSurat'])
            ->name('layanan_mandiri.download_surat');

        Route::delete('/{id}', [PengajuanController::class, 'destroy'])
            ->name('pengajuan.destroy');
        
        Route::post('/cari-nik', [PengajuanController::class, 'adminCariNik'])
        ->name('pengajuan.cari_nik');
        Route::get('/layanan/{layanan}/detail-layanan', [PengajuanController::class, 'adminDetailLayanan'])
        ->name('pengajuan.detail_layanan');
    });

    // PENGADUAN - ADMIN

Route::prefix('dashboard')->group(function () {
    Route::get('/pengaduan', [PengaduanController::class, 'index'])->name('admin.pengaduan.index');
    
    Route::post('/pengaduan/{id}/balas', [PengaduanController::class, 'balas'])->name('pengaduan.balas');
    Route::post('/pengaduan/{id}/status', [PengaduanController::class, 'updateStatus'])->name('pengaduan.status');
    Route::delete('/pengaduan/{id}', [PengaduanController::class, 'destroy'])->name('pengaduan.destroy');
});

    // GALERI
    Route::prefix('dashboard/galeri')->group(function(){
        Route::get('/', [GaleriController::class, 'index'])->name('galeri.index');
        Route::get('/create', [GaleriController::class, 'create'])->name('galeri.create');
        Route::post('/', [GaleriController::class, 'store'])->name('galeri.store');
        Route::get('/{id}/edit', [GaleriController::class, 'edit'])->name('galeri.edit');
        Route::put('/{id}', [GaleriController::class, 'update'])->name('galeri.update');
        Route::delete('/{id}', [GaleriController::class, 'destroy'])->name('galeri.destroy');
        Route::patch('/{id}/toggle-status', [GaleriController::class, 'toggleStatus'])->name('galeri.toggle-status');
    });
 

});

Route::group(['middleware' => ['auth', 'check_role:Admin', 'prevent-back-history']], function(){
    // TABEL USER
    Route::get('/dashboard/users', [UsersController::class,'users'])->name('users.users');
    Route::get('/users/create', [UsersController::class,'create'])->name('users.create');
    Route::post('/users/store', [UsersController::class,'store'])->name('users.store');
    Route::get('/users/edit/{id}', [UsersController::class,'edit'])->name('users.edit');
    Route::post('/users/update/{id}', [UsersController::class,'update'])->name('users.update');
    Route::delete('/users/destroy/{id}', [UsersController::class,'destroy'])->name('users.destroy');
    // TABEL USER END

    // VISI MISI
    Route::get('/admin/visi-misi', [VisiMisiController::class, 'index'])->name('visimisi.index');
    Route::post('/admin/visi-misi', [VisiMisiController::class, 'update'])->name('visimisi.update');
    // VISI MISI END

    // SEJARAH DESA
    Route::get('/admin/sejarah-desa', [SejarahDesaController::class, 'index'])->name('sejarah.index');
    Route::post('/admin/sejarah-desa/update', [SejarahDesaController::class, 'update'])->name('sejarah.update');
    // SEJARAH DESA END

    // PERANGKAT DESA
    Route::get('/dashboard/pegawai', [PerangkatDesaController::class, 'index'])->name('pegawai.index');
    Route::get('/pegawai/upload', [PerangkatDesaController::class,'create'])->name('pegawai.create');
    Route::post('/pegawai/store', [PerangkatDesaController::class, 'store'])->name('pegawai.store');
    Route::get('/pegawai/edit/{id}', [PerangkatDesaController::class, 'edit'])->name('pegawai.edit');
    Route::post('/pegawai/update/{id}', [PerangkatDesaController::class, 'update'])->name('pegawai.update');
    Route::delete('/pegawai/delete/{id}', [PerangkatDesaController::class, 'destroy'])->name('pegawai.destroy');
    // PERANGKAT DESA END

    // Profil Desa
    Route::get('/dashboard/profil-desa', [ProfilDesaController::class, 'index'])->name('profil_desa');
    Route::get('/dashboard/profil-desa/create', [ProfilDesaController::class, 'create'])->name('profil_desa.create');
    Route::post('/dashboard/profil-desa/store', [ProfilDesaController::class, 'store'])->name('profil_desa.store');
    Route::get('/profil-desa/edit/{id}', [ProfilDesaController::class, 'edit'])->name('profil_desa.edit');
    Route::post('/profil-desa/update/{id}', [ProfilDesaController::class, 'update'])->name('profil_desa.update');
    // Profil Desa END
});


// PENGADUAN - PUBLIC (PORTAL)

Route::get('/pengaduan', [PengaduanController::class, 'create'])->name('pengaduan.create');
Route::post('/pengaduan', [PengaduanController::class, 'store'])->name('pengaduan.store');


// PENGADUAN - LAYANAN MANDIRI (AUTH)

Route::middleware(['auth'])->group(function () {
    Route::get('/layanan-mandiri/pengaduan', [PengaduanController::class, 'create'])->name('layanan_mandiri.pengaduan');
});





// Grup route notifikasi (lindungi dengan middleware auth jika perlu)
Route::prefix('notifikasi')->middleware(['auth'])->group(function () {
 
    // Kirim pengumuman ke semua warga (hanya admin desa)
    Route::post('/pengumuman', [NotifikasiController::class, 'kirimPengumuman'])
        ->middleware('role:Admin'); // sesuaikan dengan middleware role kamu
 
    // Notifikasi status surat ke pemohon
    Route::post('/surat', [NotifikasiController::class, 'notifikasiSurat'])
        ->middleware('role:Admin');
 
    // Warga daftarkan email untuk terima pengumuman
    Route::post('/subscribe', [NotifikasiController::class, 'subscribeEmail']);
});
 

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');










