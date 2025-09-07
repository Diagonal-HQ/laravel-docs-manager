<?php

namespace Diagonal\LaravelDocsManager;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Diagonal\LaravelDocsManager\Commands\LaravelDocsManagerCommand;

class LaravelDocsManagerServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('laravel-docs-manager')
            ->hasConfigFile('docs-manager')
            ->hasViews('docs-manager')
            ->hasRoutes('web')
            ->hasCommand(LaravelDocsManagerCommand::class);
    }

    public function packageBooted(): void
    {
        if (config('docs-manager.enabled', true)) {
            $this->publishes([
                $this->package->basePath('/../resources/js') => resource_path('js/vendor/laravel-docs-manager'),
            ], "{$this->package->shortName()}-assets");
        }
    }

    public function packageRegistered(): void
    {
        $this->app->singleton(LaravelDocsManager::class, function () {
            return new LaravelDocsManager();
        });
    }
}
