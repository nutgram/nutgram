<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Support\Progress\Triggers;

use SergiX44\Container\Container;
use SergiX44\Nutgram\Support\Progress\Progress;
use SergiX44\Nutgram\Support\Progress\Trigger;

class EveryPercent implements Trigger
{
    protected float $lastPercentage = 0;

    public function __construct(protected float $step = 1, protected int $precision = 0)
    {
    }

    public function handle(Progress $progress, Container $container): bool
    {
        $current = (float)$progress->percentage($this->precision);

        if ($this->lastPercentage === $current) {
            return false;
        }

        if ($current - $this->lastPercentage >= $this->step) {
            $this->lastPercentage = $current;
            return true;
        }

        return false;
    }
}
