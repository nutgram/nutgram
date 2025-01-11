<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Testing;

use JsonSerializable;

class OutgoingResource implements JsonSerializable
{
    /**
     * OutgoingResource constructor.
     * @param  string|null  $name
     * @param  string|null  $type
     * @param  int  $size
     * @param  int  $error
     * @param  resource|null  $tmp_resource
     */
    public function __construct(
        protected ?string $name,
        protected ?string $type,
        protected int $size,
        protected int $error,
        protected mixed $tmp_resource
    ) {
    }

    public function jsonSerialize(): mixed
    {
        if ($this->name === null) {
            return basename(self::class);
        }

        return sprintf("%s{%s}", basename(self::class), $this->name);
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @return string|null
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @return int
     */
    public function getSize(): int
    {
        return $this->size;
    }

    /**
     * @return int
     */
    public function getError(): int
    {
        return $this->error;
    }

    /**
     * @return resource|null
     */
    public function getTmpResource()
    {
        return $this->tmp_resource;
    }

    public function __destruct()
    {
        if (is_resource($this->tmp_resource)) {
            @fclose($this->tmp_resource);
        }
    }
}
