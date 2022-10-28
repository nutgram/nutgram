<?php

namespace SergiX44\Nutgram\Testing;

use JsonSerializable;

class OutgoingResource implements JsonSerializable
{
    protected ?string $name;

    protected ?string $type;

    protected int $size;

    protected int $error;

    /** @var resource|null $tmp_resource */
    protected $tmp_resource;

    /**
     * OutgoingResource constructor.
     * @param  string|null  $name
     * @param  string|null  $type
     * @param  int  $size
     * @param  int  $error
     * @param  resource|null  $tmp_resource
     */
    public function __construct(
        ?string $name,
        ?string $type,
        int $size,
        int $error,
        $tmp_resource
    ) {
        $this->name = $name;
        $this->type = $type;
        $this->size = $size;
        $this->error = $error;
        $this->tmp_resource = $tmp_resource;
    }

    public function jsonSerialize(): mixed
    {
        if ($this->name === null) {
            return basename(__CLASS__);
        }

        return sprintf("%s{%s}", basename(__CLASS__), $this->name);
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
