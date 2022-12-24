<?php

namespace SergiX44\Nutgram\Telegram\Types\Common;

use SergiX44\Nutgram\Telegram\Attributes\UpdateTypes;
use SergiX44\Nutgram\Telegram\Types\BaseType;
use SergiX44\Nutgram\Telegram\Types\Channel\ChannelPost;
use SergiX44\Nutgram\Telegram\Types\Channel\EditedChannelPost;
use SergiX44\Nutgram\Telegram\Types\Chat\Chat;
use SergiX44\Nutgram\Telegram\Types\Chat\ChatJoinRequest;
use SergiX44\Nutgram\Telegram\Types\Chat\ChatMemberUpdated;
use SergiX44\Nutgram\Telegram\Types\Inline\CallbackQuery;
use SergiX44\Nutgram\Telegram\Types\Inline\ChosenInlineResult;
use SergiX44\Nutgram\Telegram\Types\Inline\InlineQuery;
use SergiX44\Nutgram\Telegram\Types\Message\EditedMessage;
use SergiX44\Nutgram\Telegram\Types\Message\Message;
use SergiX44\Nutgram\Telegram\Types\Payment\PreCheckoutQuery;
use SergiX44\Nutgram\Telegram\Types\Payment\ShippingQuery;
use SergiX44\Nutgram\Telegram\Types\Poll\Poll;
use SergiX44\Nutgram\Telegram\Types\Poll\PollAnswer;
use SergiX44\Nutgram\Telegram\Types\User\User;

/**
 * This {@see https://core.telegram.org/bots/api#available-types object} represents an incoming update.
 * At most ONE of the optional parameters can be present in any given update.
 * @see https://core.telegram.org/bots/api#update
 */
class Update extends BaseType
{
    /**
     * The update‘s unique identifier.
     * Update identifiers start from a certain positive number and increase sequentially.
     * This ID becomes especially handy if you’re using {@see https://core.telegram.org/bots/api#setwebhook Webhooks},
     * since it allows you to ignore repeated updates or to restore the correct update sequence,
     * should they get out of order.
     * If there are no new updates for at least a week, then identifier of the next update
     * will be chosen randomly instead of sequentially.
     */
    public int $update_id;

    /**
     * Optional. New incoming message of any kind — text, photo, sticker, etc.
     */
    public ?Message $message = null;

    /**
     * Optional. New version of a message that is known to the bot and was edited
     */
    public ?EditedMessage $edited_message = null;

    /**
     * Optional. New incoming channel post of any kind — text, photo, sticker, etc.
     */
    public ?ChannelPost $channel_post = null;

    /**
     * Optional. New version of a channel post that is known to the bot and was edited
     */
    public ?EditedChannelPost $edited_channel_post = null;

    /**
     * Optional. New incoming {@see https://core.telegram.org/bots/api#inline-mode inline} query
     */
    public ?InlineQuery $inline_query = null;

    /**
     * Optional. The result of an {@see https://core.telegram.org/bots/api#inline-mode inline} query that
     * was chosen by a user and sent to their chat partner.
     * Please see our documentation on the
     * {@see https://core.telegram.org/bots/inline#collecting-feedback feedback collecting} for details on
     * how to enable these updates for your bot.
     */
    public ?ChosenInlineResult $chosen_inline_result = null;

    /**
     * Optional. New incoming callback query
     */
    public ?CallbackQuery $callback_query = null;

    /**
     * Optional. New incoming shipping query. Only for invoices with flexible price
     */
    public ?ShippingQuery $shipping_query = null;

    /**
     * Optional. New incoming pre-checkout query. Contains full information about checkout
     */
    public ?PreCheckoutQuery $pre_checkout_query = null;

    /**
     * Optional. New poll state. Bots receive only updates about stopped polls and polls, which are sent by the bot
     */
    public ?Poll $poll = null;

    /**
     * Optional. A user changed their answer in a non-anonymous poll.
     * Bots receive new votes only in polls that were sent by the bot itself.
     */
    public ?PollAnswer $poll_answer = null;

    /**
     * Optional. The bot's chat member status was updated in a chat.
     * For private chats, this update is received only when the bot is blocked or unblocked by the user.
     */
    public ?ChatMemberUpdated $my_chat_member = null;

    /**
     * Optional. A chat member's status was updated in a chat. The bot must be an administrator in the chat and must
     * explicitly specify “chat_member” in the list of allowed_updates to receive these updates.
     */
    public ?ChatMemberUpdated $chat_member = null;

    /**
     * Optional. A request to join the chat has been sent.
     * The bot must have the can_invite_users administrator right in the chat to receive these updates.
     */
    public ?ChatJoinRequest $chat_join_request = null;

