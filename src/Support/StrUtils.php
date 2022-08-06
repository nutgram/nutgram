<?php

namespace SergiX44\Nutgram\Support;

use InvalidArgumentException;

class StrUtils
{
    /**
     * @param  string  $string
     * @param  int  $width
     * @param  string  $break
     * @param  bool  $cut
     * @return string
     */
    public static function wordWrap(string $string, int $width = 75, string $break = "\n", bool $cut = false): string
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

        $stringWidth = grapheme_strlen($string);
        $breakWidth = grapheme_strlen($break);

        $result = '';
        $lastStart = $lastSpace = 0;

        for ($current = 0; $current < $stringWidth; $current++) {
            $char = grapheme_substr($string, $current, 1);

            $possibleBreak = $char;
            if ($breakWidth !== 1) {
                $possibleBreak = grapheme_substr($string, $current, $breakWidth);
            }

            if ($possibleBreak === $break) {
                $result .= grapheme_substr($string, $lastStart, $current - $lastStart + $breakWidth);
                $current += $breakWidth - 1;
                $lastStart = $lastSpace = $current + 1;
                continue;
            }

            if ($char === ' ') {
                if ($current - $lastStart >= $width) {
                    $result .= grapheme_substr($string, $lastStart, $current - $lastStart).$break;
                    $lastStart = $current + 1;
                }

                $lastSpace = $current;
                continue;
            }

            if ($current - $lastStart >= $width && $cut && $lastStart >= $lastSpace) {
                $result .= grapheme_substr($string, $lastStart, $current - $lastStart).$break;
                $lastStart = $lastSpace = $current;
                continue;
            }

            if ($current - $lastStart >= $width && $lastStart < $lastSpace) {
                $result .= grapheme_substr($string, $lastStart, $lastSpace - $lastStart).$break;
                $lastStart = ++$lastSpace;
            }
        }

        if ($lastStart !== $current) {
            $result .= grapheme_substr($string, $lastStart, $current - $lastStart);
        }

        return $result;
    }
}
