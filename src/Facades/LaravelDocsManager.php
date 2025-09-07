<?php

namespace Diagonal\LaravelDocsManager\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Diagonal\LaravelDocsManager\LaravelDocsManager
 */
class LaravelDocsManager extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Diagonal\LaravelDocsManager\LaravelDocsManager::class;
    }
}
