<?php

use Diagonal\LaravelDocsManager\Facades\LaravelDocsManager;

test('docs manager facade works', function () {
    expect(LaravelDocsManager::routePrefix())->toBe('docs');
    expect(LaravelDocsManager::middleware())->toBe(['web']);
});

test('docs manager route is accessible when enabled', function () {
    config(['docs-manager.enabled' => true]);

    $response = $this->get('/docs');

    $response->assertStatus(200);
});

test('docs manager route returns inertia response', function () {
    config(['docs-manager.enabled' => true]);

    $response = $this->get('/docs');

    $response->assertStatus(200)
        ->assertHeader('x-inertia', 'true');
});

test('route prefix can be configured', function () {
    config([
        'docs-manager.enabled' => true,
        'docs-manager.route_prefix' => 'documentation',
    ]);

    $response = $this->get('/documentation');

    $response->assertStatus(200);
});
