<?php

namespace SergiX44\Nutgram\Telegram\Types\Common;

use SergiX44\Nutgram\Telegram\Attributes\UpdateTypes;
use SergiX44\Nutgram\Telegram\Types\Channel\ChannelPost;
use SergiX44\Nutgram\Telegram\Types\Channel\EditedChannelPost;
use SergiX44\Nutgram\Telegram\Types\Chat\Chat;
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
class Update
{
    /**
     * The update‘s unique identifier.
     * Update identifiers start from a certain positive number and increase sequentially.
     * This ID becomes especially handy if you’re using {@see https://core.telegram.org/bots/api#setwebhook Webhooks},
     * since it allows you to ignore repeated updates or to restore the correct update sequence,
     * should they get out of order.
     * If there are no new updates for at least a week, then identifier of the next update
     * will be chosen randomly instead of sequentially.
     * @var int $update_id
     */
    public $update_id;

    /**
     * Optional. New incoming message of any kind — text, photo, sticker, etc.
     * @var Message $message
     */
    public $message;

    /**
     * Optional. New version of a message that is known to the bot and was edited
     * @var EditedMessage $edited_message
     */
    public $edited_message;

    /**
     * Optional. New incoming channel post of any kind — text, photo, sticker, etc.
     * @var ChannelPost $channel_post
     */
    public $channel_post;

    /**
     * Optional. New version of a channel post that is known to the bot and was edited
     * @var EditedChannelPost $edited_channel_post
     */
    public $edited_channel_post;

    /**
     * Optional. New incoming {@see https://core.telegram.org/bots/api#inline-mode inline} query
     * @var InlineQuery $inline_query
     */
    public $inline_query;

    /**
     * Optional. The result of an {@see https://core.telegram.org/bots/api#inline-mode inline} query that
     * was chosen by a user and sent to their chat partner.
     * Please see our documentation on the
     * {@see https://core.telegram.org/bots/inline#collecting-feedback feedback collecting} for details on
     * how to enable these updates for your bot.
     * @var ChosenInlineResult $chosen_inline_result
     */
    public $chosen_inline_result;

    /**
     * Optional. New incoming callback query
     * @var CallbackQuery $callback_query
     */
    public $callback_query;

    /**
     * Optional. New incoming shipping query. Only for invoices with flexible price
     * @var ShippingQuery $shipping_query
     */
    public $shipping_query;

    /**
     * Optional. New incoming pre-checkout query. Contains full information about checkout
     * @var PreCheckoutQuery $pre_checkout_query
     */
    public $pre_checkout_query;

    /**
     * Optional. New poll state. Bots receive only updates about stopped polls and polls, which are sent by the bot
     * @var Poll $poll
     */
    public $poll;

    /**
     * Optional. A user changed their answer in a non-anonymous poll.
     * Bots receive new votes only in polls that were sent by the bot itself.
     * @var PollAnswer $poll_answer
     */
    public $poll_answer;

    /**
     * Optional. The bot's chat member status was updated in a chat.
     * For private chats, this update is received only when the bot is blocked or unblocked by the user.
     * @var ChatMemberUpdated $my_chat_member
     */
    public $my_chat_member;

    /**
     * Optional. A chat member's status was updated in a chat. The bot must be an administrator in the chat and must
     * explicitly specify “chat_member” in the list of allowed_updates to receive these updates.
     * @var ChatMemberUpdated $chat_member
     */
    public $chat_member;

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
            $this->callback_query !== null => $this->callback_query?->message?->chat,
            $this->channel_post !== null => $this->channel_post?->chat,
            $this->edited_channel_post !== null => $this->edited_channel_post?->chat,
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
            $this->callback_query !== null => $this->callback_query?->message,
            $this->edited_message !== null => $this->edited_message,
            $this->channel_post !== null => $this->channel_post,
            $this->edited_channel_post !== null => $this->edited_channel_post,
            default => null
        };
    }
}
