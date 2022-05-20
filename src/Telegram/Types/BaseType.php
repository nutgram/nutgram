<?php

namespace SergiX44\Nutgram\Telegram\Types;

use Illuminate\Support\Traits\Macroable;
use JsonSerializable;
use SergiX44\Nutgram\Nutgram;

abstract class BaseType implements JsonSerializable
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
    public function __call($method, $parameters)
    {
        if (method_exists($this->bot, $method)) {
            return $this->bot->$method(...$parameters);
        }

        return $this->macroCall($method, $parameters);
    }

    /**
     * @return array
     */
    public function __serialize(): array
    {
        $attributes = get_object_vars($this);
        unset($attributes['bot']);

        return $attributes;
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return $this->__serialize();
    }

    /**
     * @param  Nutgram|null  $bot
     * @return BaseType
     */
    public function bindToInstance(?Nutgram $bot): BaseType
    {
        $this->bot = $bot;
        return $this;
    }
}
