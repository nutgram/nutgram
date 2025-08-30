<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Tests\Fixtures;

use SergiX44\Nutgram\Nutgram;

class HelloHandler
{
    public function hello(Nutgram $bot): void
    {
        $bot->sendMessage('hello');
    }
}
