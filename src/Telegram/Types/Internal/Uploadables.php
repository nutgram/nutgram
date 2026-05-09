<?php

namespace SergiX44\Nutgram\Telegram\Types\Internal;

interface Uploadables
{
    /**
     * Names of the properties that can be uploaded
     * @return string[]
     */
    public function uploadables(): array;
}
