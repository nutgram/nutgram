<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Support\Progress;

use function SergiX44\Nutgram\Support\mapInterval;

final readonly class Progress
{
    public function __construct(
        public int $totalBytes,
        public int $currentBytes,
        public ProgressType $type,
    ) {
    }

    public function percentage(int $precision = 0): int|float
    {
        return mapInterval(
            current: $this->currentBytes,
            sourceStart: 0,
            sourceEnd: $this->totalBytes,
            precision: $precision
        );
    }
}
