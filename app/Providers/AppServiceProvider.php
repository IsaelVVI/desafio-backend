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
        $this->app->singleton(Client::class, function ($app) {
            $apiKey = env('BUNNYCDN_API_KEY');
            $zone = env('BUNNYCDN_STORAGE_ZONE');
            $storageZone = "https://$zone";
            $region = Region::SAO_PAULO;

            $guzzleClient = new GuzzleHttpClient([
                'verify' => false, // Desativa a verificação do certificado SSL
            ]);

            return new Client($apiKey, $storageZone, $region, $guzzleClient);
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
