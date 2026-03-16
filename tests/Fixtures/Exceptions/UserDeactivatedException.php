<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Tests\Fixtures\Exceptions;

use SergiX44\Nutgram\Exception\ApiException;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Exceptions\TelegramException;

class UserDeactivatedException extends ApiException
{
    public static ?string $pattern = '.*deactivated.*';

    public function __construct($message = '', int $code = 0, $previous = null, array $parameters = [], protected bool $mute = false)
    {
        parent::__construct($message, $code, $previous, $parameters);
    }

    public function __invoke(Nutgram $bot, TelegramException $e)
    {
        if ($this->mute) {
            return;
        }

        parent::__invoke($bot, $e);
    }
}
