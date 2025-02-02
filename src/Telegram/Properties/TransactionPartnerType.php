<?php

namespace SergiX44\Nutgram\Telegram\Properties;

enum TransactionPartnerType: string
{
    case FRAGMENT = 'fragment';
    case USER = 'user';
    case AFFILIATE_PROGRAM = 'affiliate_program';
    case TELEGRAM_ADS = 'telegram_ads';
    case TELEGRAM_API = 'telegram_api';
    case OTHER = 'other';
}
