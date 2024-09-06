<?php

namespace SergiX44\Nutgram\Telegram\Types\Common;

use SergiX44\Nutgram\Telegram\Properties\ChatType;
use SergiX44\Nutgram\Telegram\Properties\UpdateType;
use SergiX44\Nutgram\Telegram\Types\BaseType;
use SergiX44\Nutgram\Telegram\Types\Boost\ChatBoostRemoved;
use SergiX44\Nutgram\Telegram\Types\Boost\ChatBoostUpdated;
use SergiX44\Nutgram\Telegram\Types\Business\BusinessConnection;
use SergiX44\Nutgram\Telegram\Types\Business\BusinessMessagesDeleted;
use SergiX44\Nutgram\Telegram\Types\Chat\Chat;
use SergiX44\Nutgram\Telegram\Types\Chat\ChatJoinRequest;
use SergiX44\Nutgram\Telegram\Types\Chat\ChatMemberUpdated;
use SergiX44\Nutgram\Telegram\Types\Inline\CallbackQuery;
use SergiX44\Nutgram\Telegram\Types\Inline\ChosenInlineResult;
use SergiX44\Nutgram\Telegram\Types\Inline\InlineQuery;
use SergiX44\Nutgram\Telegram\Types\Message\Message;
use SergiX44\Nutgram\Telegram\Types\Payment\PaidMediaPurchased;
use SergiX44\Nutgram\Telegram\Types\Payment\PreCheckoutQuery;
use SergiX44\Nutgram\Telegram\Types\Payment\ShippingQuery;
use SergiX44\Nutgram\Telegram\Types\Poll\Poll;
use SergiX44\Nutgram\Telegram\Types\Poll\PollAnswer;
use SergiX44\Nutgram\Telegram\Types\Reaction\MessageReactionCountUpdated;
use SergiX44\Nutgram\Telegram\Types\Reaction\MessageReactionUpdated;
use SergiX44\Nutgram\Telegram\Types\User\User;

/**
 * This {@see https://core.telegram.org/bots/api#available-types object} represents an incoming update.At most one of the optional parameters can be present in any given update.
 * @see https://core.telegram.org/bots/api#update
 */
class Update extends BaseType
{
    /**
     * The update's unique identifier.
     * Update identifiers start from a certain positive number and increase sequentially.
     * This ID becomes especially handy if you're using {@see https://core.telegram.org/bots/api#setwebhook webhooks}, since it allows you to ignore repeated updates or to restore the correct update sequence, should they get out of order.
     * If there are no new updates for at least a week, then identifier of the next update will be chosen randomly instead of sequentially.
     */
    public int $update_id;

    /**
     * Optional.
     * New incoming message of any kind - text, photo, sticker, etc.
     */
    public ?Message $message = null;

    /**
     * Optional.
     * New version of a message that is known to the bot and was edited
     */
    public ?Message $edited_message = null;

    /**
     * Optional.
     * New incoming channel post of any kind - text, photo, sticker, etc.
     */
    public ?Message $channel_post = null;

    /**
     * Optional.
     * New version of a channel post that is known to the bot and was edited
     */
    public ?Message $edited_channel_post = null;

    /**
     * Optional.
     * New non-service message from a connected business account
     */
    public ?BusinessConnection $business_connection = null;

    /**
     * Optional.
     * New non-service message from a connected business account
     */
    public ?Message $business_message = null;

    /**
     * Optional.
     * New version of a message from a connected business account
     */
    public ?Message $edited_business_message = null;

    /**
     * Optional.
     * Messages were deleted from a connected business account
     */
    public ?BusinessMessagesDeleted $deleted_business_messages = null;

    /**
     * Optional.
     * A reaction to a message was changed by a user.
     * The bot must be an administrator in the chat and must explicitly specify "message_reaction" in the list of allowed_updates to receive these updates.
     * The update isn't received for reactions set by bots.
     */
    public ?MessageReactionUpdated $message_reaction = null;

