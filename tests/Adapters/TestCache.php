<?php

namespace SergiX44\Nutgram\Tests\Adapters;

use Psr\SimpleCache\CacheInterface;
use SergiX44\Nutgram\Support\InteractsWithTime;

class TestCache implements CacheInterface
{
    use InteractsWithTime;

    protected const CACHE_DIR = __DIR__.'/../Cache';

    public function get(string $key, mixed $default = null): mixed
    {
        $this->checkExpire($key);

        $cacheFilePath = $this->getCacheFilePath($key);
        if (file_exists($cacheFilePath)) {
            $cache = unserialize(file_get_contents($cacheFilePath));
            return $cache['value'];
        }
        return $default;
    }

    public function set(string $key, mixed $value, \DateInterval|int|null $ttl = null): bool
    {
        $this->delete($key);

        return file_put_contents($this->getCacheFilePath($key), serialize([
            'value' => $value,
            'ttl' => $ttl !== null ? $this->expiringAt($ttl) : null,
        ]));
    }

    public function delete(string $key): bool
    {
        $cacheFilePath = $this->getCacheFilePath($key);
        if (file_exists($cacheFilePath)) {
            return unlink($cacheFilePath);
        }
        return true;
    }

    public function clear(): bool
    {
        $cacheFiles = glob(sprintf("%s/*.cache", self::CACHE_DIR));
        foreach ($cacheFiles as $cacheFile) {
            unlink($cacheFile);
        }
        return true;
    }

    public function getMultiple(iterable $keys, mixed $default = null): iterable
    {
        $values = [];
        foreach ($keys as $key) {
            $values[$key] = $this->get($key, $default);
        }
        return $values;
    }

    public function setMultiple(iterable $values, \DateInterval|int|null $ttl = null): bool
    {
        foreach ($values as $key => $value) {
            $this->set($key, $value, $ttl);
        }
        return true;
    }

    public function deleteMultiple(iterable $keys): bool
    {
        foreach ($keys as $key) {
            $this->delete($key);
        }
        return true;
    }

    public function has(string $key): bool
    {
        return file_exists($this->getCacheFilePath($key));
    }

    protected function getCacheFilePath(string $key): string
    {
        return sprintf("%s/%s.cache", self::CACHE_DIR, $key);
    }

    protected function checkExpire(string $key): void
    {
        $cacheFilePath = $this->getCacheFilePath($key);
        if (file_exists($cacheFilePath)) {
            $cache = unserialize(file_get_contents($this->getCacheFilePath($key)));
            if ($cache['ttl'] !== null && $this->hasExpired($cache['ttl'])) {
                $this->delete($key);
            }
        }
    }
}
