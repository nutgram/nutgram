<?php

namespace SergiX44\Nutgram\Telegram\Attributes;

use ReflectionClass;
use SergiX44\Nutgram\Telegram\Types\Channel\ChannelPost;
use SergiX44\Nutgram\Telegram\Types\Channel\EditedChannelPost;
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

class UpdateTypes
{
    public const MESSAGE = 'message';
    public const EDITED_MESSAGE = 'edited_message';
    public const CHANNEL_POST = 'channel_post';
    public const EDITED_CHANNEL_POST = 'edited_channel_post';
    public const INLINE_QUERY = 'inline_query';
    public const CHOSEN_INLINE_RESULT = 'chosen_inline_result';
    public const CALLBACK_QUERY = 'callback_query';
    public const SHIPPING_QUERY = 'shipping_query';
    public const PRE_CHECKOUT_QUERY = 'pre_checkout_query';
    public const POLL = 'poll';
    public const POLL_ANSWER = 'poll_answer';
    public const MY_CHAT_MEMBER = 'my_chat_member';
    public const CHAT_MEMBER = 'chat_member';

    /**
     * @return array
     */
    public static function all(): array
    {
        return (new ReflectionClass(__CLASS__))->getConstants();
    }

    /**
     * @param  string  $type
     * @return string
     */
    public static function classOf(string $type): string
    {
        return match ($type) {
            self::MESSAGE => Message::class,
            self::EDITED_MESSAGE => EditedMessage::class,
            self::CHANNEL_POST => ChannelPost::class,
            self::EDITED_CHANNEL_POST => EditedChannelPost::class,
            self::INLINE_QUERY => InlineQuery::class,
            self::CHOSEN_INLINE_RESULT => ChosenInlineResult::class,
            self::CALLBACK_QUERY => CallbackQuery::class,
            self::SHIPPING_QUERY => ShippingQuery::class,
            self::PRE_CHECKOUT_QUERY => PreCheckoutQuery::class,
            self::POLL => Poll::class,
            self::POLL_ANSWER => PollAnswer::class,
            self::MY_CHAT_MEMBER, self::CHAT_MEMBER => ChatMemberUpdated::class,
        };
    }
}