    /**
     * Optional.
     * Reactions to a message with anonymous reactions were changed.
     * The bot must be an administrator in the chat and must explicitly specify "message_reaction_count" in the list of allowed_updates to receive these updates.
     */
    public ?MessageReactionCountUpdated $message_reaction_count = null;

    /**
     * Optional.
     * New incoming {@see https://core.telegram.org/bots/api#inline-mode inline} query
     */
    public ?InlineQuery $inline_query = null;

    /**
     * Optional.
     * The result of an {@see https://core.telegram.org/bots/api#inline-mode inline} query that was chosen by a user and sent to their chat partner.
     * Please see our documentation on the {@see https://core.telegram.org/bots/inline#collecting-feedback feedback collecting} for details on how to enable these updates for your bot.
     */
    public ?ChosenInlineResult $chosen_inline_result = null;

    /**
     * Optional.
     * New incoming callback query
     */
    public ?CallbackQuery $callback_query = null;

    /**
     * Optional.
     * New incoming shipping query.
     * Only for invoices with flexible price
     */
    public ?ShippingQuery $shipping_query = null;

    /**
     * Optional.
     * New incoming pre-checkout query.
     * Contains full information about checkout
     */
    public ?PreCheckoutQuery $pre_checkout_query = null;

    /**
     * Optional.
     * A user purchased paid media with a non-empty payload sent by the bot in a non-channel chat
     */
    public ?PaidMediaPurchased $purchased_paid_media = null;

    /**
     * Optional.
     * New poll state.
     * Bots receive only updates about stopped polls and polls, which are sent by the bot
     */
    public ?Poll $poll = null;

    /**
     * Optional.
     * A user changed their answer in a non-anonymous poll.
     * Bots receive new votes only in polls that were sent by the bot itself.
     */
    public ?PollAnswer $poll_answer = null;

    /**
     * Optional.
     * The bot's chat member status was updated in a chat.
     * For private chats, this update is received only when the bot is blocked or unblocked by the user.
     */
    public ?ChatMemberUpdated $my_chat_member = null;

    /**
     * Optional.
     * A chat member's status was updated in a chat.
     * The bot must be an administrator in the chat and must explicitly specify “chat_member” in the list of allowed_updates to receive these updates.
     */
    public ?ChatMemberUpdated $chat_member = null;

    /**
     * Optional.
     * A request to join the chat has been sent.
     * The bot must have the can_invite_users administrator right in the chat to receive these updates.
     */
    public ?ChatJoinRequest $chat_join_request = null;

    /**
     * Optional.
     * A chat boost was added or changed.
     * The bot must be an administrator in the chat to receive these updates.
     */
    public ?ChatBoostUpdated $chat_boost = null;

    /**
     * Optional.
     * A boost was removed from a chat.
     * The bot must be an administrator in the chat to receive these updates.
     */
    public ?ChatBoostRemoved $removed_chat_boost = null;

