<?php

use Diagonal\LaravelDocsManager\Http\Controllers\DocsController;
use Illuminate\Support\Facades\Route;

Route::middleware(config('docs-manager.middleware', ['web']))
    ->prefix(config('docs-manager.route_prefix', 'docs'))
    ->name('docs-manager.')
    ->group(function () {
        Route::get('/', [DocsController::class, 'index'])->name('index');
    });
