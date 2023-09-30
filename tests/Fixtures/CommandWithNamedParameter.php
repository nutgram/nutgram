<?php

namespace SergiX44\Nutgram\Tests\Fixtures;

use SergiX44\Nutgram\Handlers\Type\Command;
use SergiX44\Nutgram\Nutgram;

class CommandWithNamedParameter extends Command
{
    protected string $command = 'start {value}';

    protected array $constraints = ['value' => '[a-z]+'];

    protected ?string $description = 'A lovely description';

    public function handle(Nutgram $bot, string $value): void
    {
        $bot->set('called', true);
    }
}
