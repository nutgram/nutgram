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

        if ($message instanceof Stringable) {
            $message = $message->__toString();
        }

        $time = "\033[33m".date('Y-m-d H:i:s')."\033[0m";

        if (!array_key_exists('type', $context)) {
            $this->printDefault($time, $level, $message, $context);
            return;
        }

        if ($context['type'] === 'request') {
            $this->printRequest($time, $level, $message, $context);
            return;
        }

        if ($context['type'] === 'response') {
            $this->printResponse($time, $level, $message, $context);
            return;
        }
    }

    protected function isCli(): bool
    {
        return PHP_SAPI === 'cli';
    }

    protected function printRequest(string $time, string $level, string $message, array $context): void
    {
        $message .= sprintf(' (%s)', "\033[32m".$context['endpoint']."\033[0m");
        $this->printDefault($time, $level, $message, $context);
    }

    protected function printResponse(string $time, string $level, string $message, array $context): void
    {
        $this->printDefault($time, $level, $message, $context);
        echo "===============================\n";
    }

    protected function printDefault(string $time, string $level, string $message, array $context): void
    {
        $stringContext = trim(json_encode($context, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
        printf("[%s] %s: %s\n%s\n", $time, strtoupper($level), $message, $stringContext);
    }
}
