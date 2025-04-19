<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;

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

    public function boot()
    {
        Paginator::useTailwind();
        Schema::defaultStringLength(191);
        Carbon::setLocale('id');
        \Illuminate\Support\Facades\Response::macro('secureJson', function ($value) {
            return response()->json($value)->header('Content-Security-Policy', "default-src 'self'; script-src 'self' https://cdn.jsdelivr.net");
        });
    }
}
