<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Telegram\Properties;

enum ChatShareThemeType: string
{
    case EMOJI = 'emoji';
    case UNIQUE_GIFT = 'unique_gift';
}
