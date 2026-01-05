<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Handlers\Type;

interface TelegramCommand
{
    public string|array $description { get; }
}
