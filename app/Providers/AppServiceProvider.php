<?php

namespace App\Providers;

use Illuminate\Support\Facades\Vite;
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
        // Share asset URLs using secure_asset to ensure HTTPS links
        Inertia::share([
            'assets' => [
                'js' => secure_asset('js/app.js'),
                'css' => secure_asset('css/app.css'),
            ],
        ]);
        
        Vite::prefetch(concurrency: 3);
    }
}
