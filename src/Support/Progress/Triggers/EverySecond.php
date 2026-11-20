<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Support\Progress\Triggers;

use Psr\Clock\ClockInterface;
use SergiX44\Container\Container;
use SergiX44\Nutgram\Support\Progress\Progress;
use SergiX44\Nutgram\Support\Progress\Trigger;

class EverySecond implements Trigger
{
    protected int $lastSecond = 0;

    public function __construct(protected int $seconds = 1)
    {
    }

    public function handle(Progress $progress, Container $container): bool
    {
        $clock = $container->get(ClockInterface::class);

        $now = $clock->now()->getTimestamp();

        if ($this->lastSecond === $now) {
            return false;
        }

        if ($now - $this->lastSecond >= $this->seconds) {
            $this->lastSecond = $now;
            return true;
        }

        return false;
    }
}
