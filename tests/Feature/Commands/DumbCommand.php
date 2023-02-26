<?php

namespace SergiX44\Nutgram\Tests\Feature\Commands;

use SergiX44\Nutgram\Handlers\Type\Command;
use SergiX44\Nutgram\Nutgram;

class DumbCommand extends Command
{
    protected string $command = 'test';

    public function handle(Nutgram $bot): void
    {
        $bot->setGlobalData('flow', $bot->getGlobalData('flow', '').'H');
    }
}
