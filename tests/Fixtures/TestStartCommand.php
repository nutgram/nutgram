<?php

namespace SergiX44\Nutgram\Tests\Fixtures;

use SergiX44\Nutgram\Handlers\Type\Command;
use SergiX44\Nutgram\Nutgram;

class TestStartCommand extends Command
{
    protected string $command = 'start';

    protected ?string $description = 'A lovely description';

    public function handle(Nutgram $bot): void
    {
        expect($bot->getData('called'))->toBeFalse();
        $bot->setData('called', true);
    }
}
