<?php

namespace SergiX44\Nutgram\Telegram\Properties;

enum InputPaidMediaType: string
{
    case PHOTO = 'photo';
    case LIVE_PHOTO = 'live_photo';
    case VIDEO = 'video';
}
