<?php

namespace SergiX44\Nutgram\Tests\Fixtures;

use SergiX44\Nutgram\Handlers\Type\Command;
use SergiX44\Nutgram\Nutgram;

class InvalidCommand extends Command
{
    protected string $command = 'test';

    public function missing(Nutgram $bot): void
    {
        expect($bot->get('called'))->toBeFalse();
        $bot->set('called', true);
    }
}
