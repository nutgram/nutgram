<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Telegram\Properties;

enum ChatBoostSourceSource: string
{
    case PREMIUM = 'premium';
    case GIFT_CODE = 'gift_code';
    case GIVEAWAY = 'giveaway';
}
