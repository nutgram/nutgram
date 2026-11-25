<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Telegram\Properties;

enum EmojiTypeEmojiType: string
{
    case EMOJI = 'emoji';
    case CUSTOM_EMOJI = 'custom_emoji';
}
