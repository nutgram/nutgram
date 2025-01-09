<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Telegram\Properties;

enum ReactionTypeType: string
{
    case EMOJI = 'emoji';
    case CUSTOM_EMOJI = 'custom_emoji';
    case PAID = 'paid';
}
