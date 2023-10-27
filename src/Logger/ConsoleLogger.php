<?php

namespace SergiX44\Nutgram\Logger;

use Psr\Log\AbstractLogger;
use Stringable;

class ConsoleLogger extends AbstractLogger
{
    public function log($level, Stringable|string $message, array $context = []): void
    {
        if (!$this->isCli()) {
            return;
        }

        $stringContext = trim(json_encode($context, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));

        if ($message instanceof Stringable) {
            $message = $message->__toString();
        }

        if (!empty($stringContext)) {
            $message .= "\n{$stringContext}";
        }

        printf(
            "[%s] %s: %s\n",
            "\033[33m".date('Y-m-d H:i:s')."\033[0m",
            strtoupper($level),
            $message,
        );

        if (array_key_exists('type', $context) && $context['type'] === 'response') {
            echo "===============================\n";
        }
    }

    protected function isCli(): bool
    {
        return PHP_SAPI === 'cli';
    }
}
