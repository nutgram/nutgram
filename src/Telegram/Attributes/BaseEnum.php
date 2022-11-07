<?php

namespace SergiX44\Nutgram\Telegram\Attributes;

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
