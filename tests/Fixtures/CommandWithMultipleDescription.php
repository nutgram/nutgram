<?php

namespace SergiX44\Nutgram\Tests\Fixtures;

use SergiX44\Nutgram\Handlers\Type\Command;
use SergiX44\Nutgram\Nutgram;

class CommandWithMultipleDescription extends Command
{
    protected string $command = 'start';

    protected array|string|null $description = [
        'it' => 'Avvia il bot',
        '*' => 'Start the bot',
    ];

    public function handle(Nutgram $bot): void
    {
        $bot->set('called', true);
    }
}
