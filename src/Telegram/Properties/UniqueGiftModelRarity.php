<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Telegram\Properties;

enum UniqueGiftModelRarity: string
{
    case UNCOMMON = 'uncommon';
    case RARE = 'rare';
    case EPIC = 'epic';
    case LEGENDARY = 'legendary';
}
