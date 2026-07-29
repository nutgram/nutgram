<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Support\Progress\Triggers;

use SergiX44\Container\Container;
use SergiX44\Nutgram\Support\Progress\Progress;
use SergiX44\Nutgram\Support\Progress\Trigger;

class EveryByte implements Trigger
{
    protected int $lastBytes = 0;

    public function __construct(protected int $bytes = 1)
    {
    }

    public function handle(Progress $progress, Container $container): bool
    {
        $current = $progress->currentBytes;

        if ($this->lastBytes === $current) {
            return false;
        }

        if ($current - $this->lastBytes >= $this->bytes) {
            $this->lastBytes = $current;
            return true;
        }

        return false;
    }
}
