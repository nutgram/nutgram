<?php

namespace SergiX44\Nutgram\Logger;

use Psr\Log\AbstractLogger;
use Stringable;

class ConsoleLogger extends AbstractLogger
{
    public function log($level, Stringable|string $message, array $context = []): void
    {
        if (PHP_SAPI !== 'cli') {
            return;
        }

        $stringContext = trim(json_encode($context));

        if (!empty($stringContext)) {
            $message .= "\n{$stringContext}";
        }

        print(sprintf(
            "[%s] %s: %s\n\n",
            date('Y-m-d H:i:s'),
            strtoupper($level),
            $message,
        ));
    }
}
