<?php

namespace SergiX44\Nutgram\Telegram\Enums;

use ReflectionClass;

abstract class BaseEnum
{
    /**
     * @return array
     */
    public static function all(): array
    {
        return (new ReflectionClass(static::class))->getConstants();
    }
}
