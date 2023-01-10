<?php


namespace SergiX44\Nutgram\Cache\Adapters;

use DateInterval;
use Psr\SimpleCache\CacheInterface;
use SergiX44\Nutgram\Support\InteractsWithTime;

/**
 * Class ArrayCache
 * @package SergiX44\Nutgram\Cache
 */
class ArrayCache implements CacheInterface
{
    use InteractsWithTime;

    private array $cache = [];
    private array $expires = [];

    /**
     * @param  string  $key
     * @param  mixed  $default
     * @return mixed
     */
    public function get($key, $default = null): mixed
    {
        $this->checkExpire($key);

        return $this->cache[$key] ?? $default;
    }

    /**
     * @param  string  $key
     * @param  mixed  $value
     * @param  DateInterval|int|null  $ttl
     * @return bool
     */
    public function set($key, $value, $ttl = null): bool
    {
        $this->delete($key);

        $this->cache[$key] = $value;
        if ($ttl !== null) {
            $this->expires[$key] = $this->expiringAt($ttl);
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
     * @param  null  $default
     * @return array
     */
    public function getMultiple($keys, $default = null): array
    {
        $values = [];

        foreach ($keys as $key) {
            $values[$key] = $this->get($key, $default);
        }

        return $values;
    }

    /**
     * @param  iterable  $values
     * @param  DateInterval|int|null  $ttl
     * @return bool
     */
    public function setMultiple($values, $ttl = null): bool
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
        if ($expiration !== null && $this->hasExpired($expiration)) {
            unset($this->cache[$key], $this->expires[$key]);
        }
    }
}
