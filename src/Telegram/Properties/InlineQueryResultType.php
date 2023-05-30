<?php

namespace SergiX44\Nutgram\Telegram\Properties;

enum InlineQueryResultType: string
{
    case ARTICLE = 'article';
    case AUDIO = 'audio';
    case CONTACT = 'contact';
    case GAME = 'game';
    case DOCUMENT = 'document';
    case GIF = 'gif';
    case LOCATION = 'location';
    case MPEG4_GIF = 'mpeg4_gif';
    case PHOTO = 'photo';
    case VENUE = 'venue';
    case VIDEO = 'video';
    case VOICE = 'voice';
    case STICKER = 'sticker';
}
