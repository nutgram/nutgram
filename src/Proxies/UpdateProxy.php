<?php


namespace SergiX44\Nutgram\Proxies;

use SergiX44\Nutgram\Telegram\Types\CallbackQuery;
use SergiX44\Nutgram\Telegram\Types\Chat;
use SergiX44\Nutgram\Telegram\Types\ChatMemberUpdated;
use SergiX44\Nutgram\Telegram\Types\ChosenInlineResult;
use SergiX44\Nutgram\Telegram\Types\InlineQuery;
use SergiX44\Nutgram\Telegram\Types\Message;
use SergiX44\Nutgram\Telegram\Types\Poll;
use SergiX44\Nutgram\Telegram\Types\PollAnswer;
use SergiX44\Nutgram\Telegram\Types\PreCheckoutQuery;
use SergiX44\Nutgram\Telegram\Types\ShippingQuery;
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
     * @return Update|null
     */
    public function update(): ?Update
    {
        return $this->update;
    }

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
     * @return bool
     */
    public function isCallbackQuery(): bool
    {
        return $this->update?->callback_query !== null;
    }

    /**
     * @return CallbackQuery|null
     */
    public function callbackQuery(): ?CallbackQuery
    {
        return $this->update?->callback_query;
    }

    /**
     * @return bool
     */
    public function isInlineQuery(): bool
    {
        return $this->update?->inline_query !== null;
    }

    /**
     * @return InlineQuery|null
     */
    public function inlineQuery(): ?InlineQuery
    {
        return $this->update?->inline_query;
    }

    /**
     * @return ChosenInlineResult|null
     */
    public function chosenInlineResult(): ?ChosenInlineResult
    {
        return $this->update?->chosen_inline_result;
    }

    /**
     * @return ShippingQuery|null
     */
    public function shippingQuery(): ?ShippingQuery
    {
        return $this->update?->shipping_query;
    }

    /**
     * @return bool
     */
    public function isPreCheckoutQuery(): bool
    {
        return $this->update?->pre_checkout_query !== null;
    }

    /**
     * @return PreCheckoutQuery|null
     */
    public function preCheckoutQuery(): ?PreCheckoutQuery
    {
        return $this->update?->pre_checkout_query;
    }

    /**
     * @return Poll|null
     */
    public function poll(): ?Poll
    {
        return $this->update?->poll;
    }

    /**
     * @return PollAnswer|null
     */
    public function pollAnswer(): ?PollAnswer
    {
        return $this->update?->poll_answer;
    }

    /**
     * @return bool
     */
    public function isMyChatMember(): bool
    {
        return $this->update?->my_chat_member !== null;
    }

    /**
     * @return ChatMemberUpdated|null
     */
    public function chatMember(): ?ChatMemberUpdated
    {
        return $this->update?->chat_member ?? $this->update?->my_chat_member;
    }
}
