<?php

namespace App\Providers;

use App\Services\ChirpBatchService;
use Illuminate\Support\ServiceProvider;

class ChirpServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {

        $this->app->singleton(ChirpBatchService::class, function ($app) {
            return new ChirpBatchService();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
