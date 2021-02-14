<?php


namespace SergiX44\Nutgram\Cache;

use Closure;
use Opis\Closure\SerializableClosure;
use Psr\SimpleCache\CacheInterface;
use SergiX44\Nutgram\Conversation;

class ConversationCache extends BotCache
{
    protected const CONVERSATION_TTL = 43200;

    protected const CONVERSATION_PREFIX = 'CONVERSATION';

    public function __construct(CacheInterface $cache, $ttl = self::CONVERSATION_TTL)
    {
        parent::__construct($cache, self::CONVERSATION_PREFIX, $ttl);
    }

    /**
     * @param $userId
     * @param $chatId
     * @return Conversation|null
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function get(int $userId, int $chatId): ?Conversation
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
     * @param  Conversation|callable  $conversation
     * @return bool
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function set(int $userId, int $chatId, $conversation): bool
    {
        if ($conversation instanceof Closure) {
            $conversation = new SerializableClosure($conversation);
        }

        $data = serialize($conversation);

        return $this->cache->set($this->makeKey($userId, $chatId), $data, $this->ttl);
    }

    /**
     * @param $userId
     * @param $chatId
     * @return bool
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function delete(int $userId, int $chatId): bool
    {
        return $this->cache->delete($this->makeKey($userId, $chatId));
    }
}
