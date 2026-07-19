<?php

namespace SergiX44\Nutgram\Support;

trait IsEphemeral
{
    protected bool $isEphemeral = false;

    public function ephemeral(bool $value = true): self
    {
        $this->isEphemeral = $value;
        return $this;
    }

    public function isEphemeral(): bool
    {
        return $this->isEphemeral;
    }
}
