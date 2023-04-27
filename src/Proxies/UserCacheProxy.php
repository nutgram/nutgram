<?php

namespace SergiX44\Nutgram\Proxies;

use DateInterval;
use Psr\SimpleCache\InvalidArgumentException;

/**
 * Trait UserCacheProxy.
 */
trait UserCacheProxy
{
    /**
     * @param          $key
     * @param int|null $userId
     * @param null     $default
     *
     * @throws InvalidArgumentException
     *
     * @return mixed
     */
    public function getUserData($key, ?int $userId = null, $default = null): mixed
    {
        $userId = $userId ?? $this->userId();

        return $this->userCache->get($userId, $key, $default);
    }

    /**
     * @param $key
     * @param $value
     * @param int|null              $userId
     * @param DateInterval|int|null $ttl
     *
     * @throws InvalidArgumentException
     *
     * @return bool
     */
    public function setUserData($key, $value, ?int $userId = null, DateInterval|int|null $ttl = null): bool
    {
        $userId = $userId ?? $this->userId();

        return $this->userCache->set($userId, $key, $value, $ttl);
    }

    /**
     * @param $key
     * @param int|null $userId
     *
     * @throws InvalidArgumentException
     *
     * @return bool
     */
    public function deleteUserData($key, ?int $userId = null): bool
    {
        $userId = $userId ?? $this->userId();

        return $this->userCache->delete($userId, $key);
    }
}
