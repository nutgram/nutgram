<?php

namespace SergiX44\Nutgram\Exception;

use Exception;
use Throwable;

class CannotSerializeException extends Exception
{
    public function __construct(string $message = 'Cannot serialize. Please remove closures and try again.', int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
