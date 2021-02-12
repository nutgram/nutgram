<?php

namespace SergiX44\Nutgram\Telegram\Types;

use SergiX44\Nutgram\Telegram\Attributes\UpdateTypes;

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
     * @var int
     */
    public int $update_id;

    /**
     * Optional. New incoming message of any kind — text, photo, sticker, etc.
     * @var Message
     */
    public Message $message;

    /**
     * Optional. New version of a message that is known to the bot and was edited
     * @var Message
     */
    public Message $edited_message;

    /**
     * Optional. New incoming channel post of any kind — text, photo, sticker, etc.
     * @var Message
     */
    public Message $channel_post;

    /**
     * Optional. New version of a channel post that is known to the bot and was edited
     * @var Message
     */
    public Message $edited_channel_post;

    /**
     * Optional. New incoming {@see https://core.telegram.org/bots/api#inline-mode inline} query
     * @var InlineQuery
     */
    public InlineQuery $inline_query;

    /**
     * Optional. The result of an {@see https://core.telegram.org/bots/api#inline-mode inline} query that
     * was chosen by a user and sent to their chat partner.
     * Please see our documentation on the
     * {@see https://core.telegram.org/bots/inline#collecting-feedback feedback collecting} for details on
     * how to enable these updates for your bot.
     * @var ChosenInlineResult
     */
    public ChosenInlineResult $chosen_inline_result;

    /**
     * Optional. New incoming callback query
     * @var CallbackQuery
     */
    public CallbackQuery $callback_query;

    /**
     * Optional. New incoming shipping query. Only for invoices with flexible price
     * @var ShippingQuery
     */
    public ShippingQuery $shipping_query;

    /**
     * Optional. New incoming pre-checkout query. Contains full information about checkout
     * @var PreCheckoutQuery
     */
    public PreCheckoutQuery $pre_checkout_query;

    /**
     * Optional. New poll state. Bots receive only updates about stopped polls and polls, which are sent by the bot
     * @var Poll
     */
    public Poll $poll;

    /**
     * Optional. A user changed their answer in a non-anonymous poll.
     * Bots receive new votes only in polls that were sent by the bot itself.
     * @var PollAnswer
     */
    public PollAnswer $poll_answer;

    /**
     * Return the current update type
     * @return string|null
     */
    public function getType(): ?string
    {
        if ($this->message !== null) {
            return UpdateTypes::MESSAGE;
        }

        if ($this->edited_message !== null) {
            return UpdateTypes::EDITED_MESSAGE;
        }

        if ($this->channel_post !== null) {
            return UpdateTypes::CHANNEL_POST;
        }

        if ($this->edited_channel_post !== null) {
            return UpdateTypes::EDITED_CHANNEL_POST;
        }

        if ($this->inline_query !== null) {
            return UpdateTypes::INLINE_QUERY;
        }

        if ($this->chosen_inline_result !== null) {
            return UpdateTypes::CHOSEN_INLINE_RESULT;
        }

        if ($this->callback_query !== null) {
            return UpdateTypes::CALLBACK_QUERY;
        }

        if ($this->shipping_query !== null) {
            return UpdateTypes::SHIPPING_QUERY;
        }

        if ($this->pre_checkout_query !== null) {
            return UpdateTypes::PRE_CHECKOUT_QUERY;
        }

        if ($this->poll !== null) {
            return UpdateTypes::POLL;
        }

        if ($this->poll_answer !== null) {
            return UpdateTypes::POLL_ANSWER;
        }

        return null;
    }

    /**
     * Get the sender User
     * @return User|null
     */
    public function getUser(): ?User
    {
        if ($this->message !== null) {
            return $this->message->from ?? null;
        }

        if ($this->edited_message !== null) {
            return $this->edited_message->from ?? null;
        }

        if ($this->channel_post !== null) {
            return $this->channel_post->from ?? null;
        }

        if ($this->edited_channel_post !== null) {
            return $this->edited_channel_post->from ?? null;
        }

        if ($this->inline_query !== null) {
            return $this->inline_query->from;
        }

        if ($this->chosen_inline_result !== null) {
            return $this->chosen_inline_result->from;
        }

        if ($this->callback_query !== null) {
            return $this->callback_query->from;
        }

        if ($this->shipping_query !== null) {
            return $this->shipping_query->from;
        }

        if ($this->pre_checkout_query !== null) {
            return $this->pre_checkout_query->from;
        }

        if ($this->poll_answer !== null) {
            return $this->poll_answer->user;
        }

        return null;
    }

    /**
     * @return int|null
     */
    public function getChatId(): ?int
    {
        if ($this->message !== null) {
            return $this->message->chat->id;
        }

        if ($this->callback_query !== null) {
            return $this->callback_query->message->chat->id;
        }

        // TODO: add more
        return null;
    }
}
