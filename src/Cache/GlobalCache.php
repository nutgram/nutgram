<?php


namespace SergiX44\Nutgram\Cache;


use Psr\SimpleCache\CacheInterface;

class GlobalCache extends BotCache
{
    protected const GLOBAL_TTL = null;

    protected const GLOBAL_PREFIX = 'GLOBAL';

    public function __construct(CacheInterface $cache, ?int $ttl = self::GLOBAL_TTL)
    {
        parent::__construct($cache, self::GLOBAL_PREFIX, $ttl);
    }

    /**
     * @param $key
     * @return mixed
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function get($key)
    {
        return $this->cache->get($this->makeKey($key));
    }

    /**
     * @param $key
     * @param $data
     * @return bool
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function set($key, $data): bool
    {
        return $this->cache->set($this->makeKey($key), $data, $this->ttl);
    }

    /**
     * @param $key
     * @return bool
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function delete($key): bool
    {
        return $this->cache->delete($this->makeKey($key));
    }

}