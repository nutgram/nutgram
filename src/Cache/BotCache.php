<?php


namespace SergiX44\Nutgram\Cache;

use Psr\SimpleCache\CacheInterface;

abstract class BotCache
{
    /**
     * @var CacheInterface
     */
    protected CacheInterface $cache;

    /**
     * @var int|null
     */
    protected ?int $ttl;

    /**
     * @var string
     */
    private string $key;

    /**
     * @var int|null
     */
    private ?int $botId;

    public function __construct(CacheInterface $cache, string $key, ?int $botId, ?int $ttl = null)
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
        if ($this->botId !== null) {
            return implode('_', [$this->key, $this->botId, ...func_get_args()]);
        }
        return implode('_', [$this->key, ...func_get_args()]);
    }
}
