<?php

namespace SergiX44\Nutgram\Exception;

use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Exceptions\TelegramException;

abstract class ApiException extends TelegramException
{
    public static ?string $pattern = null;

    /**
     * @throws ApiException
     */
    public function __invoke(Nutgram $bot, TelegramException $e)
    {
        // lemme yeeet myself
        throw new static($e->getMessage(), $e->getCode(), $e);
    }
}
