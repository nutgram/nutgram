<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Tests\Fixtures\DI;

use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Tests\Fixtures\CustomService;

class MiddlewareCallable
{
    public function __invoke(Nutgram $bot, $next, CustomService $service): void
    {
        expect($service)->toBeInstanceOf(CustomService::class);
        $next($bot);
    }
}
