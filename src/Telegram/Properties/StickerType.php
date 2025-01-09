<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Telegram\Properties;

enum StickerType: string
{
    case REGULAR = 'regular';
    case MASK = 'mask';
    case CUSTOM_EMOJI = 'custom_emoji';
}
