<?php

namespace SergiX44\Nutgram\Testing;

use JsonSerializable;

class OutgoingResource implements JsonSerializable
{
    public ?string $name;

    public ?string $type;

    public int $size;

    public int $error;

    public ?string $tmp_name;

    /** @var resource $tmp_resource */
    public $tmp_resource;

    public function jsonSerialize()
    {
        return sprintf("OutgoingResource{%s}", $this->name);
    }
}