    /**
     * Return the current update type
     * @return string|null
     */
    public function getType(): ?string
    {
        return match (true) {
            $this->message !== null => UpdateTypes::MESSAGE,
            $this->edited_message !== null => UpdateTypes::EDITED_MESSAGE,
            $this->channel_post !== null => UpdateTypes::CHANNEL_POST,
            $this->edited_channel_post !== null => UpdateTypes::EDITED_CHANNEL_POST,
            $this->inline_query !== null => UpdateTypes::INLINE_QUERY,
            $this->chosen_inline_result !== null => UpdateTypes::CHOSEN_INLINE_RESULT,
            $this->callback_query !== null => UpdateTypes::CALLBACK_QUERY,
            $this->shipping_query !== null => UpdateTypes::SHIPPING_QUERY,
            $this->pre_checkout_query !== null => UpdateTypes::PRE_CHECKOUT_QUERY,
            $this->poll !== null => UpdateTypes::POLL,
            $this->poll_answer !== null => UpdateTypes::POLL_ANSWER,
            $this->my_chat_member !== null => UpdateTypes::MY_CHAT_MEMBER,
            $this->chat_member !== null => UpdateTypes::CHAT_MEMBER,
            $this->chat_join_request !== null => UpdateTypes::CHAT_JOIN_REQUEST,
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
            $this->channel_post !== null => $this->channel_post->from,
            $this->edited_channel_post !== null => $this->edited_channel_post->from,
            $this->inline_query !== null => $this->inline_query->from,
            $this->chosen_inline_result !== null => $this->chosen_inline_result->from,
            $this->callback_query !== null => $this->callback_query->from,
            $this->shipping_query !== null => $this->shipping_query->from,
            $this->pre_checkout_query !== null => $this->pre_checkout_query->from,
            $this->poll_answer !== null => $this->poll_answer->user,
            $this->my_chat_member !== null => $this->my_chat_member->from,
            $this->chat_member !== null => $this->chat_member->from,
            $this->chat_join_request !== null => $this->chat_join_request->from,
            default => null,
        };
    }

    /**
     * @return User|null
     */
    public function setUser(?User $user): ?User
    {
        return match (true) {
            $this->message !== null => $this->message->from = $user,
            $this->edited_message !== null => $this->edited_message->from = $user,
            $this->channel_post !== null => $this->channel_post->from = $user,
            $this->edited_channel_post !== null => $this->edited_channel_post->from = $user,
            $this->inline_query !== null => $this->inline_query->from = $user,
            $this->chosen_inline_result !== null => $this->chosen_inline_result->from = $user,
            $this->callback_query !== null => $this->callback_query->from = $user,
            $this->shipping_query !== null => $this->shipping_query->from = $user,
            $this->pre_checkout_query !== null => $this->pre_checkout_query->from = $user,
            $this->poll_answer !== null => $this->poll_answer->user = $user,
            $this->my_chat_member !== null => $this->my_chat_member->from = $user,
            $this->chat_member !== null => $this->chat_member->from = $user,
            $this->chat_join_request !== null => $this->chat_join_request->from = $user,
            default => null,
        };
    }

    /**
     * @return Chat|null
     */
    public function getChat(): ?Chat
    {
        return match (true) {
            $this->message !== null => $this->message->chat,
            $this->edited_message !== null => $this->edited_message->chat,
            $this->channel_post !== null => $this->channel_post->chat,
            $this->edited_channel_post !== null => $this->edited_channel_post->chat,
            $this->callback_query !== null => $this->callback_query->message?->chat,
            $this->my_chat_member !== null => $this->my_chat_member->chat,
            $this->chat_member !== null => $this->chat_member->chat,
            $this->chat_join_request !== null => $this->chat_join_request->chat,
            default => null
        };
    }

    /**
     * @param  Chat|null  $chat
     * @return Chat|null
     */
    public function setChat(?Chat $chat): ?Chat
    {
        return match (true) {
            $this->message !== null => $this->message->chat = $chat,
            $this->edited_message !== null => $this->edited_message->chat = $chat,
            $this->channel_post !== null => $this->channel_post->chat = $chat,
            $this->edited_channel_post !== null => $this->edited_channel_post->chat = $chat,
            $this->callback_query !== null => $this->callback_query->message !== null ? $this->callback_query->message->chat = $chat : null,
            $this->my_chat_member !== null => $this->my_chat_member->chat = $chat,
            $this->chat_member !== null => $this->chat_member->chat = $chat,
            $this->chat_join_request !== null => $this->chat_join_request->chat = $chat,
            default => null
        };
    }

    /**
     * @return Message|null
     */
    public function getMessage(): ?Message
    {
        return match (true) {
            $this->message !== null => $this->message,
            $this->edited_message !== null => $this->edited_message,
            $this->channel_post !== null => $this->channel_post,
            $this->edited_channel_post !== null => $this->edited_channel_post,
            $this->callback_query !== null => $this->callback_query->message,
            default => null
        };
    }
}
