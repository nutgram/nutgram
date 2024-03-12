<?php

namespace SergiX44\Nutgram\Tests\Fixtures\DI;

use SergiX44\Nutgram\Handlers\Type\Command;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Tests\Fixtures\CustomService;

class StartCommandClass extends Command
{
    protected string $command = 'start {value}';

    public function handle(Nutgram $bot, string $value, CustomService $service): void
    {
        expect($value)->toBe('foo');
        expect($service)->toBeInstanceOf(CustomService::class);
    }
}
