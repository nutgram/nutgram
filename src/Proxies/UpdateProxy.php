<?php


namespace SergiX44\Nutgram\Proxies;

use SergiX44\Nutgram\Telegram\Types\CallbackQuery;
use SergiX44\Nutgram\Telegram\Types\Chat;
use SergiX44\Nutgram\Telegram\Types\InlineQuery;
use SergiX44\Nutgram\Telegram\Types\Message;
use SergiX44\Nutgram\Telegram\Types\Update;
use SergiX44\Nutgram\Telegram\Types\User;

/**
 * Trait UpdateProxy
 * @package SergiX44\Nutgram\Proxies
 * @property Update $update
 */
trait UpdateProxy
{
    /**
     * @return int|null
     */
    public function chatId(): ?int
    {
        return $this->update?->getChat()?->id;
    }

    /**
     * @return Chat|null
     */
    public function chat(): ?Chat
    {
        return $this->update?->getChat();
    }

    /**
     * @return int|null
     */
    public function userId(): ?int
    {
        return $this->update?->getUser()?->id;
    }

    /**
     * @return User|null
     */
    public function user(): ?User
    {
        return $this->update?->getUser();
    }

    /**
     * @return int|null
     */
    public function messageId(): ?int
    {
        return $this->update?->getMessage()?->message_id;
    }

    /**
     * @return Message|null
     */
    public function message(): ?Message
    {
        return $this->update?->getMessage();
    }

    /**
     * @return CallbackQuery|null
     */
    public function callbackQuery(): ?CallbackQuery
    {
        return $this->update?->callback_query;
    }

    /**
     * @return InlineQuery|null
     */
    public function inlineQuery(): ?InlineQuery
    {
        return $this->update?->inline_query;
    }
}
