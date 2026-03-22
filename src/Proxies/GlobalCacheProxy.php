<?php


namespace SergiX44\Nutgram\Proxies;

use DateInterval;
use Psr\SimpleCache\InvalidArgumentException;

/**
 * Trait GlobalCacheProxy
 * @package SergiX44\Nutgram\Proxies
 */
trait GlobalCacheProxy
{
    /**
     * @param string $key
     * @param mixed $default
     * @return mixed
     * @throws InvalidArgumentException
     */
    public function getGlobalData($key, $default = null): mixed
    {
        return $this->globalCache->get($key, $default);
    }

    /**
     * @param string $key
     * @param mixed $value
     * @param DateInterval|int|null $ttl
     * @return bool
     * @throws InvalidArgumentException
     */
    public function setGlobalData($key, $value, DateInterval|int|null $ttl = null): bool
    {
        return $this->globalCache->set($key, $value, $ttl);
    }

    /**
     * @param string $key
     * @return bool
     * @throws InvalidArgumentException
     */
    public function deleteGlobalData($key): bool
    {
        return $this->globalCache->delete($key);
    }
}
