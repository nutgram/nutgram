<?php

namespace SergiX44\Nutgram\Support;

trait HasThrottle
{
    protected ?Throttle $throttle = null;

    public function throttle(int $attempts = 5, int $decay = 1): self
    {
        $this->throttle = new Throttle($attempts, $decay);
        return $this;
    }

    public function getThrottle(): ?Throttle
    {
        return $this->throttle;
    }

    public function getThrottleHash(): string
    {
        return crc32(serialize(get_object_vars($this)));
    }
}
