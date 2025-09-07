<?php

namespace Diagonal\LaravelDocsManager\Commands;

use Illuminate\Console\Command;

class LaravelDocsManagerCommand extends Command
{
    public $signature = 'laravel-docs-manager';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
