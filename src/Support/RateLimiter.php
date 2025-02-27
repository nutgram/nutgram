<?php

namespace SergiX44\Nutgram\Support;

use Psr\SimpleCache\CacheInterface;

class RateLimiter
{
    use InteractsWithTime;

    protected const CACHE_KEY = 'RATE_LIMITER';

    protected CacheInterface $cache;
    protected string $key;
    protected int $maxAttempts;
    protected int $decaySeconds;

    public function __construct(CacheInterface $cache, string $key, int $maxAttempts, int $decaySeconds = 60)
    {
        $this->cache = $cache;
        $this->key = sprintf("%s:%s", self::CACHE_KEY, $key);
        $this->maxAttempts = $maxAttempts;
        $this->decaySeconds = $decaySeconds;
    }

    public function increment(): void
    {
        if (!$this->cache->has($this->key.':timer')) {
            $this->cache->set($this->key.':timer', $this->availableAt($this->decaySeconds), $this->decaySeconds);
        }

        $this->cache->set($this->key, $this->attempts() + 1, $this->decaySeconds);
    }

    public function tooManyAttempts(): bool
    {
        if ($this->attempts() >= $this->maxAttempts) {
            if ($this->cache->has($this->key.':timer')) {
                return true;
            }

            $this->resetAttempts();
        }

        return false;
    }

    public function attempts(): int
    {
        return (int)$this->cache->get($this->key, 0);
    }

    public function resetAttempts(): void
    {
        $this->cache->delete($this->key);
    }

    public function availableIn(): int
    {
        return max(0, $this->cache->get($this->key.':timer') - $this->getNow()->getTimestamp());
    }

    public function getKey(): string
    {
        return $this->key;
    }
}
