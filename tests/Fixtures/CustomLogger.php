<?php

namespace SergiX44\Nutgram\Tests\Fixtures;

use Psr\Log\AbstractLogger;

class CustomLogger extends AbstractLogger
{
    public function log($level, \Stringable|string $message, array $context = []): void
    {
        expect($message)->toContain('sendMessage');
    }
}
