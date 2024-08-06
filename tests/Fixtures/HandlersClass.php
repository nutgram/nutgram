<?php

namespace SergiX44\Nutgram\Tests\Fixtures;

use SergiX44\Nutgram\Nutgram;

class HandlersClass
{
    public function __construct(public string $value = 'default')
    {
    }

    public function foo(Nutgram $bot): void
    {
        $bot->sendMessage('foo reply');
    }

    public function bar(Nutgram $bot): void
    {
        $bot->sendMessage('bar reply');
    }

    public function baz(Nutgram $bot): void
    {
        $bot->sendMessage('baz reply');
    }

    public function getValue(Nutgram $bot): void
    {
        $bot->sendMessage($this->value);
    }
}
