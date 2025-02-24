<?php

namespace SergiX44\Nutgram\Support;

use DateInterval;
use DateTimeImmutable;
use DateTimeInterface;

trait InteractsWithTime
{
    protected static DateTimeImmutable|null $testNow = null;

    public static function hasTestNow(): bool
    {
        return self::$testNow !== null;
    }

    public static function setTestNow(DateTimeImmutable $now): void
    {
        self::$testNow = $now;
    }

    public static function getTestNow(): DateTimeImmutable|null
    {
        return self::$testNow;
    }

    protected function getNow(): DateTimeImmutable
    {
        return self::getTestNow() ?? new DateTimeImmutable();
    }

    protected function expiringAt(DateInterval|int $ttl): DateTimeImmutable
    {
        $now = $this->getNow();

        if ($ttl instanceof DateInterval) {
            return $now->add($ttl);
        }

        return $now->add(new DateInterval("PT{$ttl}S"));
    }

    protected function hasExpired(DateTimeImmutable $expiration): bool
    {
        return $this->getNow()->getTimestamp() >= $expiration->getTimestamp();
    }

    protected function parseDateInterval(DateTimeInterface|DateInterval|int $delay): DateTimeInterface|int
    {
        if ($delay instanceof DateInterval) {
            return $this->getNow()->add($delay);
        }

        return $delay;
    }

    protected function availableAt(DateTimeInterface|DateInterval|int $delay = 0): int
    {
        $delay = $this->parseDateInterval($delay);

        return $delay instanceof DateTimeInterface
            ? $delay->getTimestamp()
            : $this->getNow()->getTimestamp() + $delay;
    }
}
