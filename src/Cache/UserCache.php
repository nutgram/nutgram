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
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function get($userId)
    {
        return $this->cache->get($this->makeKey($userId));
    }

    /**
     * @param $userId
     * @param $data
     * @return bool
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function set($userId, $data): bool
    {
        return $this->cache->set($this->makeKey($userId), $data, $this->ttl);
    }

    /**
     * @param $userId
     * @return bool
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function delete($userId): bool
    {
        return $this->cache->delete($this->makeKey($userId));
    }

}