<?php

namespace SergiX44\Nutgram\Telegram\Properties;

enum TransactionPartnerType: string
{
    case FRAGMENT = 'fragment';
    case USER = 'user';
    case TELEGRAM_ADS = 'telegram_ads';
    case TELEGRAM_API = 'telegram_api';
    case OTHER = 'other';
}
