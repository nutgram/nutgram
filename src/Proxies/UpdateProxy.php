<?php


namespace SergiX44\Nutgram\Proxies;

use SergiX44\Nutgram\Telegram\Types\Chat\Chat;
use SergiX44\Nutgram\Telegram\Types\Chat\ChatJoinRequest;
use SergiX44\Nutgram\Telegram\Types\Chat\ChatMemberUpdated;
use SergiX44\Nutgram\Telegram\Types\Common\Update;
use SergiX44\Nutgram\Telegram\Types\Inline\CallbackQuery;
use SergiX44\Nutgram\Telegram\Types\Inline\ChosenInlineResult;
use SergiX44\Nutgram\Telegram\Types\Inline\InlineQuery;
use SergiX44\Nutgram\Telegram\Types\Message\Message;
use SergiX44\Nutgram\Telegram\Types\Message\MessageEntity;
use SergiX44\Nutgram\Telegram\Types\Payment\PreCheckoutQuery;
use SergiX44\Nutgram\Telegram\Types\Payment\ShippingQuery;
use SergiX44\Nutgram\Telegram\Types\Poll\Poll;
use SergiX44\Nutgram\Telegram\Types\Poll\PollAnswer;
use SergiX44\Nutgram\Telegram\Types\User\User;

/**
 * Trait UpdateProxy
 * @package SergiX44\Nutgram\Proxies
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
        return $this->update?->getChat()?->bindToInstance($this);
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
        return $this->update?->getUser()?->bindToInstance($this);
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
        return $this->update?->getMessage()?->bindToInstance($this);
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
        return $this->update?->callback_query?->bindToInstance($this);
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
        return $this->update?->inline_query?->bindToInstance($this);
    }

    /**
     * @return ChosenInlineResult|null
     */
    public function chosenInlineResult(): ?ChosenInlineResult
    {
        return $this->update?->chosen_inline_result?->bindToInstance($this);
    }

    /**
     * @return ShippingQuery|null
     */
    public function shippingQuery(): ?ShippingQuery
    {
        return $this->update?->shipping_query?->bindToInstance($this);
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
        return $this->update?->pre_checkout_query?->bindToInstance($this);
    }

    /**
     * @return Poll|null
     */
    public function poll(): ?Poll
    {
        return $this->update?->poll?->bindToInstance($this);
    }

    /**
     * @return PollAnswer|null
     */
    public function pollAnswer(): ?PollAnswer
    {
        return $this->update?->poll_answer?->bindToInstance($this);
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
        return $this->update?->chat_member?->bindToInstance($this) ?? $this->update?->my_chat_member?->bindToInstance($this);
    }

    /**
     * @return ChatJoinRequest|null
     */
    public function chatJoinRequest(): ?ChatJoinRequest
    {
        return $this->update?->chat_join_request?->bindToInstance($this);
    }

    /**
     * @return string|null
     */
    public function inlineMessageId(): ?string
    {
        return $this->chosenInlineResult()?->inline_message_id ??
            $this->callbackQuery()?->inline_message_id;
    }

    /**
     * @return bool
     */
    public function isCommand(): bool
    {
        /** @var MessageEntity $entity */
        $entity = $this->update?->message?->entities[0] ?? null;

        return $entity !== null &&
            $entity->offset === 0 &&
            $entity->type === 'bot_command';
    }
}
