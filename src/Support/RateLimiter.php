<?php

namespace SergiX44\Nutgram\Support;

use Closure;
use DateInterval;
use DateTime;
use DateTimeInterface;
use Psr\SimpleCache\CacheInterface;

class RateLimiter
{
    protected CacheInterface $cache;

    protected array $limiters = [];

    public function __construct(CacheInterface $cache)
    {
        $this->cache = $cache;
    }

    /**
     * Register a named limiter configuration.
     * @param string $name
     * @param Closure $callback
     * @return $this
     */
    public function for(string $name, Closure $callback): self
    {
        $this->limiters[$name] = $callback;

        return $this;
    }

    /**
     * Get the given named rate limiter.
     * @param string $name
     * @return Closure|null
     */
    public function limiter(string $name): ?Closure
    {
        return $this->limiters[$name] ?? null;
    }

    /**
     * Clean the rate limiter key from unicode characters.
     * @param string $key
     * @return string
     */
    public function cleanRateLimiterKey(string $key): string
    {
        return preg_replace('/&([a-z])[a-z]+;/i', '$1', htmlentities($key));
    }

    /**
     * Get the number of attempts for the given key.
     * @param string $key
     * @return mixed
     */
    public function attempts(string $key): mixed
    {
        $key = $this->cleanRateLimiterKey($key);

        return $this->cache->get($key, 0);
    }

    /**
     * Reset the number of attempts for the given key.
     * @param string $key
     * @return bool
     */
    public function resetAttempts(string $key): bool
    {
        $key = $this->cleanRateLimiterKey($key);

        return $this->cache->delete($key);
    }

    /**
     * Determine if the given key has been "accessed" too many times.
     * @param string $key
     * @param int $maxAttempts
     * @return bool
     */
    public function tooManyAttempts(string $key, int $maxAttempts): bool
    {
        if ($this->attempts($key) >= $maxAttempts) {
            if ($this->cache->has($this->cleanRateLimiterKey($key).':timer')) {
                return true;
            }

            $this->resetAttempts($key);
        }

        return false;
    }

    /**
     * Get the number of seconds until the given DateTime.
     * @param DateTimeInterface|DateInterval|int $delay
     * @return int
     */
    protected function secondsUntil(DateTimeInterface|DateInterval|int $delay): int
    {
        $delay = $this->parseDateInterval($delay);

        return $delay instanceof DateTimeInterface
            ? max(0, $delay->getTimestamp() - $this->currentTime())
            : (int)$delay;
    }

    /**
     * Get the "available at" UNIX timestamp.
     * @param DateTimeInterface|DateInterval|int $delay
     * @return int
     */
    protected function availableAt(DateTimeInterface|DateInterval|int $delay = 0): int
    {
        $delay = $this->parseDateInterval($delay);

        if ($delay instanceof DateTimeInterface) {
            return $delay->getTimestamp();
        }

        if (is_int($delay)) {
            $delay = new DateInterval("PT{$delay}S");
        }

        return (new DateTime())->add($delay)->getTimestamp();
    }

    /**
     * If the given value is an interval, convert it to a DateTime instance.
     * @param DateTimeInterface|DateInterval|int $delay
     * @return DateTimeInterface|int
     */
    protected function parseDateInterval(DateTimeInterface|DateInterval|int $delay): DateTimeInterface|int
    {
        if ($delay instanceof DateInterval) {
            $delay = (new DateTime())->add($delay);
        }

        return $delay;
    }

    /**
     * Get the current system time as a UNIX timestamp.
     *
     * @return int
     */
    protected function currentTime(): int
    {
        return (new DateTime())->getTimestamp();
    }

    /**
     * Increment the counter for a given key for a given decay time.
     *
     * @param string $key
     * @param int $decaySeconds
     * @return int
     */
    public function hit(string $key, int $decaySeconds = 60): int
    {
        $key = $this->cleanRateLimiterKey($key);

        $this->cacheAdd($key.':timer', $this->availableAt($decaySeconds), $decaySeconds);

        $added = $this->cacheAdd($key, 0, $decaySeconds);

        $hits = $this->cacheIncrement($key);

        if (!$added && $hits == 1) {
            $this->cache->set($key, 1, $decaySeconds);
        }

        return $hits;
    }

    protected function cacheAdd(string $key, int $value, int $seconds): bool
    {
        if ($this->cache->has($key)) {
            return false;
        }

        return $this->cache->set($key, $value, $seconds);
    }

    protected function cacheIncrement(string $key, int $value = 1): int
    {
        if (!$this->cache->has($key)) {
            $this->cache->set($key, 0);
        }

        $currentValue = (int)$this->cache->get($key);
        $newValue = $currentValue + $value;

        $this->cache->set($key, $newValue);

        return $newValue;
    }

    /**
     * Attempts to execute a callback if it's not limited.
     * @param string $key
     * @param int $maxAttempts
     * @param \Closure $callback
     * @param int $decaySeconds
     * @return mixed
     */
    public function attempt(string $key, int $maxAttempts, Closure $callback, int $decaySeconds = 60): mixed
    {
        if ($this->tooManyAttempts($key, $maxAttempts)) {
            return false;
        }

        $result = $callback() ?: true;

        $this->hit($key, $decaySeconds);

        return $result;
    }

    /**
     * Get the number of retries left for the given key.
     * @param string $key
     * @param int $maxAttempts
     * @return int
     */
    public function remaining(string $key, int $maxAttempts): int
    {
        $key = $this->cleanRateLimiterKey($key);

        $attempts = $this->attempts($key);

        return $maxAttempts - $attempts;
    }

    /**
     * Get the number of retries left for the given key.
     * @param string $key
     * @param int $maxAttempts
     * @return int
     */
    public function retriesLeft(string $key, int $maxAttempts): int
    {
        return $this->remaining($key, $maxAttempts);
    }

    /**
     * Clear the hits and lockout timer for the given key.
     * @param string $key
     * @return void
     */
    public function clear(string $key): void
    {
        $key = $this->cleanRateLimiterKey($key);

        $this->resetAttempts($key);

        $this->cache->delete($key.':timer');
    }

    /**
     * Get the number of seconds until the "key" is accessible again.
     * @param string $key
     * @return int
     */
    public function availableIn(string $key): int
    {
        $key = $this->cleanRateLimiterKey($key);

        return max(0, $this->cache->get($key.':timer') - $this->currentTime());
    }
}
