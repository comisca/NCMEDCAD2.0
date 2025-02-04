<?php

namespace App\Providers;

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
        //
        \Config::set('dompdf.options.isUnicode', true);
        \Config::set('dompdf.options.enable_php', true);
        \Config::set('dompdf.options.enable_remote', true);
        \Config::set('dompdf.options.enable_html5_parser', true);
    }
}
