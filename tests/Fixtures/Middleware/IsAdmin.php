<?php

namespace SergiX44\Nutgram\Tests\Fixtures\Middleware;

use SergiX44\Nutgram\Middleware\Link;
use SergiX44\Nutgram\Nutgram;

final readonly class IsAdmin
{
    public function __invoke(Nutgram $bot, Link $next): void
    {
        if($bot->userId() !== 1111) {
            return;
        }

        $next($bot);
    }
}
