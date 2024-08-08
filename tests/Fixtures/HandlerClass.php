<?php

namespace SergiX44\Nutgram\Tests\Fixtures;

use SergiX44\Nutgram\Nutgram;

class HandlerClass
{
    public function __invoke(Nutgram $bot): void
    {
        $bot->sendMessage('invoke');
    }
}
