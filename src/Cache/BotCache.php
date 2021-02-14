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

    public function __construct(CacheInterface $cache, string $key, ?int $ttl = null)
    {
        $this->cache = $cache;
        $this->ttl = $ttl;
        $this->key = $key;
    }

    /**
     * @return string
     */
    protected function makeKey(): string
    {
        return implode('_', [$this->key, ...func_get_args()]);
    }

}