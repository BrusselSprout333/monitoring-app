<?php

namespace App\Providers;

use App\Interfaces\ApiServiceInterface;
use App\Services\ApiCacheProxy;
use App\Services\ApiErrorHandlingProxy;
use App\Services\ApiService;
use Illuminate\Support\ServiceProvider;
use Psr\Http\Client\ClientInterface;
use Psr\SimpleCache\CacheInterface;
use Psr\Log\LoggerInterface;

class ApiServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(ApiServiceInterface::class, function () {
            return new ApiErrorHandlingProxy(
                new ApiCacheProxy(
                    new ApiService($this->app->make(ClientInterface::class)),
                    $this->app->make(CacheInterface::class)
                ),
                $this->app->make(LoggerInterface::class)
            );
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
