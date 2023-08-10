<?php

namespace Inmanturbo\PathRouter\Commands;

use Illuminate\Console\Command;

class PathRouterCommand extends Command
{
    public $signature = 'path-router';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
