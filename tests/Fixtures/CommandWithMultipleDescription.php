<?php

namespace SergiX44\Nutgram\Tests\Fixtures;

use SergiX44\Nutgram\Handlers\Type\Command;
use SergiX44\Nutgram\Nutgram;

class CommandWithMultipleDescription extends Command
{
    protected string $command = 'start';

    protected ?string $description = 'Start the bot';

    protected array $localizedDescriptions = [
        'it' => 'Avvia il bot',
    ];

    public function handle(Nutgram $bot): void
    {
        $bot->set('called', true);
    }
}
