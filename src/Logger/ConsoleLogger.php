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

        print(sprintf(
            "[%s] %s: %s",
            date('Y-m-d H:i:s'),
            $level,
            $this->interpolate($message, $context)
        ).PHP_EOL);
    }

    private function interpolate(Stringable|string $message, array $context): string
    {
        $replace = [];
        foreach ($context as $key => $val) {
            if (!is_array($val) && (!is_object($val) || method_exists($val, '__toString'))) {
                $replace['{'.$key.'}'] = $val;
            }
        }

        return strtr($message, $replace);
    }
}
