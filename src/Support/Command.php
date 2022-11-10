<?php

namespace SergiX44\Nutgram\Support;

abstract class Command
{
    public static string $name;

    public static ?string $description = null;

    public static array $middlewares = [];

    public static ?array $skipGlobalMiddlewares = null;
}
