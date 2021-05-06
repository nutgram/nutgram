<?php


namespace SergiX44\Nutgram\Proxies;

use Psr\SimpleCache\InvalidArgumentException;
use SergiX44\Nutgram\Nutgram;

/**
 * Trait GlobalCacheProxy
 * @package SergiX44\Nutgram\Proxies
 * @mixin Nutgram
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
     * @return bool
     * @throws InvalidArgumentException
     */
    public function setGlobalData($key, $value): bool
    {
        return $this->globalCache->set($key, $value);
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
