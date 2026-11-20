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
     * @param string $key
     * @param mixed $default
     * @throws InvalidArgumentException
     */
    public function getUserData($key, ?int $userId = null, $default = null): mixed
    {
        $userId ??= $this->userId();
        return $this->container->get(UserCache::class)->get($userId, $key, $default);
    }

    /**
     * @param string $key
     * @param mixed $value
     * @throws InvalidArgumentException
     */
    public function setUserData($key, $value, ?int $userId = null, DateInterval|int|null $ttl = null): bool
    {
        $userId ??= $this->userId();
        return $this->container->get(UserCache::class)->set($userId, $key, $value, $ttl);
    }

    /**
     * @param string $key
     * @throws InvalidArgumentException
     */
    public function deleteUserData($key, ?int $userId = null): bool
    {
        $userId ??= $this->userId();
        return $this->container->get(UserCache::class)->delete($userId, $key);
    }
}
