<?php

namespace SergiX44\Nutgram\Tests\Feature\OOP;

use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Support\Command;

class TestCommand extends Command
{
    public static string $name = 'test';

    public static ?string $description = 'This is a test command';

    public static array $middlewares = [MiddlewareB::class];

    public static ?array $skipGlobalMiddlewares = [];

    public function __invoke(Nutgram $bot): void
    {
        $bot->setData('command called', true);
    }

    public function suchwow(Nutgram $bot): void
    {
        $bot->setData('such command called', true);
    }
}
