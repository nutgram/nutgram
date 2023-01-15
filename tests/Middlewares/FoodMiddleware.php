<?php

namespace SergiX44\Nutgram\Tests\Middlewares;

use SergiX44\Nutgram\Nutgram;

class FoodMiddleware
{
    public function __invoke(Nutgram $bot, $next, $type): void
    {
        $bot->setData('food', $type);
        $next($bot);
    }
}
