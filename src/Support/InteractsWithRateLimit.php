<?php

namespace SergiX44\Nutgram\Support;

use SergiX44\Nutgram\Middleware\RateLimit;
use SergiX44\Nutgram\Nutgram;

trait InteractsWithRateLimit
{
    /** @var RateLimit[] */
    protected array $rateLimiters = [];

    protected bool $withoutRateLimit = false;

    /**
     * @param int $maxAttempts
     * @param int $decaySeconds
     * @param string|null $key
     * @param null|callable(Nutgram $bot, int $availableIn): void $warningCallback
     * @return self
     */
    public function throttle(
        int $maxAttempts,
        int $decaySeconds = 60,
        ?string $key = null,
        $warningCallback = null
    ): self {
        $this->rateLimiters[] = new RateLimit(
            maxAttempts: $maxAttempts,
            decaySeconds: $decaySeconds,
            key: $key,
            warningCallback: $warningCallback,
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
