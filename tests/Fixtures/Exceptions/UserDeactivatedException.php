<?php

namespace SergiX44\Nutgram\Tests\Fixtures\Exceptions;

use SergiX44\Nutgram\Exception\ApiException;

class UserDeactivatedException extends ApiException
{
    public static ?string $pattern = '.*deactivated.*';
}
