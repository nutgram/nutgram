<?php

namespace SergiX44\Nutgram\Exception;

use Exception;

abstract class ThrowableApiError extends Exception
{
    abstract public static function pattern(): string;
}
