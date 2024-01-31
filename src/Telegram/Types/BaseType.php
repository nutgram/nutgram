<?php

namespace SergiX44\Nutgram\Telegram\Types;

use BackedEnum;
use Illuminate\Support\Traits\Macroable;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Types\Internal\Arrayable;
use function SergiX44\Nutgram\Support\array_filter_null;

/**
 * @template-implements Arrayable<string, mixed>
 */
abstract class BaseType implements Arrayable
{
    use Macroable {
        __call as callMacro;
    }

    /** @internal */
    private ?Nutgram $_bot;

    /** @internal */
    private array $_extra = [];

    /**
     * @param Nutgram|null $bot
     */
    public function __construct(?Nutgram $bot = null)
    {
        $this->_bot = $bot;
    }

    /**
     * @param string $method
     * @param array $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        if ($this->_bot instanceof Nutgram && method_exists($this->_bot, $method)) {
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
     * @param Nutgram|null $bot
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

    public function toArray(): array
    {
        $data = [...get_object_vars($this), ...$this->_extra];

        array_walk($data, static function (mixed &$value, string $key) {
            match (true) {
                str_starts_with($key, '_') => $value = null, // remove internal properties
                $value instanceof Arrayable => $value = $value->toArray(),
                $value instanceof BackedEnum => $value = $value->value,
                default => null,
            };
        });

        return array_filter_null($data);
    }
}
