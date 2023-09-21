<?php

namespace SergiX44\Nutgram\Support;

trait Disable
{
    protected bool $disabled = false;

    public function disable(bool $condition = true): self
    {
        $this->disabled = $condition;
        return $this;
    }

    public function isDisabled(): bool
    {
        return $this->disabled;
    }
}
