<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Telegram\Types\Internal;

interface Uploadables
{
    /**
     * Current values of properties that may contain files, keyed by property name.
     * @return array<string, object|array|string|null>
     */
    public function uploadables(): array;
}
