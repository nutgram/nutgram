<?php


namespace SergiX44\Nutgram\Handlers;

/**
 * Trait ResolveUpdateIds
 * @package SergiX44\Nutgram\Handlers
 * @mixin ResolveHandlers
 */
trait ResolveIds
{
    /**
     * @return int|null
     */
    public function getChatId(): ?int
    {
        return $this->update?->getChat()?->id;
    }

    /**
     * @return int|null
     */
    public function getUserId(): ?int
    {
        return $this->update?->getUser()?->id;
    }

}
