<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Testing;

use JsonSerializable;
use Psr\Http\Message\StreamInterface;

readonly class OutgoingResource implements JsonSerializable
{
    public function __construct(
        protected ?string $name,
        protected string $mime,
        protected ?int $size,
        protected StreamInterface $stream,
    ) {
    }

    public function jsonSerialize(): string
    {
        if ($this->name === null) {
            return basename(self::class);
        }

        return sprintf("%s{%s}", basename(self::class), $this->name);
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getMime(): string
    {
        return $this->mime;
    }

    public function getSize(): ?int
    {
        return $this->size;
    }

    public function getStream(): StreamInterface
    {
        return $this->stream;
    }

    public function __destruct()
    {
        $this->stream->close();
    }
}
