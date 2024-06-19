<?php


namespace SergiX44\Nutgram\Cache;

use Closure;
use DateInterval;
use Laravel\SerializableClosure\Exceptions\PhpVersionNotSupportedException;
use Laravel\SerializableClosure\SerializableClosure;
use Psr\SimpleCache\CacheInterface;
use Psr\SimpleCache\InvalidArgumentException;
use SergiX44\Nutgram\Configuration;
use SergiX44\Nutgram\Conversations\Conversation;

class ConversationCache extends BotCache
{
    protected const CONVERSATION_PREFIX = 'CONVERSATION';

    /**
     * ConversationCache constructor.
     * @param  CacheInterface  $cache
     * @param  int|null  $botId
     * @param  DateInterval|int|null  $ttl
     */
    public function __construct(CacheInterface $cache, ?int $botId, DateInterval|int|null $ttl = null)
    {
        parent::__construct($cache, self::CONVERSATION_PREFIX, $botId, $ttl);
    }

    /**
     * @param  int  $userId
     * @param  int  $chatId
     * @return callable|Conversation|null
     * @throws InvalidArgumentException
     * @throws PhpVersionNotSupportedException
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
     * @param  int  $userId
     * @param  int  $chatId
     * @param  callable|Conversation|SerializableClosure  $conversation
     * @return bool
     * @throws InvalidArgumentException
     * @throws PhpVersionNotSupportedException
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
     * @param  int  $userId
     * @param  int  $chatId
     * @return bool
     * @throws InvalidArgumentException
     */
    public function delete(int $userId, int $chatId): bool
    {
        return $this->cache->delete($this->makeKey($userId, $chatId));
    }
}