    /**
     * Return the current update type
     * @return UpdateType|null
     */
    public function getType(): ?UpdateType
    {
        return match (true) {
            $this->message !== null => UpdateType::MESSAGE,
            $this->edited_message !== null => UpdateType::EDITED_MESSAGE,
            $this->channel_post !== null => UpdateType::CHANNEL_POST,
            $this->edited_channel_post !== null => UpdateType::EDITED_CHANNEL_POST,
            $this->business_connection !== null => UpdateType::BUSINESS_CONNECTION,
            $this->business_message !== null => UpdateType::BUSINESS_MESSAGE,
            $this->edited_business_message !== null => UpdateType::EDITED_BUSINESS_MESSAGE,
            $this->deleted_business_messages !== null => UpdateType::DELETED_BUSINESS_MESSAGES,
            $this->message_reaction !== null => UpdateType::MESSAGE_REACTION,
            $this->message_reaction_count !== null => UpdateType::MESSAGE_REACTION_COUNT,
            $this->inline_query !== null => UpdateType::INLINE_QUERY,
            $this->chosen_inline_result !== null => UpdateType::CHOSEN_INLINE_RESULT,
            $this->callback_query !== null => UpdateType::CALLBACK_QUERY,
            $this->shipping_query !== null => UpdateType::SHIPPING_QUERY,
            $this->pre_checkout_query !== null => UpdateType::PRE_CHECKOUT_QUERY,
            $this->purchased_paid_media !== null => UpdateType::PURCHASED_PAID_MEDIA,
            $this->poll !== null => UpdateType::POLL,
            $this->poll_answer !== null => UpdateType::POLL_ANSWER,
            $this->my_chat_member !== null => UpdateType::MY_CHAT_MEMBER,
            $this->chat_member !== null => UpdateType::CHAT_MEMBER,
            $this->chat_join_request !== null => UpdateType::CHAT_JOIN_REQUEST,
            $this->chat_boost !== null => UpdateType::CHAT_BOOST,
            $this->removed_chat_boost !== null => UpdateType::REMOVED_CHAT_BOOST,
            default => null
        };
    }

    /**
     * Get the sender User
     * @return User|null
     */
    public function getUser(): ?User
    {
        return match (true) {
            $this->message !== null => $this->message->from,
            $this->edited_message !== null => $this->edited_message->from,
            // channel_post: doesn't have a user
            // edited_channel_post: doesn't have a user
            $this->business_connection !== null => $this->business_connection->user,
            $this->business_message !== null => $this->business_message->from,
            $this->edited_business_message !== null => $this->edited_business_message->from,
            // deleted_business_messages: doesn't have a user
            $this->message_reaction !== null => $this->message_reaction->user,
            // message_reaction_count: doesn't have a user
            $this->inline_query !== null => $this->inline_query->from,
            $this->chosen_inline_result !== null => $this->chosen_inline_result->from,
            $this->callback_query !== null => $this->callback_query->from,
            $this->shipping_query !== null => $this->shipping_query->from,
            $this->pre_checkout_query !== null => $this->pre_checkout_query->from,
            $this->purchased_paid_media !== null => $this->purchased_paid_media->from,
            // poll: doesn't have a user
            $this->poll_answer !== null => $this->poll_answer->user,
            $this->my_chat_member !== null => $this->my_chat_member->from,
            $this->chat_member !== null => $this->chat_member->from,
            $this->chat_join_request !== null => $this->chat_join_request->from,
            $this->chat_boost !== null => $this->chat_boost->boost->source->user,
            $this->removed_chat_boost !== null => $this->removed_chat_boost->source->user,
            default => null,
        };
    }

    public function setUser(?User $user): ?User
    {
        return match (true) {
            $this->message !== null => $this->message->from = $user,
            $this->edited_message !== null => $this->edited_message->from = $user,
            // channel_post: doesn't have a user
            // edited_channel_post: doesn't have a user
            $this->business_connection !== null => $this->business_connection->user = $user,
            $this->business_message !== null => $this->business_message->from = $user,
            $this->edited_business_message !== null => $this->edited_business_message->from = $user,
            // deleted_business_messages: doesn't have a user
            $this->message_reaction !== null => $this->message_reaction->user = $user,
            // message_reaction_count: doesn't have a user
            $this->inline_query !== null => $this->inline_query->from = $user,
            $this->chosen_inline_result !== null => $this->chosen_inline_result->from = $user,
            $this->callback_query !== null => $this->callback_query->from = $user,
            $this->shipping_query !== null => $this->shipping_query->from = $user,
            $this->pre_checkout_query !== null => $this->pre_checkout_query->from = $user,
            $this->purchased_paid_media !== null => $this->purchased_paid_media->from = $user,
            // poll: doesn't have a user
            $this->poll_answer !== null => $this->poll_answer->user = $user,
            $this->my_chat_member !== null => $this->my_chat_member->from = $user,
            $this->chat_member !== null => $this->chat_member->from = $user,
            $this->chat_join_request !== null => $this->chat_join_request->from = $user,
            $this->chat_boost !== null => $this->chat_boost->boost->source->user = $user,
            $this->removed_chat_boost !== null => $this->removed_chat_boost->source->user = $user,
            default => null,
        };
    }

