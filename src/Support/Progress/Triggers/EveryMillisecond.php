<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Support\Progress\Triggers;

use Psr\Clock\ClockInterface;
use SergiX44\Container\Container;
use SergiX44\Nutgram\Support\Progress\Progress;
use SergiX44\Nutgram\Support\Progress\Trigger;

class EveryMillisecond implements Trigger
{
    protected int $lastMillisecond = 0;

    public function __construct(protected int $milliseconds = 100)
    {
    }

    public function handle(Progress $progress, Container $container): bool
    {
        $clock = $container->get(ClockInterface::class);

        $now = (int)$clock->now()->format('Uv');

        if ($this->lastMillisecond === $now) {
            return false;
        }

        if ($now - $this->lastMillisecond >= $this->milliseconds) {
            $this->lastMillisecond = $now;
            return true;
        }

        return false;
    }
}
