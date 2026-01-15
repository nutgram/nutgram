<?php

namespace SergiX44\Nutgram\Tests\Fixtures\Middleware;

use SergiX44\Nutgram\Middleware\Link;
use SergiX44\Nutgram\Nutgram;

final readonly class HasPermission
{
    public function __construct(protected string $permission)
    {
    }

    public function __invoke(Nutgram $bot, Link $next): void
    {
        if ($bot->message()->text !== $this->permission) {
            $bot->sendMessage('You have no permission');
            return;
        }

        $next($bot);
    }
}
