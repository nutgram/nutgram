<?php

namespace SergiX44\Nutgram\Support;

class Throttle
{
    protected int $attempts;
    protected int $decay;

    public function __construct(int $attempts = 5, int $decay = 1)
    {
        $this->attempts = $attempts;
        $this->decay = $decay;
    }

    public function getAttempts(): int
    {
        return $this->attempts;
    }

    public function getDecay(): int
    {
        return $this->decay;
    }
}
