<?php

namespace SergiX44\Nutgram\Tests\Fixtures\Middleware;

use SergiX44\Nutgram\Middleware\Link;
use SergiX44\Nutgram\Nutgram;

final readonly class IsAdmin
{
    public function __invoke(Nutgram $bot, Link $next): void
    {
        if ($bot->userId() !== 1111) {
            $bot->sendMessage('You are not admin');
            return;
        }

        $next($bot);
    }

    public function moderator(Nutgram $bot, Link $next): void
    {
        if ($bot->userId() !== 2222) {
            $bot->sendMessage('You are not moderator');
            return;
        }

        $next($bot);
    }
}
