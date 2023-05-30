<?php


namespace SergiX44\Nutgram\Proxies;

/**
 * Trait UpdateDataProxy
 * @package SergiX44\Nutgram\Proxies
 */
trait UpdateDataProxy
{
    private array $store = [];

    /**
     * @param  array-key  $key
     * @param  mixed  $default
     * @return mixed
     */
    public function get(int|string $key, mixed $default = null): mixed
    {
        return $this->store[$key] ?? $default;
    }

    /**
     * @param  array-key  $key
     * @param mixed $value
     * @return mixed
     */
    public function set(int|string $key, mixed $value): mixed
    {
        return $this->store[$key] = $value;
    }

    /**
     * @param  array-key  $key
     */
    public function delete(int|string $key): void
    {
        unset($this->store[$key]);
    }

    public function clear(): void
    {
        $this->store = [];
    }
}
