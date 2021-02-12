<?php


namespace SergiX44\Nutgram\Cache;

use Psr\SimpleCache\CacheInterface;

/**
 * Class ArrayCache
 * @package SergiX44\Nutgram\Cache
 */
class ArrayCache implements CacheInterface
{
    private array $data = [];
    private array $expires = [];

    /**
     * @param  string  $key
     * @param  null  $default
     * @return mixed|null
     */
    public function get($key, $default = null)
    {
        // delete key if it is already expired => below will detect this as a cache miss
        if (isset($this->expires[$key]) && $this->now() - $this->expires[$key] > 0) {
            unset($this->data[$key], $this->expires[$key]);
        }

        if (!array_key_exists($key, $this->data)) {
            return $default;
        }

        // remove and append to end of array to keep track of LRU info
        $value = $this->data[$key];
        unset($this->data[$key]);
        $this->data[$key] = $value;

        return $value;
    }

    /**
     * @param  string  $key
     * @param  mixed  $value
     * @param  null  $ttl
     * @return bool
     */
    public function set($key, $value, $ttl = null): bool
    {
        // unset before setting to ensure this entry will be added to end of array (LRU info)
        unset($this->data[$key]);
        $this->data[$key] = $value;

        // sort expiration times if TTL is given (first will expire first)
        unset($this->expires[$key]);
        if ($ttl !== null) {
            $this->expires[$key] = $this->now() + $ttl;
            asort($this->expires);
        }

        // first try to check if there's any expired entry
        // expiration times are sorted, so we can simply look at the first one
        reset($this->expires);
        $key = key($this->expires);

        // check to see if the first in the list of expiring keys is already expired
        // if the first key is not expired, we have to overwrite by using LRU info
        if ($key === null || $this->now() - $this->expires[$key] < 0) {
            reset($this->data);
            $key = key($this->data);
        }
        unset($this->data[$key], $this->expires[$key]);

        return true;
    }

    /**
     * @param  string  $key
     * @return bool
     */
    public function delete($key): bool
    {
        unset($this->data[$key], $this->expires[$key]);

        return true;
    }

    /**
     * @param  iterable  $keys
     * @param  null  $default
     * @return array
     * @throws \Psr\SimpleCache\InvalidArgumentException
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
     * @param  null  $ttl
     * @return bool
     * @throws \Psr\SimpleCache\InvalidArgumentException
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
            unset($this->data[$key], $this->expires[$key]);
        }

        return true;
    }

    /**
     * @return bool
     */
    public function clear(): bool
    {
        $this->data = [];
        $this->expires = [];

        return true;
    }

    /**
     * @param  string  $key
     * @return bool
     */
    public function has($key): bool
    {
        // delete key if it is already expired
        if (isset($this->expires[$key]) && $this->now() - $this->expires[$key] > 0) {
            unset($this->data[$key], $this->expires[$key]);
        }

        if (!array_key_exists($key, $this->data)) {
            return false;
        }

        // remove and append to end of array to keep track of LRU info
        $value = $this->data[$key];
        unset($this->data[$key]);
        $this->data[$key] = $value;

        return true;
    }

    /**
     * @return float
     */
    private function now(): float
    {
        return hrtime(true) * 1e-9;
    }
}
