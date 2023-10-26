<?php

namespace App\Providers;

use App\Interfaces\ApiServiceInterface;
use App\Services\ApiCacheProxy;
use App\Services\ApiErrorHandlingProxy;
use App\Services\ApiService;
use Illuminate\Support\ServiceProvider;

class ApiServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(ApiServiceInterface::class, function () {
            return new ApiErrorHandlingProxy(new ApiCacheProxy(new ApiService()));
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
