<?php

namespace SergiX44\Nutgram\Tests\Fixtures\DI;

class WrapperData
{
    protected string $value;

    public function __construct(string $value)
    {
        $this->value = 'wrapped:'.$value;
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
