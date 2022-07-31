<?php


namespace SergiX44\Nutgram\Cache;

use Psr\SimpleCache\CacheInterface;
use Psr\SimpleCache\InvalidArgumentException;

class GlobalCache extends BotCache
{
    protected const GLOBAL_TTL = null;

    protected const GLOBAL_PREFIX = 'GLOBAL';

    /**
     * @param  CacheInterface  $cache
     * @param $botId
     * @param  int|null  $ttl
     */
    public function __construct(CacheInterface $cache, $botId, ?int $ttl = self::GLOBAL_TTL)
    {
        parent::__construct($cache, self::GLOBAL_PREFIX, $botId, $ttl);
    }

    /**
     * @param $key
     * @param  $default
     * @return mixed
     * @throws InvalidArgumentException
     */
    public function get($key, $default = null): mixed
    {
        return $this->cache->get($this->makeKey($key), $default);
    }

    /**
     * @param $key
     * @param $data
     * @return bool
     * @throws InvalidArgumentException
     */
    public function set($key, $data): bool
    {
        return $this->cache->set($this->makeKey($key), $data, $this->ttl);
    }

    /**
     * @param $key
     * @return bool
     * @throws InvalidArgumentException
     */
    public function delete($key): bool
    {
        return $this->cache->delete($this->makeKey($key));
    }
}
