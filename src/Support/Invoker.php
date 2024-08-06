<?php

namespace SergiX44\Nutgram\Support;

trait Invoker
{
    protected mixed $invoker = null;

    public function invoker(mixed $classStringOrInstance): self
    {
        $this->invoker = $classStringOrInstance;
        return $this;
    }

    public function getInvoker(): mixed
    {
        return $this->invoker;
    }
}
