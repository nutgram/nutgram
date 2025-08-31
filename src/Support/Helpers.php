<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Support;

use InvalidArgumentException;
use ReflectionMethod;

if (!function_exists(__NAMESPACE__.'\array_filter_null')) {
    function array_filter_null(array $array): array
    {
        return array_filter($array, static fn ($value) => $value !== null);
    }
}

if (!function_exists(__NAMESPACE__.'\word_wrap')) {
    function word_wrap(string $string, int $width = 75, string $break = "\n", bool $cut = false): string
    {
        if ($string === '') {
            return '';
        }

        if ($break === '') {
            throw new InvalidArgumentException('Break string cannot be empty');
        }

        if ($width === 0 && $cut) {
            throw new InvalidArgumentException('Cannot force cut when width is zero');
        }

        $stringWidth = mb_strlen($string);
        $breakWidth = mb_strlen($break);

        $result = '';
        $lastStart = $lastSpace = 0;

        for ($current = 0; $current < $stringWidth; $current++) {
            $char = mb_substr($string, $current, 1);

            $possibleBreak = $char;
            if ($breakWidth !== 1) {
                $possibleBreak = mb_substr($string, $current, $breakWidth);
            }

            if ($possibleBreak === $break) {
                $result .= mb_substr($string, $lastStart, $current - $lastStart + $breakWidth);
                $current += $breakWidth - 1;
                $lastStart = $lastSpace = $current + 1;
                continue;
            }

            if ($char === ' ') {
                if ($current - $lastStart >= $width) {
                    $result .= mb_substr($string, $lastStart, $current - $lastStart).$break;
                    $lastStart = $current + 1;
                }

                $lastSpace = $current;
                continue;
            }

            if ($current - $lastStart >= $width && $cut && $lastStart >= $lastSpace) {
                $result .= mb_substr($string, $lastStart, $current - $lastStart).$break;
                $lastStart = $lastSpace = $current;
                continue;
            }

            if ($current - $lastStart >= $width && $lastStart < $lastSpace) {
                $result .= mb_substr($string, $lastStart, $lastSpace - $lastStart).$break;
                $lastStart = ++$lastSpace;
            }
        }

        if ($lastStart !== $current) {
            $result .= mb_substr($string, $lastStart, $current - $lastStart);
        }

        return $result;
    }
}

if (!function_exists(__NAMESPACE__.'\deepLink')) {
    function deepLink(?string $baseUrl = null): DeepLink
    {
        return new DeepLink($baseUrl);
    }
}

if (!function_exists(__NAMESPACE__.'\func_get_named_args')) {
    /**
     * This function retrieves the named arguments of the calling class method.
     * Functions or closures are not supported.
     * This is a temporary solution until PHP supports a native way to do this.
     * @param array $values Values passed to the function via func_get_args()
     * @return array An associative array of parameter names and their corresponding values
     */
    function func_get_named_args(array $values = []): array
    {
        $trace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 2)[1];

        $reflection = new ReflectionMethod($trace['class'], $trace['function']);

        $parameters = [];
        foreach ($reflection->getParameters() as $parameter) {
            $name = $parameter->getName();
            $position = $parameter->getPosition();
            $default = $parameter->isDefaultValueAvailable() ? $parameter->getDefaultValue() : null;

            $parameters[$name] = $values[$position] ?? $default;
        }

        return $parameters;
    }
}
