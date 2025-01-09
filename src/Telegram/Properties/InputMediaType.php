<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Telegram\Properties;

enum InputMediaType: string
{
    case ANIMATION = 'animation';
    case DOCUMENT = 'document';
    case AUDIO = 'audio';
    case PHOTO = 'photo';
    case VIDEO = 'video';
}
