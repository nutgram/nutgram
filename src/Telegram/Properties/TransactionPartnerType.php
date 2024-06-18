<?php

namespace SergiX44\Nutgram\Telegram\Properties;

enum TransactionPartnerType: string
{
    case FRAGMENT = 'fragment';
    case USER = 'user';
    case OTHER = 'other';
}
