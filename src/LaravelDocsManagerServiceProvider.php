<?php

namespace Diagonal\LaravelDocsManager;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class LaravelDocsManagerServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('laravel-docs-manager')
            ->hasConfigFile('docs-manager')
            ->hasRoutes('web');
    }

    public function packageBooted(): void
    {
        if (config('docs-manager.enabled', true)) {
            // Register views
            $this->loadViewsFrom($this->package->basePath('/../resources/views'), 'laravel-docs-manager');
        }
    }

    public function packageRegistered(): void
    {
        $this->app->singleton(LaravelDocsManager::class, function () {
            return new LaravelDocsManager;
        });
    }
}
