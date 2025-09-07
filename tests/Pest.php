<?php

use Diagonal\LaravelDocsManager\Tests\TestCase;
use Inertia\Testing\AssertableInertia;

uses(TestCase::class)->in(__DIR__);

function assertInertia(callable $callback = null): AssertableInertia
{
    return AssertableInertia::fromTestResponse(response());
}
