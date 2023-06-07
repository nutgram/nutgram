<?php


namespace SergiX44\Nutgram\Cache;

use DateInterval;
use Psr\SimpleCache\CacheInterface;

abstract class BotCache
{
    /**
     * @var CacheInterface
     */
    protected CacheInterface $cache;

    protected DateInterval|int|null $ttl;

    /**
     * @var string
     */
    private string $key;

    /**
     * @var int|null
     */
    private ?int $botId;

    public function __construct(CacheInterface $cache, string $key, int $botId, DateInterval|int|null $ttl = null)
    {
        $this->cache = $cache;
        $this->ttl = $ttl;
        $this->key = $key;
        $this->botId = $botId;
    }

    /**
     * @return string
     */
    protected function makeKey(): string
    {
        return implode('_', [$this->key, $this->botId, ...func_get_args()]);
    }
}
