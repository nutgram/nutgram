<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Telegram\Properties;

enum InputPaidMediaType: string
{
    case PHOTO = 'photo';
    case VIDEO = 'video';
}
