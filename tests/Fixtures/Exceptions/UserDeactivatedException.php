<?php

namespace SergiX44\Nutgram\Tests\Fixtures\Exceptions;

use SergiX44\Nutgram\Exception\ThrowableApiError;

class UserDeactivatedException extends ThrowableApiError
{
    public static function pattern(): string
    {
        return '.*deactivated.*';
    }
}
