<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Telegram\Types\Internal;

use JsonSerializable;

readonly class UploadableArray implements JsonSerializable
{
    /**
     * @param Uploadables[] $files
     */
    public function __construct(public array $files)
    {
    }


    public function jsonSerialize(): array
    {
        return $this->files;
    }
}
