<?php

namespace SergiX44\Nutgram\Telegram\Properties;

enum InputMediaType: string
{
    case ANIMATION = 'animation';
    case AUDIO = 'audio';
    case DOCUMENT = 'document';
    case LIVE_PHOTO = 'live_photo';
    case LOCATION = 'location';
    case PHOTO = 'photo';
    case STICKER = 'sticker';
    case VENUE = 'venue';
    case VIDEO = 'video';
}
