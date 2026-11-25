<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Exception;

use RuntimeException;
use Throwable;

class StatusFinalizedException extends RuntimeException
{
    public function __construct(
        string $message = 'No further handlers can be registered after finalization.',
        int $code = 0,
        ?Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
