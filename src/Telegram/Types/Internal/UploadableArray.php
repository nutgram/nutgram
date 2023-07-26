<?php

namespace SergiX44\Nutgram\Telegram\Types\Internal;

class UploadableArray implements \JsonSerializable
{
    /**
     * @param Uploadable[] $files
     */
    public function __construct(public readonly array $files)
    {
    }


    public function jsonSerialize(): mixed
    {
        return $this->files;
    }
}
