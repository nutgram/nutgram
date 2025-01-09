<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Tests\Fixtures\Cache;

use DateTimeImmutable;
use SergiX44\Nutgram\Cache\Adapters\ArrayCache;

class TestCache extends ArrayCache
{
    protected static DateTimeImmutable|null $testNow = null;

    public static function hasTestNow(): bool
    {
        return self::$testNow !== null;
    }

    public static function setTestNow(DateTimeImmutable $now): void
    {
        self::$testNow = $now;
    }

    public static function getTestNow(): DateTimeImmutable|null
    {
        return self::$testNow;
    }

    protected function getNow(): DateTimeImmutable
    {
        return self::getTestNow() ?? new DateTimeImmutable();
    }
}
