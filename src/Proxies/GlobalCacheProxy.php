<?php


namespace SergiX44\Nutgram\Proxies;

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
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function getGlobalData($key, $default = null): mixed
    {
        return $this->globalCache->get($key, $default);
    }

    /**
     * @param $key
     * @param $value
     * @return mixed
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function setGlobalData($key, $value)
    {
        return $this->globalCache->set($key, $value);
    }

    /**
     * @param $key
     * @return bool
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function deleteGlobalData($key)
    {
        return $this->globalCache->delete($key);
    }
}
