<?php

namespace SergiX44\Nutgram\Support;

use DateInterval;
use DateTimeImmutable;

trait InteractsWithTime
{
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

    protected function getNow(): DateTimeImmutable
    {
        return new DateTimeImmutable();
    }
}
