<?php

namespace SergiX44\Nutgram\Telegram\Properties;

enum PaidMediaType: string
{
    case PREVIEW = 'preview';
    case PHOTO = 'photo';
    case VIDEO = 'video';
}
