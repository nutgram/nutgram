<?php

namespace SergiX44\Nutgram\Tests\Feature\OOP;

use SergiX44\Nutgram\Nutgram;

class MiddlewareB
{
    public function __invoke(Nutgram $bot, $next)
    {
        $bot->setData('middlewareB', true);
        $next($bot);
    }
}
