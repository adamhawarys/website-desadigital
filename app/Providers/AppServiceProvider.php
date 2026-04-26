<?php

namespace App\Providers;

use App\Models\Berita;
use App\Models\Visitor;
use Carbon\Carbon;
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

        try {
            $visitorHariIni = Visitor::whereDate('tanggal', today())->count();
            $visitorTotal   = Visitor::distinct()->count('ip_address');
            View::share('visitorHariIni', $visitorHariIni);
            View::share('visitorTotal', $visitorTotal);
        } catch (\Exception $e) {
            View::share('visitorHariIni', 0);
            View::share('visitorTotal', 0);
        }

        View::composer('partials.berita.sidebar', function ($view) {
            $beritaTerbaru = Berita::orderBy('created_at', 'desc')
                                    ->take(3)
                                    ->get();
            $view->with('beritaTerbaru', $beritaTerbaru);
        });
    }
}