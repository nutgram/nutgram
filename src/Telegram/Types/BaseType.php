<?php

namespace SergiX44\Nutgram\Telegram\Types;

use Illuminate\Support\Traits\Macroable;
use SergiX44\Nutgram\Nutgram;

abstract class BaseType
{
    use Macroable {
        __call as macroCall;
    }

    protected ?Nutgram $bot;

    /**
     * @param  Nutgram|null  $bot
     */
    public function __construct(?Nutgram $bot = null)
    {
        $this->bot = $bot;
    }

    /**
     * @param  string  $method
     * @param  array  $parameters
     * @return mixed
     */
    public function __call(string $method, array $parameters)
    {
        if (method_exists($this->bot, $method)) {
            return $this->bot->$method(...$parameters);
        }

        return $this->macroCall($method, $parameters);
    }
}
