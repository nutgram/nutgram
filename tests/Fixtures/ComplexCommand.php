<?php

namespace SergiX44\Nutgram\Tests\Fixtures;

use SergiX44\Nutgram\Handlers\Type\Command;
use SergiX44\Nutgram\Nutgram;

class ComplexCommand extends Command
{
    protected string $command = 'start {value}';

    protected ?string $description = 'A lovely description';

    public function handle(Nutgram $bot, string $value): void
    {
        expect($bot->get('called'))->toBeFalse();
        $bot->set('called', true);
        expect($value)->toBe('test');
    }
}
