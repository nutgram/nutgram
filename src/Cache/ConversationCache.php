<?php

namespace SergiX44\Nutgram\Cache;

use Closure;
use DateInterval;
use Laravel\SerializableClosure\Exceptions\PhpVersionNotSupportedException;
use Laravel\SerializableClosure\SerializableClosure;
use Psr\SimpleCache\CacheInterface;
use Psr\SimpleCache\InvalidArgumentException;
use SergiX44\Nutgram\Conversations\Conversation;

class ConversationCache extends BotCache
{
    protected const CONVERSATION_TTL = 43200;

    protected const CONVERSATION_PREFIX = 'CONVERSATION';

    /**
     * ConversationCache constructor.
     *
     * @param CacheInterface        $cache
     * @param int|null              $botId
     * @param DateInterval|int|null $ttl
     */
    public function __construct(CacheInterface $cache, ?int $botId, DateInterval|int|null $ttl = self::CONVERSATION_TTL)
    {
        parent::__construct($cache, self::CONVERSATION_PREFIX, $botId, $ttl);
    }

    /**
     * @param int $userId
     * @param int $chatId
     *
     * @throws InvalidArgumentException
     * @throws PhpVersionNotSupportedException
     *
     * @return callable|Conversation|null
     */
    public function get(int $userId, int $chatId): null|callable|Conversation
    {
        $data = $this->cache->get($this->makeKey($userId, $chatId));
        if ($data !== null) {
            $handler = unserialize($data);

            if ($handler instanceof SerializableClosure) {
                $handler = $handler->getClosure();
            }

            return $handler;
        }

        return null;
    }

    /**
     * @param int                                       $userId
     * @param int                                       $chatId
     * @param callable|Conversation|SerializableClosure $conversation
     *
     * @throws InvalidArgumentException
     * @throws PhpVersionNotSupportedException
     *
     * @return bool
     */
    public function set(int $userId, int $chatId, callable|Conversation|SerializableClosure $conversation): bool
    {
        if ($conversation instanceof Closure) {
            $conversation = new SerializableClosure($conversation);
        }

        $data = serialize($conversation);

        return $this->cache->set($this->makeKey($userId, $chatId), $data, $this->ttl);
    }

    /**
     * @param int $userId
     * @param int $chatId
     *
     * @throws InvalidArgumentException
     *
     * @return bool
     */
    public function delete(int $userId, int $chatId): bool
    {
        return $this->cache->delete($this->makeKey($userId, $chatId));
    }
}
