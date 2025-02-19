<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Telegram\Properties;

enum PaidMediaType: string
{
    case PREVIEW = 'preview';
    case PHOTO = 'photo';
    case VIDEO = 'video';
}
