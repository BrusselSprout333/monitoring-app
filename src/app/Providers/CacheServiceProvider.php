<?php

namespace App\Providers;

use App\Cache\Cache;
use Illuminate\Support\ServiceProvider;
use Psr\SimpleCache\CacheInterface;

class CacheServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(CacheInterface::class, function () {
            return new Cache(dirname(__DIR__) . '/Cache/data');
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
