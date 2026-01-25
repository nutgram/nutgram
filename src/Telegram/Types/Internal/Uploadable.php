<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Telegram\Types\Internal;

use Psr\Http\Message\StreamInterface;

interface Uploadable
{
    public function isLocal(): bool;

    public function getFilename(): string;

    public function getStream(): StreamInterface;
}
