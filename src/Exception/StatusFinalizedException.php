<?php

namespace SergiX44\Nutgram\Exception;

use Exception;
use JetBrains\PhpStorm\Pure;
use Throwable;

class StatusFinalizedException extends Exception
{
    #[Pure] public function __construct(
        string $message = 'No further handlers can be registered after finalisation.',
        int $code = 0,
        ?Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }

}
