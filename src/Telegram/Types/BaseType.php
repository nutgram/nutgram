<?php

namespace SergiX44\Nutgram\Telegram\Types;

use Illuminate\Support\Traits\Macroable;
use SergiX44\Nutgram\Nutgram;

abstract class BaseType
{
    use Macroable {
        __call as callMacro;
    }

    /** @internal */
    private ?Nutgram $_bot;

    /**
     * @param  Nutgram|null  $bot
     */
    public function __construct(?Nutgram $bot = null)
    {
        $this->_bot = $bot;
    }

    /**
     * @param  string  $method
     * @param  array  $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        if (method_exists($this->_bot, $method)) {
            return $this->_bot->$method(...$parameters);
        }

        return $this->callMacro($method, $parameters);
    }

    /**
     * @param  Nutgram|null  $bot
     * @return BaseType
     */
    public function bindToInstance(?Nutgram $bot): self
    {
        $this->_bot = $bot;
        return $this;
    }

    public function getBot(): ?Nutgram
    {
        return $this->_bot;
    }
}
