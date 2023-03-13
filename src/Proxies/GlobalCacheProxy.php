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
     * @param  $key
     * @param  null  $default
     * @return mixed
     * @throws InvalidArgumentException
     */
    public function getGlobalData($key, $default = null): mixed
    {
        return $this->globalCache->get($key, $default);
    }

    /**
     * @param $key
     * @param $value
     * @param  DateInterval|int|null  $ttl
     * @return bool
     * @throws InvalidArgumentException
     */
    public function setGlobalData($key, $value, DateInterval|int|null $ttl = null): bool
    {
        return $this->globalCache->set($key, $value, $ttl);
    }

    /**
     * @param $key
     * @return bool
     * @throws InvalidArgumentException
     */
    public function deleteGlobalData($key): bool
    {
        return $this->globalCache->delete($key);
    }
}
