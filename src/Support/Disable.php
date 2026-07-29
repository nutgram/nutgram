<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Support;

trait Disable
{
    protected bool $disabled = false;

    public function unless(bool $condition): self
    {
        $this->disabled = $condition;
        return $this;
    }

    public function isDisabled(): bool
    {
        return $this->disabled;
    }
}
