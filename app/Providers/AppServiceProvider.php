<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
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
        Route::aliasMiddleware('last_seen', \App\Http\Middleware\UpdateLastSeen::class);
        Route::aliasMiddleware('admin', \App\Http\Middleware\AdminOnly::class);
    }
}
