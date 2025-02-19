<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Testing;

use JsonSerializable;
use Psr\Http\Message\StreamInterface;

class OutgoingResource implements JsonSerializable
{
    public function __construct(
        protected ?string $name,
        protected ?string $type,
        protected int $size,
        protected int $error,
        protected ?StreamInterface $stream,
    ) {
    }

    public function jsonSerialize(): string
    {
        if ($this->name === null) {
            return basename(__CLASS__);
        }

        return sprintf("%s{%s}", basename(__CLASS__), $this->name);
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function getSize(): int
    {
        return $this->size;
    }

    public function getError(): int
    {
        return $this->error;
    }

    public function getStream(): ?StreamInterface
    {
        return $this->stream;
    }

    public function __destruct()
    {
        if ($this->stream instanceof StreamInterface) {
            $this->stream->close();
        }
    }
}
