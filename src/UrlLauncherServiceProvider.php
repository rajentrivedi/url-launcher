<?php

namespace Rajen\UrlLauncher;

use Illuminate\Support\ServiceProvider;
use Rajen\UrlLauncher\Commands\CopyAssetsCommand;

class UrlLauncherServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/nativephp-mobile-url-launcher.php',
            'nativephp-mobile-url-launcher'
        );

        $this->app->singleton(UrlLauncher::class, function () {
            return new UrlLauncher();
        });

        // Alias to match Facade expected accessor
        $this->app->alias(UrlLauncher::class, 'nativephp-url-launcher');
    }

    public function boot(): void
    {
        // Register plugin hook commands
        if ($this->app->runningInConsole()) {
            $this->commands([
                CopyAssetsCommand::class,
            ]);

            $this->publishes([
                __DIR__ . '/../config/nativephp-mobile-url-launcher.php' => config_path('nativephp-mobile-url-launcher.php'),
            ], 'nativephp-url-launcher-config');
        }
    }
}