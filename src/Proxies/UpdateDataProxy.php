<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Proxies;

/**
 * Trait UpdateDataProxy
 * @package SergiX44\Nutgram\Proxies
 */
trait UpdateDataProxy
{
    private array $store = [];

    public function get(int|string $key, mixed $default = null): mixed
    {
        return $this->store[$key] ?? $default;
    }

    public function set(int|string $key, mixed $value): mixed
    {
        return $this->store[$key] = $value;
    }

    public function delete(int|string $key): void
    {
        unset($this->store[$key]);
    }

    public function clear(): void
    {
        $this->store = [];
    }
}
