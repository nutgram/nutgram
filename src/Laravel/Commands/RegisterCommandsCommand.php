<?php

namespace SergiX44\Nutgram\Laravel\Commands;

use Illuminate\Console\Command;
use SergiX44\Nutgram\Nutgram;

class RegisterCommandsCommand extends Command
{
    protected $signature = 'nutgram:register-commands';

    protected $description = 'Register the bot commands';

    public function handle(): int
    {
        /** @var Nutgram $bot */
        $bot = app(Nutgram::class);

        $bot->registerMyCommands();

        $this->info('Bot commands set.');

        return 0;
    }
}
