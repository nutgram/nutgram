<?php

namespace SergiX44\Nutgram\Tests\Fixtures\DI;

use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Tests\Fixtures\CustomService;

class StartCommandCallable
{
    public function __invoke(Nutgram $bot, string $value, CustomService $service): void
    {
        expect($value)->toBe('foo');
        expect($service)->toBeInstanceOf(CustomService::class);
    }
}
