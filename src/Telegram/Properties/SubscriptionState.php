<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Telegram\Properties;

enum SubscriptionState: string
{
    case CANCELED = 'canceled';
    case ACTIVE = 'active';
    case FAILED = 'failed';
}
