<?php

namespace SergiX44\Nutgram\Proxies;

use DateInterval;
use Psr\SimpleCache\InvalidArgumentException;

/**
 * Trait GlobalCacheProxy.
 */
trait GlobalCacheProxy
{
    /**
     * @param      $key
     * @param null $default
     *
     * @throws InvalidArgumentException
     *
     * @return mixed
     */
    public function getGlobalData($key, $default = null): mixed
    {
        return $this->globalCache->get($key, $default);
    }

    /**
     * @param $key
     * @param $value
     * @param DateInterval|int|null $ttl
     *
     * @throws InvalidArgumentException
     *
     * @return bool
     */
    public function setGlobalData($key, $value, DateInterval|int|null $ttl = null): bool
    {
        return $this->globalCache->set($key, $value, $ttl);
    }

    /**
     * @param $key
     *
     * @throws InvalidArgumentException
     *
     * @return bool
     */
    public function deleteGlobalData($key): bool
    {
        return $this->globalCache->delete($key);
    }
}
