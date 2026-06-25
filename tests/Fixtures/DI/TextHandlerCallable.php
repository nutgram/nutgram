<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Tests\Fixtures\DI;

use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Tests\Fixtures\CustomService;
use SergiX44\Nutgram\Tests\Fixtures\MyService;

class TextHandlerCallable
{
    public function __invoke(Nutgram $bot, CustomService $service1, MyService $service2): void
    {
        expect($service1)->toBeInstanceOf(CustomService::class);
        expect($service2)->toBeInstanceOf(MyService::class);
    }
}
