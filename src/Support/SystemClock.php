<?php

namespace SergiX44\Nutgram\Support;

use DateTimeImmutable;
use Psr\Clock\ClockInterface;

class SystemClock implements ClockInterface
{
    public function now(): DateTimeImmutable
    {
        return new DateTimeImmutable();
    }
}
