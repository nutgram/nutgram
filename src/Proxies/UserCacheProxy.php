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
     * @param string $key
     * @param int|null $userId
     * @param mixed $default
     * @return mixed
     * @throws InvalidArgumentException
     */
    public function getUserData($key, ?int $userId = null, $default = null): mixed
    {
        $userId = $userId ?? $this->userId();
        return $this->userCache->get($userId, $key, $default);
    }

    /**
     * @param string $key
     * @param mixed $value
     * @param int|null $userId
     * @param DateInterval|int|null $ttl
     * @return bool
     * @throws InvalidArgumentException
     */
    public function setUserData($key, $value, ?int $userId = null, DateInterval|int|null $ttl = null): bool
    {
        $userId = $userId ?? $this->userId();
        return $this->userCache->set($userId, $key, $value, $ttl);
    }

    /**
     * @param string $key
     * @param int|null $userId
     * @return bool
     * @throws InvalidArgumentException
     */
    public function deleteUserData($key, ?int $userId = null): bool
    {
        $userId = $userId ?? $this->userId();
        return $this->userCache->delete($userId, $key);
    }
}
