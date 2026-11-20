<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Cache;

use DateInterval;
use Psr\SimpleCache\CacheInterface;
use Psr\SimpleCache\InvalidArgumentException;

class UserCache extends BotCache
{
    protected const USERDATA_PREFIX = 'USER';

    public function __construct(CacheInterface $cache, ?int $botId)
    {
        parent::__construct($cache, self::USERDATA_PREFIX, $botId);
    }

    /**
     * @param  mixed  $default
     * @throws InvalidArgumentException
     */
    public function get(int $userId, string $key, $default = null): mixed
    {
        return $this->cache->get($this->makeKey($userId, $key), $default);
    }

    /**
     * @throws InvalidArgumentException
     */
    public function set(int $userId, string $key, mixed $data, DateInterval|int|null $ttl = null): bool
    {
        return $this->cache->set($this->makeKey($userId, $key), $data, $ttl);
    }

    /**
     * @throws InvalidArgumentException
     */
    public function delete(int $userId, string $key): bool
    {
        return $this->cache->delete($this->makeKey($userId, $key));
    }
}
