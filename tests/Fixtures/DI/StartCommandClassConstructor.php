<?php

namespace SergiX44\Nutgram\Tests\Fixtures\DI;

use SergiX44\Nutgram\Handlers\Type\Command;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Tests\Fixtures\CustomService;

class StartCommandClassConstructor extends Command
{
    protected string $command = 'start {value}';

    public function __construct(protected CustomService $service)
    {
    }

    public function handle(Nutgram $bot, string $value): void
    {
        expect($value)->toBe('foo');
        expect($this->service)->toBeInstanceOf(CustomService::class);
    }
}
