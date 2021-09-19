<?php

namespace SergiX44\Nutgram\Laravel\Commands;

use Illuminate\Console\Command;
use SergiX44\Nutgram\Nutgram;

class RunCommand extends Command
{
    protected $signature = 'nutgram:run';

    protected $description = 'Start the bot in long polling mode';

    public function handle(): void
    {
        app(Nutgram::class)->run();
    }
}
