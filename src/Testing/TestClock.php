<?php

namespace SergiX44\Nutgram\Testing;

use DateInterval;
use DateTimeImmutable;
use InvalidArgumentException;
use Psr\Clock\ClockInterface;
use RuntimeException;
use Throwable;

class TestClock implements ClockInterface
{
    protected static DateTimeImmutable|null $testNow = null;

    public function now(): DateTimeImmutable
    {
        return self::getFreezedTime() ?? new DateTimeImmutable();
    }

    public static function isFreezed(): bool
    {
        return self::$testNow !== null;
    }

    public static function getFreezedTime(): DateTimeImmutable|null
    {
        return self::$testNow;
    }

    public static function freeze(DateTimeImmutable|string $datetime = 'now'): void
    {
        if (is_string($datetime)) {
            $datetime = new DateTimeImmutable($datetime);
        }

        self::$testNow = $datetime;
    }

    public static function unfreeze(): void
    {
        self::$testNow = null;
    }

    public static function sleep(int $seconds): void
    {
        if (!self::isFreezed()) {
            throw new RuntimeException('Cannot sleep when clock is not freezed');
        }

        self::freeze(self::getFreezedTime()->add(new DateInterval("PT{$seconds}S")));
    }

    public static function modify(string $modifier): void
    {
        if (!self::isFreezed()) {
            throw new RuntimeException('Cannot modify when clock is not freezed');
        }

        if (PHP_VERSION_ID < 80300) {
            $modified = @self::getFreezedTime()->modify($modifier) ?: throw new InvalidArgumentException(
                error_get_last()['message'] ?? sprintf('Invalid modifier: "%s". Could not modify MockClock.', $modifier)
            );

            self::freeze($modified);
            return;
        }

        try {
            self::freeze(self::getFreezedTime()->modify($modifier));
        } catch (Throwable $e) {
            throw new InvalidArgumentException($e->getMessage(), $e->getCode(), $e);
        }
    }
}
