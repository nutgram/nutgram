<?php

namespace SergiX44\Nutgram\Tests\Feature\OOP;

use SergiX44\Nutgram\Nutgram;

class MiddlewareA
{
    public function __invoke(Nutgram $bot, $next)
    {
        $bot->setData('middlewareA', true);
        $next($bot);
    }
}
