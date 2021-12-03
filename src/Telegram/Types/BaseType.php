<?php

namespace SergiX44\Nutgram\Telegram\Types;

use SergiX44\Nutgram\Nutgram;

abstract class BaseType
{
    protected ?Nutgram $bot;

    public function __construct(Nutgram $bot)
    {
        $this->bot = $bot;
    }
}