    public function getChat(): ?Chat
    {
        return match (true) {
            $this->message !== null => $this->message->chat,
            $this->edited_message !== null => $this->edited_message->chat,
            $this->channel_post !== null => $this->channel_post->chat,
            $this->edited_channel_post !== null => $this->edited_channel_post->chat,
            // business_connection doesn't have a chat
            $this->business_message !== null => $this->business_message->chat,
            $this->edited_business_message !== null => $this->edited_business_message->chat,
            $this->deleted_business_messages !== null => $this->deleted_business_messages->chat,
            $this->message_reaction !== null => $this->message_reaction->chat,
            $this->message_reaction_count !== null => $this->message_reaction_count->chat,
            // inline_query doesn't have a chat
            // chosen_inline_result doesn't have a chat
            $this->callback_query !== null => $this->callback_query->message?->chat,
            // shipping_query doesn't have a chat
            // pre_checkout_query doesn't have a chat
            // purchased_paid_media doesn't have a chat
            // poll doesn't have a chat
            $this->poll_answer !== null => Chat::make($this->poll_answer->user->id, ChatType::PRIVATE),
            $this->my_chat_member !== null => $this->my_chat_member->chat,
            $this->chat_member !== null => $this->chat_member->chat,
            $this->chat_join_request !== null => $this->chat_join_request->chat,
            $this->chat_boost !== null => $this->chat_boost->chat,
            $this->removed_chat_boost !== null => $this->removed_chat_boost->chat,
            default => null
        };
    }

    public function setChat(?Chat $chat): ?Chat
    {
        return match (true) {
            $this->message !== null => $this->message->chat = $chat,
            $this->edited_message !== null => $this->edited_message->chat = $chat,
            $this->channel_post !== null => $this->channel_post->chat = $chat,
            $this->edited_channel_post !== null => $this->edited_channel_post->chat = $chat,
            // business_connection doesn't have a chat
            $this->business_message !== null => $this->business_message->chat = $chat,
            $this->edited_business_message !== null => $this->edited_business_message->chat = $chat,
            $this->deleted_business_messages !== null => $this->deleted_business_messages->chat = $chat,
            $this->message_reaction !== null => $this->message_reaction->chat = $chat,
            $this->message_reaction_count !== null => $this->message_reaction_count->chat = $chat,
            // inline_query doesn't have a chat
            // chosen_inline_result doesn't have a chat
            $this->callback_query !== null => $this->callback_query->message !== null ? $this->callback_query->message->chat = $chat : null,
            // shipping_query doesn't have a chat
            // pre_checkout_query doesn't have a chat
            // purchased_paid_media doesn't have a chat
            // poll doesn't have a chat
            $this->poll_answer !== null => $chat,
            $this->my_chat_member !== null => $this->my_chat_member->chat = $chat,
            $this->chat_member !== null => $this->chat_member->chat = $chat,
            $this->chat_join_request !== null => $this->chat_join_request->chat = $chat,
            $this->chat_boost !== null => $this->chat_boost->chat = $chat,
            $this->removed_chat_boost !== null => $this->removed_chat_boost->chat = $chat,
            default => null
        };
    }

    public function getMessage(): ?Message
    {
        return match (true) {
            $this->message !== null => $this->message,
            $this->edited_message !== null => $this->edited_message,
            $this->channel_post !== null => $this->channel_post,
            $this->edited_channel_post !== null => $this->edited_channel_post,
            $this->business_message !== null => $this->business_message,
            $this->edited_business_message !== null => $this->edited_business_message,
            $this->callback_query !== null => $this->callback_query->message,
            default => null
        };
    }
}
