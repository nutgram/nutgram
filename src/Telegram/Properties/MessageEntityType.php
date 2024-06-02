<?php

namespace SergiX44\Nutgram\Telegram\Properties;

enum MessageEntityType: string
{
    case MENTION = 'mention';
    case HASHTAG = 'hashtag';
    case CASHTAG = 'cashtag';
    case BOT_COMMAND = 'bot_command';
    case URL = 'url';
    case EMAIL = 'email';
    case PHONE_NUMBER = 'phone_number';
    case BOLD = 'bold';
    case ITALIC = 'italic';
    case UNDERLINE = 'underline';
    case STRIKETHROUGH = 'strikethrough';
    case SPOILER = 'spoiler';
    case BLOCKQUOTE = 'blockquote';
    case EXPANDABLE_BLOCKQUOTE = 'expandable_blockquote';
    case CODE = 'code';
    case PRE = 'pre';
    case TEXT_LINK = 'text_link';
    case TEXT_MENTION = 'text_mention';
    case CUSTOM_EMOJI = 'custom_emoji';
}
