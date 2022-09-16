<?php


namespace SergiX44\Nutgram\Cache\Adapters;

use DateInterval;
use Psr\SimpleCache\CacheInterface;

/**
 * Class ArrayCache
 * @package SergiX44\Nutgram\Cache
 */
class ArrayCache implements CacheInterface
{
    private array $cache = [];
    private array $expires = [];

    /**
     * @param  string  $key
     * @param  mixed  $default
     * @return mixed
     */
    public function get(string $key, mixed $default = null): mixed
    {
        $this->checkExpire($key);

        return $this->cache[$key] ?? $default;
    }

    /**
     * @param  string  $key
     * @param  mixed  $value
     * @param  int|DateInterval|null  $ttl
     * @return bool
     */
    public function set(string $key, mixed $value, null|int|DateInterval $ttl = null): bool
    {
        $this->delete($key);

        $this->cache[$key] = $value;
        if ($ttl !== null) {
            $this->expires[$key] = time() + $ttl;
        }

        return true;
    }

    /**
     * @param  string  $key
     * @return bool
     */
    public function delete($key): bool
    {
        unset($this->cache[$key], $this->expires[$key]);

        return true;
    }

    /**
     * @return bool
     */
    public function clear(): bool
    {
        $this->cache = [];
        $this->expires = [];

        return true;
    }

    /**
     * @param  iterable  $keys
     * @param  mixed  $default
     * @return iterable<string, mixed>
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
     * @param  iterable  $values
     * @param  null|int|DateInterval  $ttl
     * @return bool
     */
    public function setMultiple(iterable $values, null|int|DateInterval $ttl = null): bool
    {
        foreach ($values as $key => $value) {
            $this->set($key, $value, $ttl);
        }

        return true;
    }

    /**
     * @param  iterable  $keys
     * @return bool
     */
    public function deleteMultiple($keys): bool
    {
        foreach ($keys as $key) {
            unset($this->cache[$key], $this->expires[$key]);
        }

        return true;
    }

    /**
     * @param  string  $key
     * @return bool
     */
    public function has($key): bool
    {
        $this->checkExpire($key);

        return array_key_exists($key, $this->cache);
    }

    /**
     * @param $key
     */
    private function checkExpire(string $key): void
    {
        $expiration = $this->expires[$key] ?? null;
        if ($expiration !== null && $expiration < time()) {
            unset($this->cache[$key], $this->expires[$key]);
        }
    }
}
