<?php

namespace Diagonal\LaravelDocsManager;

class LaravelDocsManager
{
    public function enabled(): bool
    {
        return config('docs-manager.enabled', app()->environment('local'));
    }

    public function routePrefix(): string
    {
        return config('docs-manager.route_prefix', 'docs');
    }

    public function middleware(): array
    {
        return config('docs-manager.middleware', ['web']);
    }
}
