<?php


namespace SergiX44\Nutgram\Proxies;

use SergiX44\Nutgram\Nutgram;

/**
 * Trait UserCacheProxy
 * @package SergiX44\Nutgram\Proxies
 * @mixin Nutgram
 */
trait UserCacheProxy
{
    /**
     * @param  $key
     * @param  $userId
     * @param  $default
     * @return mixed
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function getUserData($key, ?int $userId = null, $default = null): mixed
    {
        $userId = $userId ?? $this->getUserId();
        return $this->userCache->get($userId, $key, $default);
    }

    /**
     * @param $key
     * @param $value
     * @param  int|null  $userId
     * @return mixed
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function setUserData($key, $value, ?int $userId = null)
    {
        $userId = $userId ?? $this->getUserId();
        return $this->userCache->set($userId, $key, $value);
    }

    /**
     * @param $key
     * @param  int|null  $userId
     * @return bool
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function deleteUserData($key, ?int $userId = null)
    {
        $userId = $userId ?? $this->getUserId();
        return $this->userCache->delete($userId, $key);
    }
}