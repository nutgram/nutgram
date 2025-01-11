<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Cache;

use DateInterval;
use Psr\SimpleCache\CacheInterface;

abstract class BotCache
{
    public function __construct(
        protected CacheInterface $cache,
        private string $key,
        private int $botId,
        protected DateInterval|int|null $ttl = null,
    ) {
    }

    /**
     * @return string
     */
    protected function makeKey(): string
    {
        return implode('_', [$this->key, $this->botId, ...func_get_args()]);
    }
}
