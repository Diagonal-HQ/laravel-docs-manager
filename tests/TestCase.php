<?php

namespace Diagonal\LaravelDocsManager\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use Orchestra\Testbench\TestCase as Orchestra;
use Diagonal\LaravelDocsManager\LaravelDocsManagerServiceProvider;
use Inertia\ServiceProvider as InertiaServiceProvider;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'Diagonal\\LaravelDocsManager\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    protected function getPackageProviders($app)
    {
        return [
            InertiaServiceProvider::class,
            LaravelDocsManagerServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');
        config()->set('docs-manager.enabled', true);
        
        $app['config']->set('inertia.testing.ensure_pages_exist', false);
    }
}
