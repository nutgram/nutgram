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

    /** @internal */
    private array $_extra = [];

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
     * @param string $name
     * @param mixed $value
     * @return void
     */
    public function __set(string $name, mixed $value): void
    {
        $this->_extra[$name] = $value;
    }

    /**
     * @param string $name
     * @return mixed
     */
    public function __get(string $name): mixed
    {
        return $this->_extra[$name] ?? null;
    }

    /**
     * @param string $name
     * @return bool
     */
    public function __isset(string $name): bool
    {
        return isset($this->_extra[$name]);
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
