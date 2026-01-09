<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Cache\Adapters;

use DateInterval;
use DateTimeImmutable;
use Psr\Clock\ClockInterface;
use Psr\SimpleCache\CacheInterface;
use SergiX44\Nutgram\Support\InteractsWithTime;
use SergiX44\Nutgram\Support\SystemClock;

/**
 * Class ArrayCache
 * @package SergiX44\Nutgram\Cache
 */
class ArrayCache implements CacheInterface
{
    use InteractsWithTime;

    /**
     * The cache values.
     * @var array<string, mixed>
     */
    private array $cache = [];

    /**
     * Expiration timestamps.
     * @var array<string, DateTimeImmutable>
     */
    private array $expires = [];

    public function __construct(protected ClockInterface $clock = new SystemClock())
    {
    }

    /**
     * @inheritDoc
     */
    public function get(string $key, mixed $default = null): mixed
    {
        $this->checkExpire($key);

        return $this->cache[$key] ?? $default;
    }

    /**
     * @inheritDoc
     */
    public function set(string $key, mixed $value, DateInterval|int|null $ttl = null): bool
    {
        $this->delete($key);

        $this->cache[$key] = $value;
        if ($ttl !== null) {
            $this->expires[$key] = $this->expiringAt($ttl);
        }

        return true;
    }

    /**
     * @inheritDoc
     */
    public function delete(string $key): bool
    {
        unset($this->cache[$key], $this->expires[$key]);

        return true;
    }

    /**
     * @inheritDoc
     */
    public function clear(): bool
    {
        $this->cache = [];
        $this->expires = [];

        return true;
    }

    /**
     * @inheritDoc
     */
    public function getMultiple(iterable $keys, mixed $default = null): iterable
    {
        $values = [];

        foreach ($keys as $key) {
            $values[$key] = $this->get($key, $default);
        }

        return $values;
    }

    /**
     * @inheritDoc
     */
    public function setMultiple(iterable $values, DateInterval|int|null $ttl = null): bool
    {
        foreach ($values as $key => $value) {
            $this->set($key, $value, $ttl);
        }

        return true;
    }

    /**
     * @inheritDoc
     */
    public function deleteMultiple(iterable $keys): bool
    {
        foreach ($keys as $key) {
            unset($this->cache[$key], $this->expires[$key]);
        }

        return true;
    }

    /**
     * @inheritDoc
     */
    public function has(string $key): bool
    {
        $this->checkExpire($key);

        return array_key_exists($key, $this->cache);
    }

    private function checkExpire(string $key): void
    {
        $expiration = $this->expires[$key] ?? null;
        if ($expiration !== null && $this->hasExpired($expiration)) {
            unset($this->cache[$key], $this->expires[$key]);
        }
    }
}
