<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Proxies;

use DateInterval;
use Psr\SimpleCache\InvalidArgumentException;
use SergiX44\Nutgram\Cache\UserCache;

/**
 * Trait UserCacheProxy
 * @package SergiX44\Nutgram\Proxies
 */
trait UserCacheProxy
{
    /**
     * @param  $key
     * @param  int|null  $userId
     * @param  mixed  $default
     * @return mixed
     * @throws InvalidArgumentException
     */
    public function getUserData($key, ?int $userId = null, $default = null): mixed
    {
        $userId = $userId ?? $this->userId();
        return $this->container->get(UserCache::class)->get($userId, $key, $default);
    }

    /**
     * @param $key
     * @param $value
     * @param  int|null  $userId
     * @param  DateInterval|int|null  $ttl
     * @return bool
     * @throws InvalidArgumentException
     */
    public function setUserData($key, $value, ?int $userId = null, DateInterval|int|null $ttl = null): bool
    {
        $userId = $userId ?? $this->userId();
        return $this->container->get(UserCache::class)->set($userId, $key, $value, $ttl);
    }

    /**
     * @param $key
     * @param  int|null  $userId
     * @return bool
     * @throws InvalidArgumentException
     */
    public function deleteUserData($key, ?int $userId = null): bool
    {
        $userId = $userId ?? $this->userId();
        return $this->container->get(UserCache::class)->delete($userId, $key);
    }
}
