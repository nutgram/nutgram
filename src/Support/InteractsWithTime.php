<?php

namespace SergiX44\Nutgram\Support;

use DateInterval;
use DateTimeImmutable;
use DateTimeInterface;

trait InteractsWithTime
{
    protected function expiringAt(DateInterval|int $ttl): DateTimeInterface
    {
        $now = $this->getNow();

        if ($ttl instanceof DateInterval) {
            return $now->add($ttl);
        }

        return $now->add(new DateInterval("PT{$ttl}S"));
    }

    protected function hasExpired(DateTimeInterface $expiration): bool
    {
        return $this->getNow()->getTimestamp() >= $expiration->getTimestamp();
    }

    protected function getNow(): DateTimeInterface
    {
        return new DateTimeImmutable();
    }
}
