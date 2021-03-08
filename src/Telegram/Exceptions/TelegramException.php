<?php

namespace SergiX44\Nutgram\Telegram\Exceptions;

use Exception;

class TelegramException extends Exception
{
    /**
     * TelegramException constructor.
     * @param $message
     * @param  int  $code
     * @param  Exception|null  $previous
     */
    public function __construct($message, $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
