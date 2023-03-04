<?php

namespace SergiX44\Nutgram\Telegram\Enums;

enum UpdateTypes: string
{
    case MESSAGE = 'message';
    case EDITED_MESSAGE = 'edited_message';
    case CHANNEL_POST = 'channel_post';
    case EDITED_CHANNEL_POST = 'edited_channel_post';
    case INLINE_QUERY = 'inline_query';
    case CHOSEN_INLINE_RESULT = 'chosen_inline_result';
    case CALLBACK_QUERY = 'callback_query';
    case SHIPPING_QUERY = 'shipping_query';
    case PRE_CHECKOUT_QUERY = 'pre_checkout_query';
    case POLL = 'poll';
    case POLL_ANSWER = 'poll_answer';
    case MY_CHAT_MEMBER = 'my_chat_member';
    case CHAT_MEMBER = 'chat_member';
    case CHAT_JOIN_REQUEST = 'chat_join_request';
}
