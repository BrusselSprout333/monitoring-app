<?php

namespace App\Providers;

use App\Logger\Logger;
use Illuminate\Support\ServiceProvider;
use Psr\Log\LoggerInterface;

class LoggerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(LoggerInterface::class, function () {
            return new Logger(dirname(__DIR__) . '/Logger/file.log');
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
