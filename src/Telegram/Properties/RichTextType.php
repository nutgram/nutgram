<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Telegram\Properties;

enum RichTextType: string
{
    case BOLD = 'bold';
    case ITALIC = 'italic';
    case UNDERLINE = 'underline';
    case STRIKETHROUGH = 'strikethrough';
    case SPOILER = 'spoiler';
    case DATETIME = 'date_time';
    case TEXT_MENTION = 'text_mention';
    case SUBSCRIPT = 'subscript';
    case SUPERSCRIPT = 'superscript';
    case MARKED = 'marked';
    case CODE = 'code';
    case CUSTOM_EMOJI = 'custom_emoji';
    case MATHEMATICAL_EXPRESSION = 'mathematical_expression';
    case URL = 'url';
    case EMAIL_ADDRESS = 'email_address';
    case PHONE_NUMBER = 'phone_number';
    case BANK_CARD_NUMBER = 'bank_card_number';
    case MENTION = 'mention';
    case HASHTAG = 'hashtag';
    case CASHTAG = 'cashtag';
    case BOT_COMMAND = 'bot_command';
    case ANCHOR = 'anchor';
    case ANCHOR_LINK = 'anchor_link';
    case REFERENCE = 'reference';
    case REFERENCE_LINK = 'reference_link';
}
