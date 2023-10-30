<?php

namespace App\Providers;

use App\Cache\Cache;
use App\Interfaces\ApiServiceInterface;
use App\Logger\Logger;
use App\Services\ApiCacheProxy;
use App\Services\ApiErrorHandlingProxy;
use App\Services\ApiService;
use Illuminate\Http\Client\Factory;
use Illuminate\Support\ServiceProvider;

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
                    new ApiService(new Factory()),
                    new Cache(dirname(__DIR__) . '/Cache/data')),
                new Logger(dirname(__DIR__) . '/Logger/file.log')
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
