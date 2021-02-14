<?php


namespace SergiX44\Nutgram\Cache;


use Psr\SimpleCache\CacheInterface;

class UserCache extends BotCache
{
    protected const USERDATA_TTL = null;

    protected const USERDATA_PREFIX = 'USER';

    public function __construct(CacheInterface $cache, ?int $ttl = self::USERDATA_TTL)
    {
        parent::__construct($cache, self::USERDATA_PREFIX, $ttl);
    }

    /**
     * @param $userId
     * @param $key
     * @param  null  $default
     * @return mixed
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function get($userId, $key, $default = null)
    {
        return $this->cache->get($this->makeKey($userId, $key), $default);
    }

    /**
     * @param $userId
     * @param $key
     * @param $data
     * @return bool
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function set($userId, $key, $data): bool
    {
        return $this->cache->set($this->makeKey($userId, $key), $data, $this->ttl);
    }

    /**
     * @param $userId
     * @param $key
     * @return bool
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function delete($userId, $key): bool
    {
        return $this->cache->delete($this->makeKey($userId, $key));
    }

}