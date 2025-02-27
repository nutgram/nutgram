<?php

namespace SergiX44\Nutgram\Support;

use SergiX44\Nutgram\Middleware\RateLimit;

trait InteractsWithRateLimit
{
    /** @var RateLimit[] */
    protected array $rateLimiters = [];

    protected bool $withoutRateLimit = false;

    public function throttle(int $maxAttempts, int $decaySeconds = 60, ?string $key = null): self
    {
        $this->rateLimiters[] = new RateLimit(
            maxAttempts: $maxAttempts,
            decaySeconds: $decaySeconds,
            key: $key,
        );

        return $this;
    }

    public function getRateLimit(): ?RateLimit
    {
        return $this->rateLimiters[array_key_first($this->rateLimiters)] ?? null;
    }

    public function appendRateLimiters(array $rateLimiters): void
    {
        $this->rateLimiters = [...$this->rateLimiters, ...$rateLimiters];
    }

    public function withoutThrottle(bool $value = true): self
    {
        $this->withoutRateLimit = $value;

        return $this;
    }

    public function isWithoutRateLimit(): bool
    {
        return $this->withoutRateLimit;
    }
}
