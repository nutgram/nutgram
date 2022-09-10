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
            "[%s] %s: %s\n\n",
            date('Y-m-d H:i:s'),
            strtoupper($level),
            $this->interpolate($message, $context)
        ));
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
