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

        print(sprintf(
            "[%s] %s: %s\n\n",
            date('Y-m-d H:i:s'),
            strtoupper($level),
            $message,
        ));
    }

    protected function isCli(): bool
    {
        return PHP_SAPI === 'cli';
    }
}
