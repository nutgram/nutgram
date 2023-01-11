<?php


namespace SergiX44\Nutgram\Proxies;

use DateInterval;
use Psr\SimpleCache\InvalidArgumentException;

/**
 * Trait UserCacheProxy
 * @package SergiX44\Nutgram\Proxies
 */
trait UserCacheProxy
{
    /**
     * @param  $key
     * @param  int|null  $userId
     * @param  null  $default
     * @return mixed
     * @throws InvalidArgumentException
     */
    public function getUserData($key, ?int $userId = null, $default = null): mixed
    {
        $userId = $userId ?? $this->userId();
        return $this->userCache->get($userId, $key, $default);
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
        return $this->userCache->set($userId, $key, $value, $ttl);
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
        return $this->userCache->delete($userId, $key);
    }
}
