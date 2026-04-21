<?php

namespace App\Providers;

use App\Models\Berita;
use App\Models\Visitor;
use Carbon\Carbon;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Carbon::setLocale('id');

        //Hitung visitor dan bagikan ke SEMUA halaman
        $visitorHariIni = Visitor::whereDate('tanggal', today())->count();
        $visitorTotal   = Visitor::distinct('ip_address')->count();

        View::share('visitorHariIni', $visitorHariIni);
        View::share('visitorTotal', $visitorTotal);

        View::composer('partials.berita.sidebar', function ($view) {
        $beritaTerbaru = Berita::orderBy('created_at', 'desc')
                                ->take(3)
                                ->get();

        $view->with('beritaTerbaru', $beritaTerbaru);
    });
    }
}
