<?php

declare(strict_types=1);

namespace Tinigin\ETag;

use Illuminate\Support\ServiceProvider;

class ETagServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/etag.php' => config_path('etag.php'),
            ], 'etag-config');
        }
    }

    /**
     * Register the application services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/etag.php', 'etag');
        $this->app->singleton('laravel-etag', fn() => new ETag());
    }
}
