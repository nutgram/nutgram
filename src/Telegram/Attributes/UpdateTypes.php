<?php

namespace SergiX44\Nutgram\Telegram\Attributes;

class UpdateTypes extends BaseEnum
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
    public const CHAT_JOIN_REQUEST = 'chat_join_request';
}
