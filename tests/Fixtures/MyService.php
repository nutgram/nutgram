<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Tests\Fixtures;

class MyService
{
    public function __construct(public string $value)
    {
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
