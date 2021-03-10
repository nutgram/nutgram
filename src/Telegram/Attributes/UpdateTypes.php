<?php

namespace SergiX44\Nutgram\Telegram\Attributes;

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
     * @return string[]
     */
    public static function get(): array
    {
        return [
            self::MESSAGE,
            self::EDITED_MESSAGE,
            self::CHANNEL_POST,
            self::EDITED_CHANNEL_POST,
            self::INLINE_QUERY,
            self::CHOSEN_INLINE_RESULT,
            self::CALLBACK_QUERY,
            self::SHIPPING_QUERY,
            self::PRE_CHECKOUT_QUERY,
            self::POLL,
            self::POLL_ANSWER,
            self::MY_CHAT_MEMBER,
            self::CHAT_MEMBER,
        ];
    }
}
