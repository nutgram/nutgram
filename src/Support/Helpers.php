<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Support;

use BackedEnum;
use InvalidArgumentException;

function array_filter_null(array $array): array
{
    return array_filter($array, static fn ($value) => $value !== null);
}

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

function deep_link(?string $baseUrl = null): DeepLink
{
    return new DeepLink($baseUrl);
}

/**
 * Resolve the value of a BackedEnum or return the value as is if it's not an enum.
 * @internal
 */
function get_value(mixed $value): mixed
{
    return $value instanceof BackedEnum ? (string)$value->value : $value;
}
