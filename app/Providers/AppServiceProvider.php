<?php

namespace App\Providers;

use Bunny\Storage\Client;
use Bunny\Storage\Region;
use GuzzleHttp\Client as GuzzleHttpClient;
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
    }
}
