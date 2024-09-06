<?php


namespace SergiX44\Nutgram\Proxies;

use SergiX44\Nutgram\Telegram\Properties\MessageEntityType;
use SergiX44\Nutgram\Telegram\Types\Boost\ChatBoostRemoved;
use SergiX44\Nutgram\Telegram\Types\Boost\ChatBoostUpdated;
use SergiX44\Nutgram\Telegram\Types\Business\BusinessConnection;
use SergiX44\Nutgram\Telegram\Types\Business\BusinessMessagesDeleted;
use SergiX44\Nutgram\Telegram\Types\Chat\Chat;
use SergiX44\Nutgram\Telegram\Types\Chat\ChatJoinRequest;
use SergiX44\Nutgram\Telegram\Types\Chat\ChatMemberUpdated;
use SergiX44\Nutgram\Telegram\Types\Common\Update;
use SergiX44\Nutgram\Telegram\Types\Inline\CallbackQuery;
use SergiX44\Nutgram\Telegram\Types\Inline\ChosenInlineResult;
use SergiX44\Nutgram\Telegram\Types\Inline\InlineQuery;
use SergiX44\Nutgram\Telegram\Types\Message\Message;
use SergiX44\Nutgram\Telegram\Types\Message\MessageEntity;
use SergiX44\Nutgram\Telegram\Types\Payment\PaidMediaPurchased;
use SergiX44\Nutgram\Telegram\Types\Payment\PreCheckoutQuery;
use SergiX44\Nutgram\Telegram\Types\Payment\ShippingQuery;
use SergiX44\Nutgram\Telegram\Types\Poll\Poll;
use SergiX44\Nutgram\Telegram\Types\Poll\PollAnswer;
use SergiX44\Nutgram\Telegram\Types\Reaction\MessageReactionCountUpdated;
use SergiX44\Nutgram\Telegram\Types\Reaction\MessageReactionUpdated;
use SergiX44\Nutgram\Telegram\Types\User\User;

/**
 * Trait UpdateProxy
 * @package SergiX44\Nutgram\Proxies
 */
trait UpdateProxy
{
    /*
    |--------------------------------------------------------------------------
    | ID proxies
    |--------------------------------------------------------------------------
    */

    public function userId(): ?int
    {
        return $this->update?->getUser()?->id;
    }

    public function chatId(): ?int
    {
        return $this->update?->getChat()?->id;
    }

    public function updateId(): ?int
    {
        return $this->update?->update_id;
    }

    public function messageId(): ?int
    {
        return $this->message()?->message_id;
    }

    public function messageThreadId(): ?int
    {
        if ($this->message()?->is_topic_message) {
            return $this->message()?->message_thread_id;
        }

        return null;
    }

    public function businessConnectionId(): ?string
    {
        return $this->message()?->business_connection_id ?? $this->businessConnection()?->id;
    }

    public function inlineMessageId(): ?string
    {
        return $this->chosenInlineResult()?->inline_message_id ?? $this->callbackQuery()?->inline_message_id;
    }

    /*
    |--------------------------------------------------------------------------
    | Special proxies
    |--------------------------------------------------------------------------
    */

    public function update(): ?Update
    {
        return $this->update;
    }

    public function user(): ?User
    {
        return $this->update?->getUser();
    }

    public function chat(): ?Chat
    {
        return $this->update?->getChat();
    }

    /*
    |--------------------------------------------------------------------------
    | Check proxies
    |--------------------------------------------------------------------------
    */

    public function isCommand(): bool
    {
        /** @var MessageEntity $entity */
        $entity = $this->update?->message?->entities[0] ?? null;

        return $entity !== null &&
            $entity->offset === 0 &&
            $entity->type === MessageEntityType::BOT_COMMAND;
    }

    public function isInlineQuery(): bool
    {
        return $this->update?->inline_query !== null;
    }

    public function isCallbackQuery(): bool
    {
        return $this->update?->callback_query !== null;
    }

    public function isPreCheckoutQuery(): bool
    {
        return $this->update?->pre_checkout_query !== null;
    }

    public function isMyChatMember(): bool
    {
        return $this->update?->my_chat_member !== null;
    }

    /*
    |--------------------------------------------------------------------------
    | Update proxies
    |--------------------------------------------------------------------------
    */

    public function message(): ?Message
    {
        return $this->update?->getMessage();
    }

    public function messageReaction(): ?MessageReactionUpdated
    {
        return $this->update?->message_reaction;
    }

    public function messageReactionCount(): ?MessageReactionCountUpdated
    {
        return $this->update?->message_reaction_count;
    }

    public function businessConnection(): ?BusinessConnection
    {
        return $this->update?->business_connection;
    }

    public function deletedBusinessMessages(): ?BusinessMessagesDeleted
    {
        return $this->update?->deleted_business_messages;
    }

    public function inlineQuery(): ?InlineQuery
    {
        return $this->update?->inline_query;
    }

    public function chosenInlineResult(): ?ChosenInlineResult
    {
        return $this->update?->chosen_inline_result;
    }

    public function callbackQuery(): ?CallbackQuery
    {
        return $this->update?->callback_query;
    }

    public function shippingQuery(): ?ShippingQuery
    {
        return $this->update?->shipping_query;
    }

    public function preCheckoutQuery(): ?PreCheckoutQuery
    {
        return $this->update?->pre_checkout_query;
    }

    public function purchasedPaidMedia(): ?PaidMediaPurchased
    {
        return $this->update?->purchased_paid_media;
    }

    public function poll(): ?Poll
    {
        return $this->update?->poll;
    }

    public function pollAnswer(): ?PollAnswer
    {
        return $this->update?->poll_answer;
    }

    public function chatMember(): ?ChatMemberUpdated
    {
        return $this->update?->chat_member ?? $this->update?->my_chat_member;
    }

    public function chatJoinRequest(): ?ChatJoinRequest
    {
        return $this->update?->chat_join_request;
    }

    public function chatBoost(): ?ChatBoostUpdated
    {
        return $this->update?->chat_boost;
    }

    public function removedChatBoost(): ?ChatBoostRemoved
    {
        return $this->update?->removed_chat_boost;
    }
}
