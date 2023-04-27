<?php

namespace SergiX44\Nutgram\Cache;

use DateInterval;
use Psr\SimpleCache\CacheInterface;
use Psr\SimpleCache\InvalidArgumentException;

class GlobalCache extends BotCache
{
    protected const GLOBAL_PREFIX = 'GLOBAL';

    /**
     * @param CacheInterface $cache
     * @param int|null       $botId
     */
    public function __construct(CacheInterface $cache, ?int $botId)
    {
        parent::__construct($cache, self::GLOBAL_PREFIX, $botId);
    }

    /**
     * @param string $key
     * @param mixed  $default
     *
     * @throws InvalidArgumentException
     *
     * @return mixed
     */
    public function get(string $key, mixed $default = null): mixed
    {
        return $this->cache->get($this->makeKey($key), $default);
    }

    /**
     * @param string                $key
     * @param mixed                 $data
     * @param DateInterval|int|null $ttl
     *
     * @throws InvalidArgumentException
     *
     * @return bool
     */
    public function set(string $key, mixed $data, DateInterval|int|null $ttl = null): bool
    {
        return $this->cache->set($this->makeKey($key), $data, $ttl);
    }

    /**
     * @param string $key
     *
     * @throws InvalidArgumentException
     *
     * @return bool
     */
    public function delete(string $key): bool
    {
        return $this->cache->delete($this->makeKey($key));
    }
}
