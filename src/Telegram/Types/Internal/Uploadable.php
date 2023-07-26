<?php

namespace SergiX44\Nutgram\Telegram\Types\Internal;

interface Uploadable
{
    public function isLocal(): bool;


    public function getFilename(): string;

    /**
     * @return resource
     */
    public function getResource();
}
