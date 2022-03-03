<?php

namespace SergiX44\Nutgram\Telegram\Types;

use Illuminate\Support\Traits\Macroable;
use SergiX44\Nutgram\Nutgram;

abstract class BaseType
{
    use Macroable;

    protected ?Nutgram $bot;

    public function __construct(?Nutgram $bot = null)
    {
        $this->bot = $bot;
    }
}
