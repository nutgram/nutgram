<?php


namespace SergiX44\Nutgram\Proxies;

use SergiX44\Nutgram\Telegram\Types\CallbackQuery;
use SergiX44\Nutgram\Telegram\Types\Message;
use SergiX44\Nutgram\Telegram\Types\Update;

/**
 * Trait UpdateProxy
 * @package SergiX44\Nutgram\Proxies
 */
trait UpdateProxy
{
    /**
     * @return Update|null
     */
    public function getUpdate(): ?Update
    {
        return $this->update;
    }

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

    /**
     * @return Message|null
     */
    public function getMessage(): ?Message
    {
        return $this->update?->getMessage();
    }

    /**
     * @return CallbackQuery|null
     */
    public function getCallBackQuery(): ?CallbackQuery
    {
        return $this->update?->callback_query;
    }
}
